#!/bin/bash

# Get the directory of the script
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"

# Step 1: Build the Angular project
cd "$DIR/Frontend"
ng build --prod

# Step 2: Build the Laravel project
cd "$DIR/Backend"
composer install

# Step 3: Transfer the project files to the VM
rsync -avz -e ssh "$DIR" root@10.2.235.187:/home/omont/daw2/docker/Project

# Step 4: Connect to the VM and run the deployment script there
ssh root@10.2.235.187 << 'ENDSSH'
cd /home/omont/daw2/docker/Project
docker-compose build
docker-compose up -d
ENDSSH