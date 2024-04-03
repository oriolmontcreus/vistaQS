#!/bin/bash

# Step 1: Build the Angular project
cd "../Frontend"
ng build --configuration=production

# Step 1.5: Convert the backend deployment script to Unix format
dos2unix "../Scripts/deploy_backend.sh"

# Step 2: Transfer the built Angular app to the VM
scp -r "../Frontend/dist/frontend" root@10.2.235.187:/home/omont/daw2/docker/frontend

# Step 3: Transfer the backend deployment script to the VM
scp -r "../Scripts/deploy_backend.sh" root@10.2.235.187:/home/omont/daw2/docker

scp -r "../Scripts/start.sh" root@10.2.235.187:/home/omont/daw2/docker

# Step 4: Execute the backend deployment script on the VM
ssh root@10.2.235.187 "bash /home/omont/daw2/docker/deploy_backend.sh"