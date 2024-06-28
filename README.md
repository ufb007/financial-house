# Financial House Take Home Task

## Features used
    - Laravel Sail
    - Laravel `breeze` template
    - Inertia
    - Vue3
    - Pest (Unit Testing)

Install backend dependencies

```
composer install
```

## Environment file

copy file `.env.example` and change to `.env`

## Migrate database tables

```
./vendor/bin/sail artisan migrate
```

## Run docker containers

Two containers, one for application and one for database

```
docker-compose up -d
```

## Install Front-End dependencies

```
npm install
```

Run the `build` script to compile the front-end

```
npm run build
```

Run the Vite dev command (allows to make changes to Vue code)

```
npm run dev
```

Open http://localhost in browser and you should see the login page

## Register a new user

Register a user for login (click on the register link or go to link below)

```
http://localhost/register
```

Once registration is successful, you will be automically logged in and directed to the Dashboard.

## Testing

To run tests:

```
php artisan test
```