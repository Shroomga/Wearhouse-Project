# Deployment Guide

## Local Development Setup (XAMPP)

1. Download and Install XAMPP
   - Download XAMPP from https://www.apachefriends.org/
   - Install XAMPP on your system
   - Start Apache and MySQL services from XAMPP Control Panel

2. Database Setup
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `wearhousedb`
   - Import the database schema (if you have a .sql file)

3. Project Setup
   - Copy the entire project folder to `C:\xampp\htdocs\`
   - Ensure the following directories have write permissions:
     - `uploads/`
     - Any other directories that need file upload capabilities

4. Configuration
   - The database configuration is already set up in `config/database.php`
   - Default settings:
     - Host: localhost
     - Username: root
     - Password: (empty)
     - Database: wearhousedb

5. Access the Application
   - Open your web browser
   - Navigate to `http://localhost/Wearhouse Project/`

## Production Deployment

For production deployment, you have several options:

1. Shared Hosting
   - Upload files via FTP to your hosting provider
   - Create a MySQL database through your hosting control panel
   - Update database configuration if needed
   - Ensure proper file permissions are set

2. VPS/Dedicated Server
   - Install LAMP stack (Linux, Apache, MySQL, PHP)
   - Configure virtual host
   - Set up SSL certificate
   - Configure proper security measures

## Security Considerations

1. Change the default MySQL root password
2. Set up proper file permissions
3. Enable SSL/HTTPS
4. Implement proper input validation
5. Set up regular backups
6. Configure error reporting for production

## Troubleshooting

1. If you get a database connection error:
   - Verify MySQL service is running
   - Check database credentials in config/database.php
   - Ensure database exists

2. If you get a 500 error:
   - Check PHP error logs
   - Verify file permissions
   - Check PHP version compatibility

3. If uploads don't work:
   - Verify directory permissions
   - Check PHP upload settings in php.ini
   - Verify maximum file size settings 