<h1>Little Laravel Project</h1>

<h3>Known Bugs</h3>
<p>- fetch for latest product state is buggy - some kind of randomness. Caching or query.<br>
- mobile not working properly<br>
- too much payload - PAGINATION!<br></p>

<h3>Description</h3>

The project should allow any user to track the price of an product on different vendor sites and to define an targetprice.
A cronjob driven crawler will check on a regulary base the state of the price and will sent an email if it's below or near the targetprice.

Steps to do:
- Allow adding products by just enter an amazon product url
- Frontend Polishing (more text and formattet timepoints in the correct timezones, pagination)
- Allow update of some product properties like targetprice, description etc.
- Support more then one vendor and remove testdata from others.
- Add Email notification (but before add basic user system)

<h3>Prerequisite</h3>

- Docker
- Docker-compose
- composer (2.1)

Check that your currentuser is part of the docker-group.

<b>For linux users</b>
```
whoami
sudo usermod -aG docker <user>
# Test with executing docker
docker
```

<b>For Mac users</b>
It seems that docker and all user are default in the staff group. So no changes seems to be necessary.
https://devilbox.discourse.group/t/is-adding-user-to-docker-group-still-needed-on-macos/391

<h3>Setup</h3>

To Setup the environment just execute buildApp.sh in the root directory.
Note: This is an development environment - so there are some php dependencies to install.

After startup the frontend application is available under localhost:4200 (0.0.0.0).

If Laravel is asking for an APP Key, don't excute artisan on your machine - generate the key inside your docker container:
```
docker-compose exec backend php artisan key:generate
docker-compose exec backend php artisan config:clear
docker-compose exec backend php artisan config:cache
```

<h3> Testdata </h3>

To add testdata execute:
```
./seedProducts.sh
```
<h3> Cronjob </h3>

The cronjob configuration is available under
```
/backend/schedule/cronjob
```
To deploy new configuration you have to rebuild the application via
```
./buildApp.sh
```
or just build the backend Docker via docker-compose. (sudo if the docker-compose deamon is not accessible from the current user=
```
docker-compose build backend
```

A work-in-progress testsite is available under https://php.lonl.at.
