#!/bin/sh

## Note: If you install docker & docker-compose for the right user - delete sudo

## Install vendor files
composer install --working-dir=backend
## build docker environments
sudo docker-compose up --build -d
## Start cron in backend container
sudo docker exec backend cron
