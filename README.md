🚀 Customer Visit Tracking
This project is a Laravel-based system for tracking customer visits with geolocation and image uploads.

📌 Setup Instructions
1️⃣ Configure the Environment

Copy the example environment file:

Update the .env file with your database details.

2️⃣ Install Dependencies

Run the following command to install the required dependencies:

composer install

3️⃣ Run Migrations and Seeders

Migrate the database:

php artisan migrate

Seed the database to create the admin user:

php artisan db:seed

Default Admin Credentials:

Email: admin@example.com

Password: password

4️⃣ Start the Development Server

Run the Laravel backend:

php artisan serve

Your backend should now be running at http://127.0.0.1:8000. 🎯
