#!/bin/bash

bold=$(tput bold)
normal=$(tput sgr0)

# Detect environment: Coder Workspace or local Sail
if [ -n "$CODER_WORKSPACE_NAME" ]; then
    ENV_TYPE="coder"
    echo -e "\n${bold}Detected Coder Workspace environment${normal}"
else
    ENV_TYPE="sail"
    echo -e "\n${bold}Detected local Sail environment${normal}"
fi

# Handle rebuild flag (only for Sail)
if [[ $1 == "--rebuild" ]] && [ "$ENV_TYPE" == "sail" ]; then
    vendor/bin/sail down -v --remove-orphans
fi

# Setup .env
if [ ! -f ./.env ]; then
    echo -e "\n${bold}> cp ./.env.example ./.env${normal}"
    cp ./.env.example ./.env
fi

# ============================================================
# CODER WORKSPACE SETUP
# ============================================================
if [ "$ENV_TYPE" == "coder" ]; then
    echo -e "\n${bold}Configuring for Coder Workspace (SQLite)${normal}"

    # Configure .env for SQLite
    sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
    sed -i 's/^DB_HOST=/#DB_HOST=/' .env
    sed -i 's/^DB_PORT=/#DB_PORT=/' .env
    sed -i 's/^DB_DATABASE=/#DB_DATABASE=/' .env
    sed -i 's/^DB_USERNAME=/#DB_USERNAME=/' .env
    sed -i 's/^DB_PASSWORD=/#DB_PASSWORD=/' .env

    # Create SQLite database
    touch database/database.sqlite

    # Generate app key if needed
    if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
        echo -e "\n${bold}> php artisan key:generate${normal}"
        php artisan key:generate --ansi
    fi

    # Run migrations
    echo -e "\n${bold}> php artisan migrate:fresh --seed${normal}"
    php artisan migrate:fresh --seed --force --no-interaction

    # Storage link
    echo -e "\n${bold}> php artisan storage:link${normal}"
    php artisan storage:link 2>/dev/null || true

    # Build frontend assets
    if [ -f package.json ]; then
        echo -e "\n${bold}> npm run build${normal}"
        npm run build
    fi

    echo -e "\n${bold}Done!${normal}"
    echo -e "Start the development server with:"
    echo -e "  ${bold}php artisan serve --host=0.0.0.0 --port=8000${normal}"
    echo -e "\nOr use the parallel dev workflow:"
    echo -e "  ${bold}composer dev${normal}"
    echo -e "\nRun tests in watch mode:"
    echo -e "  ${bold}./vendor/bin/pest --watch${normal}"
    echo -e "  or: ${bold}make test-dev${normal}"

# ============================================================
# SAIL (LOCAL DOCKER) SETUP
# ============================================================
else
    echo -e "\n${bold}> composer install (via Docker)${normal}"
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        composer install --ignore-platform-reqs

    echo -e "\n${bold}> sail build${normal}"
    vendor/bin/sail build

    echo -e "\n${bold}> sail up -d${normal}"
    vendor/bin/sail up -d

    source .env
    if [ "$APP_KEY" == "" ]; then
        echo -e "\n${bold}> sail artisan key:generate${normal}"
        vendor/bin/sail artisan key:generate
    fi

    echo -e "\n${bold}> sail artisan migrate:fresh --seed${normal}"
    vendor/bin/sail artisan migrate:fresh --seed --force --no-interaction

    echo -e "\n${bold}> sail npm install${normal}"
    vendor/bin/sail npm install

    echo -e "\n${bold}> sail npm run build${normal}"
    vendor/bin/sail npm run build

    echo -e "\n${bold}Done!${normal}"
    echo -e "You can now access your project at http://localhost"
    echo -e "\nDon't forget to run the command for all your development needs:"
    echo -e "${bold}sail composer dev${normal}"
fi