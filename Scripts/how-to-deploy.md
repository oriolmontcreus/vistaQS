# Application Deployment Guide

This guide provides step-by-step instructions on how to deploy the application.

## Prerequisites

- You need to have a Bash terminal installed on your system.
- You need to have SSH access to the server where the application will be deployed.

## Deployment Steps

1. Open a Bash terminal.

2. Navigate to the `Scripts` directory:

    ```bash
    cd Scripts
    ```

3. Execute the `deploy.sh` script:

    ```bash
    ./deploy.sh
    ```

    This script performs the following tasks:

    - Builds the Angular project located in the `../Frontend` directory.
    - Converts the backend deployment script to Unix format using `dos2unix`.
    - Transfers the built Angular app to the VM at `root@10.2.235.187:/home/omont/daw2/docker/frontend` using `scp`.
    - Transfers the backend deployment script to the VM.

    Please note that the script assumes that the Angular project and the backend deployment script are located relative to the `Scripts` directory.

## Post-Deployment

After the script has finished running, the application should be deployed and running on the server. You can verify this by accessing the application's URL in a web browser.