#!/bin/bash
cd /var/www/html && composer install
cd /var/www/html && php artisan migrate::fresh --seed