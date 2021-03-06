#!/bin/bash

### Updates the website

# web-code directory
webdir="/var/www/html/"

# Pull a fresh copy from the repo, overwriting all local changes
git fetch --all
git reset --hard origin/main

# Copy the files to the web-code dir
/bin/cp --recursive --force ../../src/* $webdir

/bin/cp --recursive --force ../../dependencies/leaflet/* $webdir
/bin/cp --recursive --force ../../dependencies/openpgpjs/* $webdir