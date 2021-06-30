<h1>Little Laravel Project</h1>

<h3>Description</h3>

The project should allow any user to track the price of an product on different vendor sites and to define an targetprice.
A cronjob driven crawler will check on a regulary base the state of the price and will sent an email if it's below or near the targetprice.

<h3>Prerequisite</h3>

- Docker
- Docker-compose

<h3>Setup</h3>

If Laravel is asking for an APP Key, don't excute artisan on your machine - generate the key inside your docker container:
```
docker-compose exec backend php artisan key:generate
docker-compose exec backend php artisan config:clear
docker-compose exec backend php artisan config:cache
```
