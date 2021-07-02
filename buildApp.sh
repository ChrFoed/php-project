#!/bin/sh

## Check if environemnt file exits
[ ! -f ".env" ] && echo "Environment '.env' file for docker-compose doesn't exist" && exit 2;

## Note: If an permission error occurs - check teh Readme for adding the current user to docker group
docker-compose down
## Install vendor files
composer install --working-dir=backend
## build docker environments
docker-compose up --build -d
## Start cron in backend container
docker exec backend cron
# Migrate Database
docker-compose exec backend php artisan migrate
