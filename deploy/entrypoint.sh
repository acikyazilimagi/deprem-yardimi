#!/bin/bash

set -e

cd /var/www && true

# https://stackoverflow.com/a/33427572

php artisan config:cache || :
php artisan event:cache || :
php artisan package:discover || :
php artisan route:cache || :
php artisan view:cache || :

php-fpm -D
nginx -g "daemon off;"

