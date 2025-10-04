#!/bin/sh
# Health check script for PHP-FPM

# Check if PHP-FPM is responding
if ! pgrep -x php-fpm > /dev/null; then
    echo "PHP-FPM is not running"
    exit 1
fi

# Try to connect to PHP-FPM
if ! cgi-fcgi -bind -connect 127.0.0.1:9000 > /dev/null 2>&1; then
    echo "Cannot connect to PHP-FPM"
    exit 1
fi

echo "Health check passed"
exit 0
