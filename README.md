# Project Setup Guide
This project uses Docker and Laravel. Follow the steps below to set up and run the application locally.

## Installation & Setup
Copy the environment file:
```
    cp .env.example .env
```

## Start Docker containers
Build and start the containers in detached mode:
```
    docker-compose up -d --build
```

## Install dependencies
Access the application container:
```
    docker-compose exec app bash
```

Inside the container, run:
```
    composer install
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
```

## Set file permissions
Ensure correct permissions for Laravel directories:
```
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R 775 storage bootstrap/cache
```

## Database seeding (users and products)
If needed, you can re-run database seeders:
```
    php artisan db:seed
```

## Application Access
Once everything is running, you can access the application at:
```
    http://localhost:8080
```

## Low Stock Notification
The Low Stock Notification is by default set to 5 units.

You can configure this value in the file:
```
    config/cart.php
```

## Cron Job
To manually run the daily sales report cron job:
```
    php artisan app:daily-sales-report-cron
```
