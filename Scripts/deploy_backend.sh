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