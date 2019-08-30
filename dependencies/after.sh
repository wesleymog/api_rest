#!/bin/bash
cd /var/www/html && composer update
cd /var/www/html && php artisan migrate:fresh --seed