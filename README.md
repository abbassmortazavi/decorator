<p align="center"><a href="https://laravel.com" target="_blank"></a> <b>Use Github Api Code Challenge</b>
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
step 4: in this .env.example i set my token and you can test it! 
```

## Project Host for test Api
```sh
like this : http://localhost:8082
this is my localhost in my system.
sample : http://localhost:8082/api/all-repo?user_name=abbassmortazavi
```

## Project Documentation Swagger
```sh
like this : http://localhost:8082/api/documentation#/
```

## Explain How to Run Command
```sh
if you run command you can write this : 
docker-compose run --rm artisan github:command --single
after run this in your terminal you see asking to you:
Which Command To Run?
this way you should be select one item and after you select command excute.
like this : 
 Which Command To Run?:
  [0] create
  [1] delete
 > 1
perfect!
also if you like run all you should use this command:
docker-compose run --rm artisan github:command
thats all.
```

