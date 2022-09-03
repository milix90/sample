#!/usr/bin/bash

docker exec -it client_api sh -c "cp .env.example .env"
docker exec -it admin_consume sh -c "cp .env.example .env"

docker exec -it client_api sh -c "composer install"
docker exec -it client_api sh -c "php artisan migrate"
docker exec -it client_api sh -c "php artisan db:seed"
docker exec -it client_api sh -c "php artisan release:check"

docker exec -it admin_consume sh -c "composer install"
docker exec -it admin_consume sh -c "php artisan migrate"
