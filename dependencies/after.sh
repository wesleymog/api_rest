#!/bin/bash
# Set permissions to storage and bootstrap cache
sudo mv oauth-private.key /var/www/html/storage/
sudo mv oauth-public.key /var/www/html/storage/
#
cd /var/www/html
#
# Run composer
composer  install --no-ansi --no-dev --no-suggest --no-interaction --no-progress --prefer-dist --no-scripts -d /var/www/html
#
# Run artisan commands
php /var/www/html/artisan migrate

php /var/www/html/artisan passport:install
