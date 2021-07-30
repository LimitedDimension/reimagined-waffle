<p align="center">
</p>

<h3 align="center">Advertising campaign test application</h3>

---

<p align="center"> The application for managing advertising campaigns
    <br>
</p>

## Table of Contents
- [About](#about)
- [Getting Started](#getting_started)


## About <a name = "about"></a>
<p>
    Based on the technical documentation application purpose is very simple - just a list with options to ADD, PREVIEW and EDIT Advertising campaigns.
</p>
<p>
    As mentioned the appearance isn't perfect though i tried to add at least some kind of styling using material ui.
</p>
<p>
    The daily USD expenses calculated based on the days count and total budget so there's no option to set it manually.
</p>
<p>Caching is applied on the main page item list and resets after every ADD or EDIT operation or every 60 seconds.</p>

##  Getting Started <a name = "getting_started"></a>
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See [deployment](#deployment) for notes on how to deploy the project on a live system.

### Prerequisites
<p>The app was developed and tested with the next technologies and toolst</p>

```
    macOS Big Sur v11.4
    
    Laradock ( nGinx, MySQL, Redis, php8.0 )
    
    Npm v.6.14.13
    
    ReactJS
    
    JetBrains PHPStorm
```

### Installing

Clone the repository first.

<p>Using terminal navigate to <b>laradock</b> folder located in the root folder.</p>
<p>If for some reason you don't have laradock folder you can find it's installation instructions and source files here <a href="https://laradock.io">HERE</a>.</p>

<p>In laradock folder look for .env.example file. Copy it without .example part(.env) and make sure you have PHP_VERSION set to 8.0 (PHP_VERSION=8.0).</p>

<p>After that execute a docker command from the laradock folder</p>

```
docker-compose up -d nginx mysql redis workspace
```

<p>Also in the project root do the same thing with .env.example file located there. There's no need to specify PHP_VERSION there.</p>

<p>Wait until everything is downloaded and required containers are up.</p>

<p>When it's done just do</p>

```
docker exec -it laradock_workspace bin/bash
```

<p>If you change laradock folder's name to something else just look for the container name containing "workspace" word using</p>

```
docker ps
```

<p>Next we want to install all packages, run migrations and create a symlink for the app stirage</p>

```
composer install
npm install
php artisan storage:link
php artisan migrate
```

<p>In case you don't want to manually fill all records you can use seeder:</p>

```
php artisan db:seed
```

or

```
php artisan db:seed --class=AdSeeder
```

<p>Just keep in mind that application uses caching and you'll probably will have to wait for 60 seconds or create a new record to see any changes.</p>

<p>If there's a problem with DB connection try to change DB_DATABASE from "laravel" to "default" or vice versa in you root .env file.</p>

