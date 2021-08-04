#!/bin/bash

# add dependencies
# composer install

# Apply database migrations
echo "Apply database migrations and seeds"
php artisan migrate
php artisan db:seed

echo "clear cache"
php artisan cache:clear
php artisan config:clear

php artisan l5-swagger:generate 

# tail -f /dev/null

# Start server
echo "Starting server"
php artisan serve --host=0.0.0.0 --port=80