#!/bin/bash

# Install Git if it's not installed
if ! command -v git &> /dev/null
then
    apt-get update
    apt-get install -y git
fi

cd /home/omont/daw2/docker
# Remove the existing backend directory if it exists
rm -rf backend
git clone https://github.com/oriolmontcreus/01-Projecte-Intermodul backend
cd backend
git checkout main
composer install
cd ..
docker-compose build
docker-compose up -d

# Wait for the database service to be ready
sleep 20

# Run migrations and seeders
docker-compose exec -T app php artisan migrate --force
docker-compose exec -T app php artisan db:seed --force