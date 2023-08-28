<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

- Laravel Framework 10.20.0
- MySQL 8.1.0

## Setup

Need docker installed in the environment. After installing docker, run the command in the project's command line

`docker compose up --build -d`

created .env

`cp .env.example .env`

Generay key:

`php artisan key:generate`

Containers created, enter the container and run the command to create migration and seeds.

a) Enter application container

`docker exec -it test_app bash`

b) Run the artisan command to create the migrations and seeds

`php artisan migrate --seed`

c) create symbolic link to save and map inserted images

`php artisan storage:link`

Generate swagger documentation

`php artisan l5-swagger:generate`

Unit Test

`php artisan test`

Access mysql in the container

`docker exec -it test_db bash`

Documentation to play around on local system and online

`http://localhost:8001/api/documentation`

`http://srv414158.hstgr.cloud:8001/api/documentation`

### Thanks! &#10084;

