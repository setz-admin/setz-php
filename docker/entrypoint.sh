#!/bin/sh

# Start PHP-FPM im Hintergrund
php-fpm &

# Start Nginx im Vordergrund (muss der letzte Befehl sein)
nginx -g "daemon off;"
