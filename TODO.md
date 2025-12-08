# Hosting Laravel Project on cPanel

## Steps to Host the Project

1. **Access cPanel and Create Database**
   - Log in to your cPanel account.
   - Go to "Databases" section and create a new MySQL database.
   - Create a database user and assign it to the database with full privileges.
   - Note down the database name, username, and password.

2. **Upload Project Files**
   - Use FTP or cPanel File Manager to upload the project files to the public_html directory or a subdirectory.
   - Alternatively, if cPanel supports Git, clone the repository directly:
     - Go to "Git Version Control" in cPanel.
     - Clone the repository: https://github.com/maulanaikhsan55/IkhsanSisaKu.git

3. **Configure Environment**
   - In the project root, copy .env.example to .env.
   - Edit .env file with the following settings:
     - APP_URL: Your domain URL
     - DB_CONNECTION: mysql
     - DB_HOST: localhost
     - DB_PORT: 3306
     - DB_DATABASE: Your database name
     - DB_USERNAME: Your database username
     - DB_PASSWORD: Your database password
   - Set APP_KEY if not set (run php artisan key:generate)

4. **Install Dependencies**
   - Access the server via SSH or use cPanel's Terminal.
   - Navigate to the project directory.
   - Run: composer install --no-dev --optimize-autoloader

5. **Run Migrations and Seeders**
   - Run: php artisan migrate
   - If needed, run: php artisan db:seed

6. **Set Permissions**
   - Set proper permissions for storage and bootstrap/cache directories:
     - chmod -R 755 storage
     - chmod -R 755 bootstrap/cache

7. **Configure Public Directory**
   - Ensure the public directory is accessible.
   - If hosting in a subdirectory, adjust the .htaccess file accordingly.

8. **Test the Application**
   - Visit your domain to check if the application loads.
   - Test key functionalities like login, dashboard, etc.

## Additional Notes
- Ensure PHP version on cPanel matches Laravel requirements (PHP 8.1+).
- Configure cron jobs if needed for scheduled tasks.
- Set up SSL certificate for HTTPS.
- Monitor error logs in cPanel for any issues.
