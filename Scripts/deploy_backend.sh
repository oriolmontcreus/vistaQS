#!/bin/bash

echo -e "\033[0;31m"
cat << EOF
                            Step 2/3
                ┌─────────────────────────────┐
----  ----  ----│           Running           │----  ----  ----  
----  ----  ----│      deploy_backend.sh      │----  ----  ----  
                └─────────────────────────────┘                  
EOF
echo -en "\033[0m"

# Install Git if it's not installed
if ! command -v git &> /dev/null
then
        apt-get update
        apt-get install -y git
fi

cd /home/omont/daw2/docker
# Remove the existing backend directory if it exists
rm -rf backend

echo -e "\033[0;36m[vistaQs] - Cloning project to -> backend\033[0m"
git clone https://github.com/oriolmontcreus/vistaQS.git backend
cd backend
git checkout main
cd ..

echo -e "\033[0;36m[vistaQs] - Executing 'docker compose down'\033[0m"
docker-compose down

echo -e "\033[0;36m[vistaQs] - Executing 'docker compose build'\033[0m"
docker-compose build

echo -e "\033[0;36m[vistaQs] - Executing 'docker compose up'\033[0m"
docker-compose up -d

# Wait for the Docker container to be ready
echo -e "\033[0;36m[vistaQs] - Waiting for Docker container to be ready...\033[0m"
while [ "$(docker inspect -f {{.State.Running}} docker_backend_1)" != "true" ]; do
    sleep 1
done

# Run start.sh script inside the Docker container
docker cp ./start.sh docker_backend_1:/var/www/html/start.sh
docker exec docker_backend_1 bash -c "/var/www/html/start.sh"