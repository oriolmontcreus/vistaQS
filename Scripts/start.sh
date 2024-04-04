#!/bin/bash

echo -e "\033[1;33mRunning start.sh script...\033[0m"

cd /var/www/html/Backend
mv .env.example .env
composer install

# Run migrations
php artisan migrate --force

# Check if the database has been seeded
if [ "$(php artisan tinker --execute="return DB::table('seeded')->value('seeded');")" = "0" ]
then
    # Seed the database
    php artisan db:seed --force

    # Mark the database as seeded
    php artisan tinker --execute="DB::table('seeded')->insert(['seeded' => true]);"
fi

# Start the application
php artisan serve --host=0.0.0.0