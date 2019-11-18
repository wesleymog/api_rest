#!/bin/bash
# Set permissions to storage and bootstrap cache
sudo chmod -R 0777 /var/www/html/storage
sudo chmod -R 0777 /var/www/html/bootstrap/cache
sudo cp oauth-private.key /tmp/
sudo cp oauth-public.key /tmp/
sudo rm -rf /var/www/html/storage/*
