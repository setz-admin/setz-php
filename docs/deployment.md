# Deployment Dokumentation

## Self-hosted GitHub Actions Runner

### Installation auf mini (Intranet Server)

Der GitHub Actions Runner wurde auf dem Server `mini` eingerichtet, um automatische Deployments ins Intranet zu ermöglichen.

#### Standort
```
Server: mini
Verzeichnis: $HOME/setz-php-actions-runner
```

#### Installationsschritte

```bash
# 1. Runner herunterladen und entpacken
mkdir ~/setz-php-actions-runner && cd ~/setz-php-actions-runner
curl -o actions-runner-linux-x64-2.311.0.tar.gz -L \
  https://github.com/actions/runner/releases/download/v2.311.0/actions-runner-linux-x64-2.311.0.tar.gz
tar xzf ./actions-runner-linux-x64-2.311.0.tar.gz

# 2. Runner konfigurieren (mit GitHub Repository verbinden)
./config.sh --url https://github.com/USERNAME/setz-php --token TOKEN

# 3. Als Service installieren
./svc.sh install

# 4. Service starten
./svc.sh start
```

#### Service Management

```bash
# Status prüfen
./svc.sh status

# Service stoppen
./svc.sh stop

# Service neu starten
./svc.sh restart

# Service deinstallieren
./svc.sh uninstall
```

#### Runner-Labels

Der Runner ist mit folgenden Labels konfiguriert (standardmäßig):
- `self-hosted`
- `Linux`
- `X64`

Zusätzliche Labels können bei der Konfiguration mit `--labels` hinzugefügt werden:
```bash
./config.sh --url ... --token ... --labels intranet,production
```

### Workflow-Konfiguration

Der Deployment-Workflow `.github/workflows/deploy-intranet.yml` verwendet den self-hosted Runner:

```yaml
jobs:
  deploy:
    runs-on: self-hosted  # Verwendet den Runner auf mini
```

### Deployment-Prozess

1. **Trigger**: Push auf `main` Branch
2. **Tests laufen**: Alle CI-Workflows (SQLite, PostgreSQL, PHPStan, Pint)
3. **Bei Erfolg**: Deployment-Workflow startet auf self-hosted Runner
4. **Deployment**: Docker Compose auf mini wird aktualisiert

### Logs und Monitoring

Runner-Logs befinden sich in:
```
~/setz-php-actions-runner/_diag/
```

GitHub Actions Logs:
- Repository → Actions → Workflow-Run auswählen

### Sicherheit

- Runner läuft im User-Context (nicht als root)
- Nur Zugriff auf das konfigurierte Repository
- SSH/Webhook nicht erforderlich (direkter Zugriff vom Runner)

### Troubleshooting

#### Runner offline
```bash
cd ~/setz-php-actions-runner
./svc.sh status
./svc.sh start
```

#### Runner neu registrieren
```bash
./svc.sh stop
./svc.sh uninstall
./config.sh --url https://github.com/USERNAME/setz-php --token NEW_TOKEN
./svc.sh install
./svc.sh start
```

#### Neues Token generieren
GitHub → Repository Settings → Actions → Runners → New self-hosted runner

### Updates

Runner-Updates werden automatisch angewendet, wenn der Service läuft.

Manuelle Updates:
```bash
./svc.sh stop
# Neue Version herunterladen und entpacken
./svc.sh start
```
