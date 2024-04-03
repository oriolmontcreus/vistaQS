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
cd ..
docker-compose build
docker-compose up -d

DOCKER_TARGET_CONTAINER=docker_backend_1

# Run start.sh script inside the Docker container
echo "Running start.sh script..."
docker cp ./start.sh $DOCKER_TARGET_CONTAINER:/var/www/html/start.sh
docker exec $DOCKER_TARGET_CONTAINER bash -c "/var/www/html/start.sh"