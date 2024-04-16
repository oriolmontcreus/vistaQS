#!/bin/bash

TARGET_USER="root"
TARGET_MACHINE="10.2.235.187"

clear
echo -e "\033[0;36m"
cat << "EOF"
         d8b          888              .d88888b.   .d8888b.  
         Y8P          888             d88P" "Y88b d88P  Y88b 
                      888             888     888 Y88b.      
888  888 888 .d8888b  888888  8888b.  888     888  "Y888b.   
888  888 888 88K      888        "88b 888     888     "Y88b. 
Y88  88P 888 "Y8888b. 888    .d888888 888 Y8b 888       "888 
 Y8bd8P  888      X88 Y88b.  888  888 Y88b.Y8b88P Y88b  d88P 
  Y88P   888  88888P'  "Y888 "Y888888  "Y888888"   "Y8888P"  
                                             Y8b                                                                          
EOF
echo -en "\033[0m"
echo -e "\033[0;36mBy Oriol Mont\033[0m"
echo -e "\033[0;31m"
cat << EOF
                            Step 1/3
                ┌─────────────────────────────┐
----  ----  ----│    Starting deployment to:  │----  ----  ----  
----  ----  ----│        $TARGET_MACHINE         │----  ----  ----  
                └─────────────────────────────┘                  
EOF
echo -en "\033[0m"

# Build the Angular project
cd "../Frontend"
ng build --configuration=production

# Convert the backend deployment script to Unix format
dos2unix "../Scripts/deploy_backend.sh"
dos2unix "../Scripts/start.sh"

# Transfer the built Angular app to the VM
echo -e "\033[0;36m[vistaQs] - Transfering built frontend to target machine...\033[0m"
scp -r "../Frontend/dist/frontend" $TARGET_USER@$TARGET_MACHINE:/home/omont/daw2/docker/frontend

# Transfer the backend deployment script and the final start script to the VM
echo -e "\033[0;36m[vistaQs] - Transfering deploy and start scripts to target machine...\033[0m"
scp -r "../Scripts/deploy_backend.sh" $TARGET_USER@$TARGET_MACHINE:/home/omont/daw2/docker
scp -r "../Scripts/start.sh" $TARGET_USER@$TARGET_MACHINE:/home/omont/daw2/docker

# Execute the backend deployment script on the VM
echo -e "\033[0;36m[vistaQs] - Executing backend deployment script inside target machine...\033[0m"
ssh $TARGET_USER@$TARGET_MACHINE "bash /home/omont/daw2/docker/deploy_backend.sh"