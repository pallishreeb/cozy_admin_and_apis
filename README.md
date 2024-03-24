# Cozy Admin Panel

Cozy Admin Panel is a web-based application designed to manage bookings for services provided by providers. It allows administrators to view, create, update, and delete bookings. It also provides a user-friendly interface for managing service providers, services, and users.

## Features

- View all bookings
- Manage discount for category
- Manage Category
- Manage service providers
- Manage services
- Manage users

## Installation

1. Clone the repository to your local machine:
git clone <repository-url>

2. Install dependencies: composer install
npm install && npm run dev

3. Copy the `.env.example` file to `.env` and configure the database settings and other environment variables:cp .env.example .env

4. Generate application key: php artisan key:generate

5. Run migrations to create the necessary database tables: php artisan migrate


6. Serve the application: php artisan serve


7. Access the application in your web browser at `http://localhost:8000`.

## Usage

1. Log in as an administrator using the provided credentials.
2. Navigate through the dashboard to manage bookings, service providers, services, and users.
3. Use the provided forms and interfaces to perform CRUD operations on the entities.







