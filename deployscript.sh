#!/bin/bash

SSH=""
PLUGIN_DIR="/www/Plugin/GrooaWidgets"

printf "Setting variables\n"

if [[ -z "${GROOA_SSH}" ]]; then
    echo "DEPLOYMENT ERROR: Missing env variable GROOA_SSH, for ssh address to production server"
    exit 1
else
    SSH="${GROOA_SSH}"
fi

SCP_DIR="${SSH}:${PLUGIN_DIR}"

##
# 1. Prepare to deploy
##

printf "\nBundling scripts\n\n"

# Prepare js
printf "Bundling JavaScript\n"
npm run deploy

##
# 2. Deploy
##

printf "\nCopying files over to server\n\n"

printf "\n\t root --> Server\n\n"
scp * ${SCP_DIR}/

# General static files
# Basically copy everything at root level
printf "\n\tassets/* --> Server/assets/* \n\n"
scp assets/* ${SCP_DIR}/assets/

# JavaScript
printf "\n\tassets/dist/ --> Server/assets/ \n\n"

scp -r assets/dist/ ${SCP_DIR}/assets/

# Setup
printf "\n\tSetup/ --> Server/ \n\n"
scp -r Setup/ ${SCP_DIR}/

# Setup
printf "\n\tview/ --> Server/ \n\n"
scp -r view/ ${SCP_DIR}/

# Widget
printf "\n\tWidget/ --> Server/ \n\n"
scp -r Widget/ ${SCP_DIR}/

printf "\n\nDeployment complete!\n"
