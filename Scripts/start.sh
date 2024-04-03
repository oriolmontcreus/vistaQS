#!/bin/bash

echo "test"

cd /var/www/html/Backend

pwd

ls -lisa

composer install

# Run migrations
php artisan migrate --force

# Seed the database
php artisan db:seed --force

# Start the application
php artisan serve --host=0.0.0.0