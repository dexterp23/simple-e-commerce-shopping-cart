# Project Overview
**Simple E-commerce Shopping Cart** is a Laravel-based web application that provides core 
shopping cart functionality for an e-commerce system.

The application allows users to browse available products, add them to a personal 
shopping cart, update product quantities, and remove items from the cart. Each product contains essential attributes such as name, price, and stock quantity.

### User Authentication & Cart Management
- Every shopping cart is linked to an authenticated user using Laravel’s built-in 
authentication system.

- Cart operations (adding products, updating quantities, and removing items) are 
persisted in the database and are always retrieved based on the currently authenticated user.

- No session storage or local storage is used for cart data — all cart state is 
managed server-side following Laravel best practices.

### Key Features
- Product catalog with name, price, and stock quantity
- User authentication using Laravel starter kits
- Persistent shopping cart per authenticated user
- Add, update, and remove cart items
- Stock quantity validation

### Notifications & Scheduled Jobs
- **Low Stock Notification**
When a product’s stock quantity falls below a defined threshold, a Laravel Job / Queue 
is triggered to send an email notification to a admin user.

- **Daily Sales Report**
A scheduled cron job runs every evening and sends a report containing all products sold 
during the current day to the email address of the admin user.

These background processes are implemented using Laravel’s Queue and Scheduler systems.

### Technology Stack
- Laravel 12
- Laravel Starter Kit (React)
- Queues & Jobs
- Laravel Scheduler (Cron Jobs)
- PostgreSQL
- Docker (for local development)


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
