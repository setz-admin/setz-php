#!/bin/bash
###############################################################################
# Smoke System Test - setz-php Docker Container
#
# Dieses Skript führt umfassende Smoke-Tests für den setz-php Docker Container
# durch, um sicherzustellen, dass alle Komponenten korrekt funktionieren.
#
# Usage: ./smoke_system_test.sh [OPTIONS]
#
# Options:
#   -c, --container NAME    Container-Name (default: setz-php-test)
#   -p, --port PORT         HTTP Port (default: 8080)
#   -h, --host HOST         Host (default: localhost)
#   --help                  Diese Hilfe anzeigen
#
# Exit Codes:
#   0 - Alle Tests erfolgreich
#   1 - Ein oder mehrere Tests fehlgeschlagen
#
###############################################################################

set -euo pipefail

# Farben für Ausgabe
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Standardwerte
CONTAINER_NAME="${CONTAINER_NAME:-setz-php-test}"
HTTP_PORT="${HTTP_PORT:-8080}"
HOST="${HOST:-localhost}"
BASE_URL="http://${HOST}:${HTTP_PORT}"

# Zähler
TESTS_TOTAL=0
TESTS_PASSED=0
TESTS_FAILED=0

###############################################################################
# Hilfsfunktionen
###############################################################################

print_header() {
    echo ""
    echo -e "${BLUE}═══════════════════════════════════════════════════════════════${NC}"
    echo -e "${BLUE}  $1${NC}"
    echo -e "${BLUE}═══════════════════════════════════════════════════════════════${NC}"
    echo ""
}

print_test() {
    echo -n "  ► $1 ... "
    TESTS_TOTAL=$((TESTS_TOTAL + 1))
}

print_success() {
    echo -e "${GREEN}✓ OK${NC}"
    TESTS_PASSED=$((TESTS_PASSED + 1))
}

print_failure() {
    echo -e "${RED}✗ FEHLER${NC}"
    if [ -n "${1:-}" ]; then
        echo -e "    ${RED}Grund: $1${NC}"
    fi
    TESTS_FAILED=$((TESTS_FAILED + 1))
}

print_warning() {
    echo -e "${YELLOW}⚠ WARNUNG${NC}"
    if [ -n "${1:-}" ]; then
        echo -e "    ${YELLOW}$1${NC}"
    fi
}

print_info() {
    echo -e "    ${BLUE}ℹ $1${NC}"
}

print_summary() {
    echo ""
    echo -e "${BLUE}═══════════════════════════════════════════════════════════════${NC}"
    echo -e "${BLUE}  ZUSAMMENFASSUNG${NC}"
    echo -e "${BLUE}═══════════════════════════════════════════════════════════════${NC}"
    echo ""
    echo "  Gesamt Tests:      $TESTS_TOTAL"
    echo -e "  ${GREEN}Erfolgreich:       $TESTS_PASSED${NC}"

    if [ $TESTS_FAILED -gt 0 ]; then
        echo -e "  ${RED}Fehlgeschlagen:    $TESTS_FAILED${NC}"
    else
        echo -e "  ${GREEN}Fehlgeschlagen:    $TESTS_FAILED${NC}"
    fi

    echo ""

    if [ $TESTS_FAILED -eq 0 ]; then
        echo -e "${GREEN}✓ Alle Tests erfolgreich!${NC}"
        return 0
    else
        echo -e "${RED}✗ $TESTS_FAILED Test(s) fehlgeschlagen!${NC}"
        return 1
    fi
}

###############################################################################
# Test-Funktionen
###############################################################################

test_container_running() {
    print_test "Container '$CONTAINER_NAME' läuft"

    if docker ps --format '{{.Names}}' | grep -q "^${CONTAINER_NAME}$"; then
        local status=$(docker inspect --format='{{.State.Status}}' "$CONTAINER_NAME")
        if [ "$status" = "running" ]; then
            print_success
            local uptime=$(docker inspect --format='{{.State.StartedAt}}' "$CONTAINER_NAME")
            print_info "Status: running, gestartet: $uptime"
        else
            print_failure "Status: $status"
        fi
    else
        print_failure "Container nicht gefunden oder nicht gestartet"
    fi
}

test_processes() {
    print_test "PHP-FPM Prozess läuft"

    # BusyBox pgrep unterstützt nicht -c, daher manuell zählen
    local php_count=$(docker exec "$CONTAINER_NAME" sh -c 'pgrep php-fpm 2>/dev/null | wc -l' || echo "0")
    if [ "$php_count" -gt 0 ]; then
        print_success
        print_info "PHP-FPM Prozesse: $php_count"
    else
        print_failure "Keine PHP-FPM Prozesse gefunden"
    fi

    print_test "Nginx Prozess läuft"

    # BusyBox pgrep unterstützt nicht -c, daher manuell zählen
    local nginx_count=$(docker exec "$CONTAINER_NAME" sh -c 'pgrep nginx 2>/dev/null | wc -l' || echo "0")
    if [ "$nginx_count" -gt 0 ]; then
        print_success
        print_info "Nginx Prozesse: $nginx_count"
    else
        print_failure "Keine Nginx Prozesse gefunden"
    fi
}

test_http_endpoint() {
    local url="$1"
    local expected_status="$2"
    local description="$3"

    print_test "$description"

    local http_code=$(curl -s -o /dev/null -w '%{http_code}' "$url" 2>/dev/null || echo "000")

    if [ "$http_code" = "$expected_status" ]; then
        print_success
        local content_type=$(curl -s -o /dev/null -w '%{content_type}' "$url" 2>/dev/null)
        local time_total=$(curl -s -o /dev/null -w '%{time_total}' "$url" 2>/dev/null)
        print_info "HTTP $http_code, Content-Type: $content_type, Zeit: ${time_total}s"
    else
        print_failure "HTTP $http_code (erwartet: $expected_status)"
    fi
}

test_homepage() {
    print_test "Homepage lädt (HTTP 200)"

    local http_code=$(curl -s -o /dev/null -w '%{http_code}' "$BASE_URL/" 2>/dev/null || echo "000")

    if [ "$http_code" = "200" ]; then
        print_success

        # Response-Zeit messen
        local time_total=$(curl -s -o /dev/null -w '%{time_total}' "$BASE_URL/" 2>/dev/null)
        print_info "Response-Zeit: ${time_total}s"

        # Prüfen ob HTML zurückkommt
        local content=$(curl -s "$BASE_URL/" 2>/dev/null | head -c 100)
        if echo "$content" | grep -q "<!DOCTYPE"; then
            print_info "HTML-Content erkannt"
        fi
    else
        print_failure "HTTP $http_code (erwartet: 200)"
    fi
}

test_static_files() {
    # Favicon
    test_http_endpoint "$BASE_URL/favicon.ico" "200" "Favicon wird ausgeliefert"

    # Robots.txt
    test_http_endpoint "$BASE_URL/robots.txt" "200" "robots.txt wird ausgeliefert"

    # CSS Assets
    print_test "CSS Assets werden ausgeliefert"
    local css_files=$(curl -s "$BASE_URL/" | grep -o '/build/assets/app-[^"]*\.css' | head -1)
    if [ -n "$css_files" ]; then
        local css_url="$BASE_URL$css_files"
        local http_code=$(curl -s -o /dev/null -w '%{http_code}' "$css_url" 2>/dev/null || echo "000")
        if [ "$http_code" = "200" ]; then
            print_success
            print_info "CSS: $css_files"
        else
            print_failure "HTTP $http_code für $css_files"
        fi
    else
        print_failure "Keine CSS-Dateien im HTML gefunden"
    fi

    # JavaScript Assets
    print_test "JavaScript Assets werden ausgeliefert"
    local js_files=$(curl -s "$BASE_URL/" | grep -o '/build/assets/app-[^"]*\.js' | head -1)
    if [ -n "$js_files" ]; then
        local js_url="$BASE_URL$js_files"
        local http_code=$(curl -s -o /dev/null -w '%{http_code}' "$js_url" 2>/dev/null || echo "000")
        if [ "$http_code" = "200" ]; then
            print_success
            print_info "JS: $js_files"
        else
            print_failure "HTTP $http_code für $js_files"
        fi
    else
        print_failure "Keine JS-Dateien im HTML gefunden"
    fi

    # Bilder im img/ Verzeichnis
    print_test "Bilder werden ausgeliefert"
    local img_files=$(docker exec "$CONTAINER_NAME" ls /var/www/html/public/img/ 2>/dev/null | head -1)
    if [ -n "$img_files" ]; then
        local img_url="$BASE_URL/img/$img_files"
        local http_code=$(curl -s -o /dev/null -w '%{http_code}' "$img_url" 2>/dev/null || echo "000")
        if [ "$http_code" = "200" ]; then
            print_success
            print_info "Bild: /img/$img_files"
        else
            print_failure "HTTP $http_code für /img/$img_files"
        fi
    else
        print_warning "Keine Bilder im img/ Verzeichnis gefunden"
    fi
}

test_health_endpoints() {
    test_http_endpoint "$BASE_URL/health" "200" "Nginx Health-Endpoint"
}

test_env_mounted() {
    print_test ".env Datei ist gemountet"

    if docker exec "$CONTAINER_NAME" test -f /var/www/html/.env 2>/dev/null; then
        print_success
        local app_name=$(docker exec "$CONTAINER_NAME" grep "^APP_NAME=" /var/www/html/.env 2>/dev/null | cut -d'=' -f2)
        if [ -n "$app_name" ]; then
            print_info "APP_NAME: $app_name"
        fi
    else
        print_failure ".env Datei nicht gefunden"
    fi
}

test_laravel_config() {
    print_test "Laravel Konfiguration ist gültig"

    local config_check=$(docker exec "$CONTAINER_NAME" php artisan config:show app.name 2>&1 || echo "error")

    if [ "$config_check" != "error" ] && [ -n "$config_check" ]; then
        print_success
        print_info "App Name: $(echo "$config_check" | tail -1)"
    else
        print_failure "Konfiguration kann nicht gelesen werden"
    fi
}

test_storage_permissions() {
    print_test "Storage-Verzeichnis hat korrekte Permissions"

    local storage_writable=$(docker exec "$CONTAINER_NAME" test -w /var/www/html/storage && echo "yes" || echo "no")

    if [ "$storage_writable" = "yes" ]; then
        print_success
        local perms=$(docker exec "$CONTAINER_NAME" stat -c '%a' /var/www/html/storage 2>/dev/null || echo "unknown")
        print_info "Permissions: $perms"
    else
        print_failure "Storage-Verzeichnis nicht beschreibbar"
    fi
}

test_no_errors_in_logs() {
    print_test "Keine kritischen Fehler in Laravel-Logs"

    local log_file="/var/www/html/storage/logs/laravel.log"

    if docker exec "$CONTAINER_NAME" test -f "$log_file" 2>/dev/null; then
        # Nur nach CRITICAL und EMERGENCY suchen (nicht ERROR, da diese bei normalem Betrieb auftreten können)
        local critical_count=$(docker exec "$CONTAINER_NAME" grep -c "CRITICAL\|EMERGENCY" "$log_file" 2>/dev/null || echo "0")

        if [ "$critical_count" = "0" ]; then
            print_success
            print_info "Keine kritischen Fehler gefunden"
        else
            print_warning "$critical_count kritische Fehler in Logs gefunden"
        fi
    else
        print_info "Keine Log-Datei vorhanden (möglicherweise frischer Container)"
        TESTS_PASSED=$((TESTS_PASSED + 1))
    fi
}

###############################################################################
# Hauptprogramm
###############################################################################

main() {
    # Parameter parsen
    while [[ $# -gt 0 ]]; do
        case $1 in
            -c|--container)
                CONTAINER_NAME="$2"
                shift 2
                ;;
            -p|--port)
                HTTP_PORT="$2"
                BASE_URL="http://${HOST}:${HTTP_PORT}"
                shift 2
                ;;
            -h|--host)
                HOST="$2"
                BASE_URL="http://${HOST}:${HTTP_PORT}"
                shift 2
                ;;
            --help)
                grep '^#' "$0" | grep -v '#!/bin/bash' | sed 's/^# //' | sed 's/^#//'
                exit 0
                ;;
            *)
                echo "Unbekannte Option: $1"
                echo "Verwenden Sie --help für Hilfe"
                exit 1
                ;;
        esac
    done

    print_header "SETZ-PHP SMOKE SYSTEM TEST"

    echo "  Container:    $CONTAINER_NAME"
    echo "  Base URL:     $BASE_URL"
    echo "  Test-Zeit:    $(date '+%Y-%m-%d %H:%M:%S')"
    echo ""

    # Tests ausführen
    print_header "1. CONTAINER & PROZESSE"
    test_container_running
    test_processes

    print_header "2. KONFIGURATION & DATEISYSTEM"
    test_env_mounted
    test_laravel_config
    test_storage_permissions

    print_header "3. HTTP ENDPOINTS"
    test_homepage
    test_health_endpoints

    print_header "4. STATISCHE DATEIEN"
    test_static_files

    print_header "5. LOGS & FEHLER"
    test_no_errors_in_logs

    # Zusammenfassung
    print_summary

    return $?
}

# Skript ausführen
main "$@"
