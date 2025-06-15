# Database Credentials Documentation

## Local Development Environment (XAMPP)

### Database Configuration
- **Host**: localhost
- **Database Name**: wearhousedb
- **Username**: root
- **Password**: (empty by default in XAMPP)

### Connection Details
- **Port**: 3306 (default MySQL port)
- **Character Set**: utf8mb4
- **Collation**: utf8mb4_general_ci

### Database Structure
The database contains the following tables:

1. **users**
   - Primary user accounts table
   - Contains authentication and profile information

2. **products**
   - Product listings
   - Fields: id, seller_id, category_id, name, description, price, stock_quantity, color, brand, image_url, size, status
   - Status options: active, inactive, sold

3. **categories**
   - Product categories and subcategories
   - Hierarchical structure with parent_id
   - 17 predefined categories including Men's/Women's Clothing, Shoes, Accessories

4. **orders**
   - Order information
   - Fields: buyer_id, total_price, shipping_address, payment_method, order_status, payment_status
   - Status tracking: pending, confirmed, processing, shipped, delivered, cancelled

5. **order_items**
   - Individual items within orders
   - Links orders to products and sellers
   - Tracks quantity and price per item

6. **cart**
   - Shopping cart items
   - Links users to products
   - Tracks quantity and added date

7. **messages**
   - Communication between users
   - Can be linked to specific products
   - Tracks read status

8. **transactions**
   - Financial transactions
   - Tracks sales and refunds
   - Includes commission calculations

### Backup Information
- **Backup Location**: /database/backups/
- **Last Backup Date**: June 14, 2025
- **Backup Method**: phpMyAdmin Export
- **Backup File**: wearhousedb.sql

### Important Notes
1. Keep this file secure and never commit it to version control
2. Update this documentation when credentials change
3. Maintain regular backups of the database
4. Use different credentials for development and production environments

### Production Environment
When deploying to production, update these credentials in `config/database.php`:
```php
define('DB_HOST', 'production_host');
define('DB_USER', 'production_username');
define('DB_PASS', 'production_password');
define('DB_NAME', 'production_database');
```

### Security Best Practices
1. Use strong passwords in production
2. Regularly rotate database credentials
3. Limit database user permissions
4. Enable SSL for database connections in production
5. Keep database backups in a secure location

### Troubleshooting
Common connection issues and solutions:
1. Connection refused: Check if MySQL service is running
2. Access denied: Verify username and password
3. Unknown database: Ensure database exists
4. Connection timeout: Check firewall settings

### Database Maintenance
Regular maintenance tasks:
1. Database optimization
2. Index maintenance
3. Backup verification
4. Security updates
5. Performance monitoring

---
**Note**: This documentation was last updated on June 14, 2025, based on wearhousedb.sql 

### Backup Script
To backup the database, run the following command:
```bash
php database/backup_database.php
``` 