# Employee App

## About EmployeeApp

Application that use PHP Laravel (v8) in the backend and Vue(with Vuetify) in the frontent and then docker (docker-compose) to build the environment. 

## Project setup
```
install docker
```

```
install docker-compose
```

```
git clone https://github.com/Kay05/employeeApp.git
```

```
cd backend 
```

```
cp .env.example .env
```
Basically copy the .env.example in the backend folder and create a .env file from it (in the same folder)
Return to the root folder for the rest of the commands

```
docker-compose up
```


## Things to look out for

Inital build will take some time as docker will use several images to build the environment

- [Api documentation](https://127.0.0.1:8000/api/documentation).

To add more employess quickly, you can run seed the database. Run the following commands:   

```
docker-compose exec web sh
```

```
php artisan db:seed --class=EmployeeSeeder
```
If you are having issues with docker the backend can run seperately if you have php 7.4 installed on your local machine

```
install composer
```

```
cd backend 
```

```
composer install
```

```
php artisan migrate
```

```
php artisan serve
```

For the frontend make sure you have node and npm installed

```
cd frontend
```

```
npm install
```

```
npm run serve
```

There are some tests (functional tests for php and unit tests for vue)
Please note that functional tests require a connection to be database

For backend
```
cd backend
```
Run
```
./vendor/bin/phpunit
```

And for frontend
```
cd frontend
```
Run
```
npm run test:unit  
```
