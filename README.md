# Wearhouse Project

A PHP-based e-commerce web application for clothing and accessories.

## Prerequisites

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Web server (Apache, Nginx, or PHP built-in server)

## Installation

### 1. Install Dependencies (macOS with Homebrew)

```bash
# Install PHP and MySQL
brew install php mysql

# Start MySQL service
brew services start mysql
```

### 2. Database Setup

#### Option A: Using MySQL Command Line
```bash
# Connect to MySQL (you may need to set up a root password first)
mysql -u root -p

# Create the database
CREATE DATABASE wearhousedb;
exit;

# Import the database schema
mysql -u root -p wearhousedb < setup_database.sql
```

#### Option B: Secure MySQL Installation (Recommended)
```bash
# Run MySQL secure installation to set up root password
mysql_secure_installation

# Then follow Option A above
```

### 3. Configure Database Connection

The database configuration is in `database.php`. Default settings:
- Server: `localhost`
- Username: `root`
- Password: `` (empty)
- Database: `wearhousedb`

Update these settings if your MySQL configuration is different.

## Running the Application

### Option 1: PHP Built-in Server (Development)
```bash
# Navigate to project directory
cd /path/to/Wearhouse-Project

# Start PHP development server
php -S localhost:8000

# Access the application at: http://localhost:8000/
```

### Option 2: Apache/Nginx
Configure your web server to serve the project directory and access via your configured domain/port.

## Application Structure

```
Wearhouse-Project/
├── database.php          # Database connection configuration
├── views/                 # HTML and PHP view files
│   ├── index.html        # Homepage
│   ├── login.php         # User login
│   ├── register.php      # User registration
│   ├── store.php         # Product catalog
│   ├── cart.php          # Shopping cart
│   ├── check-out.html    # Checkout page
│   ├── account.html      # User account
│   └── seller/           # Seller-specific pages
├── public/               # Static assets
│   ├── styles/          # CSS files
│   └── images/          # Image files
└── setup_database.sql   # Database schema setup script
```

## Usage

1. **Homepage**: Start at `http://localhost:8000/`
2. **Register**: Create a new account at the registration page
3. **Login**: Sign in with your credentials
4. **Browse**: View products in the store
5. **Cart**: Add items to your shopping cart
6. **Checkout**: Complete your purchase

## Features

- User registration and authentication
- Product catalog with categories
- Shopping cart functionality
- User account management
- Seller interface for adding products

## Database Schema

The application uses the following main tables:
- `users`: User accounts and authentication
- `categories`: Product categories
- `products`: Product information
- `cart`: Shopping cart items

## Troubleshooting

### Database Connection Issues
- Ensure MySQL is running: `brew services start mysql`
- Check database credentials in `database.php`
- Verify the database `wearhousedb` exists

### PHP Issues
- Ensure PHP is installed: `php --version`
- Check PHP extensions are loaded (mysqli)

### File Permissions
- Ensure web server has read access to project files
- Check that PHP can write to necessary directories

## Development

This is a basic PHP application using:
- Native PHP (no framework)
- MySQL with mysqli extension
- Bootstrap CSS framework
- HTML5 and basic JavaScript

## Security Notes

⚠️ **Important**: This is a development/learning project. For production use, implement:
- Input validation and sanitization
- SQL injection prevention (prepared statements)
- CSRF protection
- Secure session management
- HTTPS encryption
- Password strength requirements 