#!/bin/bash

echo -e "\033[0;31m"
cat << EOF
                            Step 3/3
                ┌─────────────────────────────┐
----  ----  ----│           Running           │----  ----  ----  
----  ----  ----│           start.sh          │----  ----  ----  
                └─────────────────────────────┘                  
EOF
echo -en "\033[0m"

cd /var/www/html/Backend
mv .env.example .env
composer install

# Run migrations
echo -e "\033[0;36m[vistaQs] - Running database migrations\033[0m"
php artisan migrate --force

echo -e "\033[0;36m[vistaQs] - Checking if database hasn't been seeded yet and seeding if not\033[0m"
# Check if the database has been seeded
if [ "$(php artisan tinker --execute="return DB::table('seeded')->value('seeded');")" = "0" ]
then
    # Seed the database
    php artisan db:seed --force

    # Mark the database as seeded
    php artisan tinker --execute="DB::table('seeded')->insert(['seeded' => true]);"
fi

# Start the application
echo -e "\033[0;36m[vistaQs] - Starting backend service on host 0.0.0.0\033[0m"
php artisan serve --host=0.0.0.0