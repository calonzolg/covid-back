This project was bootstrapped with [Laravel Lumen](https://lumen.laravel.com/)

## Software requeriments

-   PHP >= 7.2
-   Composer

## Make your .env file 

Run the command in your terminal inside root of the project.

`cp .env.example .env`

## Run Composer

Run command 

`composer install` 

will install all dependencies

## Enter rapidapi key token

In the .env file for key `COVID_API_KEY_SECRET` need paste your secret key generate in the rapidapi platform

## Run the server 

Run command in the terminal for run the api 

`php -S localhost:8000 -t public`
