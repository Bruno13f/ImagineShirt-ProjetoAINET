# ImagineShirt Online Store - Unidade Curricular DAD 

Welcome to the ImagineShirt Online Store project repository! This project aims to develop a web-based application using the Laravel Framework for the "ImagineShirt" online store, which specializes in selling printed t-shirts.

## Users and Functionalities

The web application should support four types of users: anonymous users, customers, employees, and store administrators.

### Anonymous Users
- View generic and static information about the "ImagineShirt" store.
- Browse and filter the store's image catalog.
- Add, remove, or modify items (t-shirts) in the shopping cart.
- Register a new customer account.

### Customers
- Perform all actions available to anonymous users (except registering a new account).
- View and modify their account information (user profile).
- Change their login password.
- Confirm the shopping cart and create orders.
- View their order history (including PDF receipts).
- Manage their own images (for use exclusively on their t-shirts).
- Receive automatic email notifications for order creation, cancellation, and shipment (with attached PDF receipt).

### Employees
- Change their login password.
- View the list of "pending" and "paid" orders and their details.
- Declare "pending" orders as "paid" and "paid" orders as "closed".

### Administrators
- Change their login password and account information.
- Manage (view, filter, create, modify, block, or remove) the accounts of other employees and administrators.
- View and filter the list of customers, and block or remove customer accounts (using soft delete).
- Manage categories and the image catalog.
- Configure t-shirt prices and color options.
- View and filter all types of orders and their details, including PDF receipts.
- Declare orders as "canceled," "paid," or "closed."
- View statistical information about the online store's business.

## Install

1. Clone the repository: `git clone <repository_url>`
2. Navigate to the project directory: `cd imagine-shirt`
3. Install dependencies: `composer install`
4. Copy the `.env.example` file to `.env`: `cp .env.example .env`
5. Generate application key: `php artisan key:generate`
6. Configure your `.env` file with your database credentials and other settings.
7. Run database migrations: `php artisan migrate:fresh`
8. Seed the database with sample data: `php artisan db:seed`
9. Start the development server: `php artisan serve`
