docker-compose exec backend php artisan migrate:fresh
docker-compose exec backend php artisan -v db:seed --class=ProductsSeeder
