#!/bin/bash
# Set permissions to storage and bootstrap cache
 chmod -R 0777 /var/www/html/storage
 chmod -R 0777 /var/www/html/storage/framework/cache/data
 chmod -R 0777 /var/www/html/bootstrap/cache
 sudo cp /var/www/html/save/oauth-private.key /var/www/html/storage/
 sudo cp /var/www/html/save/oauth-public.key /var/www/html/storage/
#
cd /var/www/html
#
# Run composer
composer  install --no-ansi --no-dev --no-suggest --no-interaction --no-progress --prefer-dist --no-scripts -d /var/www/html
#
# Run artisan commands
php /var/www/html/artisan migrate

#php /var/www/html/artisan passport:install
