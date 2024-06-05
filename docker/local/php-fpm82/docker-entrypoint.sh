#!/bin/sh
set -e

# Run Composer install to install vendor dependencies
composer install --no-interaction --no-progress --optimize-autoloader

# Run cache:clear to clear the cache
composer run-script cache:clear

exec php-fpm