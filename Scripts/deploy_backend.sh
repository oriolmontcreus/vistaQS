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

# Wait for the Docker container to be ready
echo "Waiting for Docker container to be ready..."
while [ "$(docker inspect -f {{.State.Running}} docker_backend_1)" != "true" ]; do
    sleep 1
done

# Run start.sh script inside the Docker container
echo "Running start.sh script..."
docker cp ./start.sh docker_backend_1:/var/www/html/start.sh
docker exec docker_backend_1 bash -c "/var/www/html/start.sh"