## Install Application

# Features used
    - Laravel Sail
    - Inertia
    - Vue3
    - Pest (Unit Testing)

Install backend dependencies install

```
composer install
```

Migrate database tables

```
./vendor/bin/sail artisan migrate
```

Run docker containers

```
docker-compose up -d
```

Install Front-End dependencies

```
npm install
```

Run the `build` script to comile the front-end

```
npm run build
```

Open http://localhost in browser and you should see the login page

Register a user for login (click on the register link or go to link below)

```
http://localhost/register
```

Once registration is successful, you will be automically logged in and directed to the Dashboard.
