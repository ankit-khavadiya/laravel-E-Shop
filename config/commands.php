<?php

/* --- Git commands --- */

// clone repo :- git clone -b dev_ankit repo_link


/* --- Create Laravel project --- */

// Global installation
// 1. composer global require laravel/installer
// 2. laravel new example-app

// per project installation
// 1. composer create-project laravel/laravel app-name



/* --- Composer commands --- */

// composer install
// if we have run old project(like get by github) then run this commands
// composer update --ignore-platform-reqs   // If you face php version issue then use this command
// php artisan key:generate
// cp .env.example .env
// php artisan migrate --database=mysql_react --seed
// php artisan migrate:fresh --seed



/* --- Clear cache --- */

// php artisan cache:clear
// php artisan view:cache
// php artisan view:clear
// php artisan config:cache
// php artisan config:clear
// php artisan event:cache
// php artisan event:clear
// php artisan route:cache
// php artisan route:clear



/* --- Controller --- */

// Create controller :- php artisan make:controller web/HomeController
// Create controller with CRUD operation :- php artisan make:controller PostController --resource
// Single Action Controller(method for a single logical operation) :- php artisan make:controller ProvisionServer --invocable



/* --- Migration Commands --- */

// Create migration :- php artisan make:migration create_admins_table
// Run :- php artisan migrate
// Specific one table migrate :- php artisan migrate --path=/database/migrations/your_migration_file_name.php
// Update an Existing Table(add column) :- php artisan make:migration add_column_to_users_table --table=users
// Refresh (Reset and Re-run) One Table :- php artisan migrate:refresh --path=/database/migrations/your_migration_file_name.php

// 2. Run Migrations
// Run all pending migrations :- php artisan migrate
// Run migrations in isolation (per file) :- php artisan migrate --step
// Preview SQL without running :- php artisan migrate --pretend

// 3. Rollback & Undo Changes
// Rollback last batch :- php artisan migrate:rollback
// Rollback multiple batches :- php artisan migrate:rollback --step=3
// Reset all migrations :- php artisan migrate:reset (deletes all tables and data)

// 4. Refresh & Fresh Commands
// Rollback and re-run all :- php artisan migrate:refresh
// Drop all tables and re-run all :- php artisan migrate:fresh
// Refresh with seeders :- php artisan migrate:refresh --seed

// 5. Utility & Status Commands
// Check migration status :- php artisan migrate:status
// Create a model with migration :- php artisan make:model Post -m (creates both at once)



/* --- Models --- */

// Create model :- php artisan make:model Admin

// Generate a model with migration :- php artisan make:model Flight --migration or --m

// Generate a model and a FlightFactory class...
// php artisan make:model Flight --factory
// php artisan make:model Flight -f

// Generate a model and a FlightSeeder class...
// php artisan make:model Flight --seed
// php artisan make:model Flight -s

// Generate a model and a FlightController class...
// php artisan make:model Flight --controller
// php artisan make:model Flight -c

// Generate a model, FlightController resource class, and form request classes...
// php artisan make:model Flight --controller --resource --requests
// php artisan make:model Flight -crR

// Generate a model and a FlightPolicy class...
// php artisan make:model Flight --policy

// Generate a model and a migration, factory, seeder, and controller...
// php artisan make:model Flight -mfsc

// Shortcut to generate a model, migration, factory, seeder, policy, controller, and form requests...
// php artisan make:model Flight --all
// php artisan make:model Flight -a

// Generate a pivot model...
// php artisan make:model Member --pivot
// php artisan make:model Member -p



/* --- Seeder --- */

// Create Command :- php artisan make:seeder UserSeeder
// Runs the default DatabaseSeeder class :- php artisan db:seed
// Executes only the specified seeder class :- php artisan db:seed --class=UserSeeder
// php artisan db:seed --force



/* --- Middleware --- */

// php artisan make:middleware EnsureTokenIsValid

// note :-
// I have all common middleware implement in this project look in app/Htto/Middleware
// most use two :- Authenticate and RedirectIfAuthenticated
//  Implementing & Registering Middleware : bootstrap/app.php
    /*->withMiddleware(function (Middleware $middleware): void {
            $middleware->alias([
                'guest' => RedirectIfAuthenticated::class,
                'auth' => Authenticate::class,
            ]);
        }) */



/* --- Provider --- */

// Create service :- php artisan make:provider RouteServiceProvider



/* --- Helper file --- */

// if you are add helper file then define this code in composer.json in autoload:
/* "files": [
         "app/Http/Helpers/helper.php"
     ], */



/* --- Api --- */

// Implement Api :- php artisan install:api
// Controller create for api :- php artisan make:controller api/v1/OpenController
// Create controller with crud operation :- php artisan make:controller PostController --api

// notes :-
// if we have creat api then you can create controller in api/v1/ControllerName(because it's common structure)...
// If we have api parsing then we need to implement controller in web/ or admin/ controller implement...
// Api routes create in api.php ,it is auto create if you run php artisan install:api command



/* --- Mail --- */

// php artisan make:mail WelcomeMail

// write in .env
// MAIL_MAILER=smtp
// MAIL_SCHEME=null
// MAIL_HOST=smtp.gmail.com
// MAIL_PORT=587
// MAIL_USERNAME="<EMAIL>"
// MAIL_PASSWORD="<APP PASS GENERATED FROM THE G-MAIL>"



/* --- Yajra Datatable --- */

// Install composer package :- composer require yajra/laravel-datatables-oracle:"^12.0"
// I have already use in this demo project



/* --- JWT authentication --- */

// Install package :- composer require php-open-source-saver/jwt-auth
// Publish the config :- php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
// Generate the JWT secret key :- php artisan jwt:secret



/* --- AI implement(AI SDk) --- */

// Ai sdk :- composer require laravel/ai

// Publish configuration and run migrations :-
// php artisan vendor:publish --provider="Laravel\Ai\AiServiceProvider"
// php artisan migrate

// Add in .env :- GEMINI_API_KEY=your_api_key_here

// if you need only gemini then :-
// composer require google-gemini-php/laravel
// php artisan gemini:install
// GEMINI_API_KEY=your_api_key_here



/* --- Implement Google login --- */

// install package :- composer require kreait/laravel-firebase

// Note :-
// open Firebase and create new project as you project name then go to settings->general then copy pest script as you need
// Then goto settings->service account and Generate new private key,that json file use it
// Then goto Security->Authentication->sing-in method then add google provider, here you will add all social platforms for social login



/* --- Implement Facebook login --- */

// Note :-
// same process as google login for firebase, if you have implement both login google and facebook then json or other firebase script use once
// Also need create app key and secret key by https://developers.facebook.com/

