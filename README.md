# Acid Studios Laravel Template
This repository contains a template used in [Acid Studios](http://www.acidstudios.me) to create Rest API's for our php projects.

To start using this template, clone the repository;
```bash
git clone https://github.com/acidstudios/laravel.git
composer install
```

Or create a new project using composer:
```bash
composer create-project --prefer-dist acidstudios/laravel
```
It will install all dependencies used in the template.

Then, run this command:
To start using this template;
```bash
php artisan api:install
```
This command will run all existing migrations and seeders.

You can start your project from now, don't forget to setup your .env file and your [Sentry.io](http://www.sentry.io) API Key.