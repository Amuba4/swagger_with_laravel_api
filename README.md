# swagger_with_laravel_api

Steps to install swagger in your laravel project 
1)install swagger 
composer require "darkaonline/swagger-lume:5.6.*"

2) Open your bootstrap/app.php file and uncomment $app->withFacades(); this line

3) add this line before Register Container Bindings section:
     $app->configure('swagger-lume');
4) add this line in Register Service Providers section:
 $app->register(\SwaggerLume\ServiceProvider::class);
5) Run php artisan swagger-lume:publish-config to publish configs (config/swagger-lume.php)

6) Run php artisan swagger-lume:publish to publish everything

Our swagger installation is done now it’s time to install OpenApi 3.0 specification

1) composer require 'zircote/swagger-php:3.*'

2) Set environment variable in .env file


SWAGGER_GENERATE_ALWAYS=true
SWAGGER_VERSION=3.0


3) Run php artisan swagger-lume:publish-config to publish configs

4) Run php artisan swagger-lume:publish-views to publish views (resources/views/vendor/swagger-lume)

5) Run php artisan swagger-lume:publish to publish everything

6) In lumen swagger UI assets are missing for that you need to run below commands (imp step)
mkdir public/swagger-ui-assets
cp vendor/swagger-api/swagger-ui/dist/* public/swagger-ui-assets
7) Run php artisan swagger-lume:generate to generate docs

8) then run your project
php -S localhost:8000 -t public

run http://localhost:8000/api/documentation in your browser 



