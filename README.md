# Company Management System

## Introduction

This project is a Company Management System built with Laravel for the backend and Vue.js for the frontend. It allows users to manage companies and their associated services.

## Prerequisites

1. PHP >= 8
2. Composer
3. Node.js >= 12.x
4. npm
5. MySQL
6. Laravel 10
7. Vue.js 3.x


## Installation

1. Clone the repository to your local machine
2. Run composer install
3. Run cp .env.example .env to generate .env file
4. Update the following fields in the .env file:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
5. Generate a new application key by running: php artisan key:generate
6. Run the database migrations to create the table: php artisan migrate:fresh
7. Install frontend dependencies using npm: npm install
8. To start the Laravel development server, run: php artisan serve
9. php artisan db:seed
10.  Compile frontend using: npm run serve

# Endpoints

## Authentication
1. POST /login - Login a user.
2. POST /register - Register a new user.
3. POST /logout - Logout the authenticated user.

## Companies
1. GET /companies - List all companies.
2. POST /companies - Create a new company.
3. PUT /companies/{company} - Update a company.
4. DELETE /companies/{company} - Delete a company.

## Services
1. GET /services - List all services.
2. POST /services - Create a new service.
3. PUT /services/{service} - Update a service.
4. DELETE /services/{service} - Delete a service.
