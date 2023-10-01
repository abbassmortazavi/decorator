<p align="center"><a href="https://laravel.com" target="_blank"></a> <b>Project Instruction</b>
<p align="center">

</p>



## Services
- Nginx
- Redis
- Mysql
- PHP (8.1.12)
- PhpMyAdmin
- Composer
- Npm
- Artisan
- Cron
- Swagger(for api documentation)
- DDD(Domain Driven Design)

## Installation
```sh
docker-compose up -d --build
docker-compose up -d down
```

## Migrate
```sh
docker-compose run --rm artisan migrate
```

## Composer update or Install
```sh
docker-compose run --rm composer i
docker-compose run --rm composer u
```

## Start and Stop Cron Job
```sh
docker-compose start cron
docker-compose stop cron
```

## Npm Install
```sh
docker-compose run --rm npm i
```

## Config Env file in laravel after build docker
```sh
step 1 : run this command: cp .env.example .env
step 2 : docker-compose run --rm artisan key:generate
step 3 : docker-compose run --rm artisan optimize
```

## Project Host for test Api
```sh
like this : http://localhost:8082
this is my localhost in my system.
sample : http://localhost:8082/api/products
```

## Project Documentation Swagger
```sh
like this : http://localhost:8082/api/documentation/
```

