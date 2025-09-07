# HireFlow Database Setup Guide

## Overview
This guide provides step-by-step instructions for setting up the HireFlow database using the exported database backup file. This method is recommended for developers who want to quickly set up the complete database with sample data.

## Prerequisites

### Required Software
- **XAMPP** (recommended) or standalone MySQL/MariaDB
- **phpMyAdmin** (included with XAMPP) or MySQL command line client
- **Web Browser** for phpMyAdmin access

### System Requirements
- **MySQL Version**: 5.7 or higher
- **PHP Version**: 7.4 or higher
- **Storage**: At least 50MB free space
- **Memory**: Minimum 512MB RAM for MySQL

## Setup Methods

Choose one of the following methods based on your preference:

---

## Method 1: Using phpMyAdmin (Recommended for Beginners)

### Step 1: Start XAMPP Services
1. Open **XAMPP Control Panel**
2. Start **Apache** service
3. Start **MySQL** service
4. Verify both services show "Running" status

### Step 2: Access phpMyAdmin
1. Open your web browser
2. Navigate to: `http://localhost/phpmyadmin`
3. Login with your MySQL credentials (default: username `root`, no password)

### Step 3: Remove Existing Database (If Exists)
⚠️ **WARNING**: This will permanently delete any existing `hireflow_db` database and all its data.

1. In phpMyAdmin left sidebar, look for `hireflow_db` database
2. If it exists:
   - Click on `hireflow_db` to select it
   - Click the **"Drop"** tab at the top
   - Click **"Yes"** to confirm deletion
   - Wait for confirmation message

### Step 4: Import Database Backup
1. In phpMyAdmin, click **"Import"** tab in the top navigation
2. Click **"Choose file"** button
3. Navigate to `HireFlow/Database-Backup/` folder
4. Select the database backup file: `hireflow_db.sql`
5. **Import Settings** (use these exact settings):
   - **Format**: SQL
   - **Character set**: utf8mb4_unicode_ci
   - **Partial import**: Leave unchecked
   - **Allow interrupt**: Leave unchecked
   - **Number of queries to skip**: 0
6. Click **"Go"** button at the bottom
7. Wait for the import to complete (may take 30-60 seconds)

### Step 5: Verify Import Success
1. Check for green success message: "Import has been successfully finished"
2. In left sidebar, you should see `hireflow_db` database
3. Click on `hireflow_db` to expand it
4. Verify you see 9 tables:
   - `access_logs`
   - `applications`
   - `departments`
   - `interviews`
   - `job_posts`
   - `notifications`
   - `roles`
   - `system_settings`
   - `users`

### Step 6: Test Database Connection
1. Navigate to: `http://localhost/HireFlow/public`
2. Try logging in with default credentials:
   - **System Admin**: `admin@hireflow.com` / `Password@1`
   - **HR Admin**: `hr@hireflow.com` / `Password@1`
   - **Recruitment Manager**: `recruiter@hireflow.com` / `Password@1`
   - **Applicant**: `athsara@hireflow.com` / `Password@1`

---

## Method 2: Using MySQL Command Line

### Step 1: Open Command Prompt/Terminal
**Windows (XAMPP):**
```bash
# Open Command Prompt as Administrator
# Navigate to XAMPP MySQL bin directory
cd "C:\xampp\mysql\bin"
```

**Linux/Mac:**
```bash
# Open Terminal
# MySQL should be in your PATH
```

### Step 2: Connect to MySQL
```bash
# Connect to MySQL as root
mysql -u root -p

# If no password is set (default XAMPP):
mysql -u root
```

### Step 3: Remove Existing Database (If Exists)
```sql
-- Check if database exists
SHOW DATABASES LIKE 'hireflow_db';

-- If it exists, drop it (WARNING: This deletes all data)
DROP DATABASE IF EXISTS hireflow_db;

-- Verify deletion
SHOW DATABASES;

-- Exit MySQL
EXIT;
```

### Step 4: Import Database Backup
```bash
# Import the database backup
# Windows (XAMPP):
mysql -u root -p < "C:\path\to\HireFlow\Database-Backup\hireflow_db.sql"

# If no password:
mysql -u root < "C:\path\to\HireFlow\Database-Backup\hireflow_db.sql"

# Linux/Mac:
mysql -u root -p < /path/to/HireFlow/Database-Backup/hireflow_db.sql
```

### Step 5: Verify Import
```bash
# Connect to MySQL again
mysql -u root -p

# Use the imported database
USE hireflow_db;

# Check all tables exist
SHOW TABLES;

# Check sample data
SELECT COUNT(*) as user_count FROM users;
SELECT COUNT(*) as job_count FROM job_posts;

# Exit
EXIT;
```

---

## Method 3: Using MySQL Workbench

### Step 1: Open MySQL Workbench
1. Launch **MySQL Workbench**
2. Connect to your local MySQL instance
3. Click on your connection to open it

### Step 2: Remove Existing Database
1. In **Navigator** panel, look for `hireflow_db` schema
2. If it exists:
   - Right-click on `hireflow_db`
   - Select **"Drop Schema..."**
   - Type `hireflow_db` to confirm
   - Click **"Drop Now"**

### Step 3: Import Database
1. Go to **Server** → **Data Import**
2. Select **"Import from Self-Contained File"**
3. Click **"..."** button and select `hireflow_db.sql`
4. In **"Default Target Schema"** dropdown, select **"New..."**
5. Enter schema name: `hireflow_db`
6. Click **"Start Import"** button
7. Wait for import to complete

### Step 4: Refresh and Verify
1. In Navigator panel, click **refresh** icon
2. Expand `hireflow_db` schema
3. Verify all 9 tables are present
4. Right-click on `users` table → **"Select Rows - Limit 1000"**
5. Verify you see 8 users including default accounts

---

## Troubleshooting

### Common Issues and Solutions

#### 1. "Database already exists" Error
**Solution:**
- Follow the database removal steps for your chosen method
- Ensure the database is completely deleted before importing

#### 2. "Access denied" Error
**Solutions:**
- Check MySQL credentials (username/password)
- For XAMPP default: username `root`, no password
- Ensure MySQL service is running

#### 3. "File not found" Error
**Solutions:**
- Verify the backup file path is correct
- Ensure the backup file `hireflow_db.sql` exists in `Database-Backup` folder
- Check file permissions (should be readable)

#### 4. Import Timeout/Large File Error
**Solutions for phpMyAdmin:**
- Increase PHP settings in `php.ini`:
  ```ini
  upload_max_filesize = 100M
  post_max_size = 100M
  max_execution_time = 300
  max_input_time = 300
  ```
- Restart Apache after changing `php.ini`
- Use command line method for very large files

#### 5. Character Encoding Issues
**Solutions:**
- Ensure database collation is set to `utf8mb4_unicode_ci`
- Use UTF-8 encoding when importing
- Check that special characters display correctly

#### 6. Foreign Key Constraint Errors
**Solutions:**
- Import the complete backup file (don't import tables individually)
- Ensure the backup file includes all tables and constraints
- Check MySQL version compatibility (5.7+ required)

### Performance Optimization

#### After Import Optimization
```sql
-- Connect to MySQL and run these commands
USE hireflow_db;

-- Analyze tables for better performance
ANALYZE TABLE users, job_posts, applications, departments;

-- Check database size
SELECT 
    table_name AS 'Table',
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Size (MB)'
FROM information_schema.TABLES 
WHERE table_schema = 'hireflow_db'
ORDER BY (data_length + index_length) DESC;
```

### Backup Verification

#### Verify Complete Data Import
```sql
-- Check record counts match expected values
SELECT 'users' as table_name, COUNT(*) as record_count FROM users
UNION ALL
SELECT 'roles', COUNT(*) FROM roles
UNION ALL
SELECT 'departments', COUNT(*) FROM departments
UNION ALL
SELECT 'job_posts', COUNT(*) FROM job_posts
UNION ALL
SELECT 'applications', COUNT(*) FROM applications
UNION ALL
SELECT 'interviews', COUNT(*) FROM interviews
UNION ALL
SELECT 'notifications', COUNT(*) FROM notifications
UNION ALL
SELECT 'access_logs', COUNT(*) FROM access_logs
UNION ALL
SELECT 'system_settings', COUNT(*) FROM system_settings;
```

**Expected Results:**
- users: 8 records
- roles: 4 records  
- departments: 8 records
- job_posts: 16+ records
- applications: 4+ records
- interviews: 0+ records
- notifications: 6+ records
- access_logs: 0+ records
- system_settings: 12+ records

## Post-Import Configuration

### 1. Update Application Configuration
Ensure your `app/core/config.php` has the correct database settings:
```php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'hireflow_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // or your MySQL password
```

### 2. Test Application Access
1. Navigate to: `http://localhost/HireFlow/public`
2. Test all default user logins
3. Verify role-based access works correctly
4. Check that job posts and applications display properly

### 3. File Upload Directory Setup
Ensure the uploads directory exists and is writable:
```bash
# Create uploads directory if it doesn't exist
mkdir public/uploads
mkdir public/uploads/resumes

# Set appropriate permissions (Linux/Mac)
chmod 755 public/uploads
chmod 755 public/uploads/resumes
```

## Default User Accounts

After successful import, you can login with these accounts:

| Role | Email | Password | Access Level |
|------|-------|----------|--------------|
| System Admin | admin@hireflow.com | Password@1 | Full system access |
| HR Admin | hr@hireflow.com | Password@1 | Job management, applications |
| Recruitment Manager | recruiter@hireflow.com | Password@1 | Interview management |
| Applicant | athsara@hireflow.com | Password@1 | Job browsing, applications |

**Additional Test Applicants:**
- chamali.perera@gmail.com / Password@1
- nuwan.silva@gmail.com / Password@1
- priya.j@gmail.com / Password@1
- kamal.fernando@gmail.com / Password@1

## Security Recommendations

### 1. Change Default Passwords
```sql
-- After import, change default passwords for production use
UPDATE users SET password = PASSWORD('your_secure_password') WHERE email = 'admin@hireflow.com';
-- Repeat for other accounts
```

### 2. Database Security
- Create a dedicated MySQL user for the application (don't use root)
- Set strong passwords for all database users
- Restrict database access to localhost only
- Regular backup schedule

### 3. File Permissions
- Ensure database backup files are not web-accessible
- Set proper file permissions on upload directories
- Regularly monitor access logs

## Support and Resources

### Documentation References
- **Database Schema**: See `DATABASE_SCHEMA.md` in this folder
- **Application Setup**: See main `README.md`
- **Architecture**: See `ARCHITECTURE.md`
- **Authentication**: See `AUTHENTICATION.md`

### Getting Help
If you encounter issues:
1. Check the troubleshooting section above
2. Verify all prerequisites are met
3. Review error logs in XAMPP/logs/
4. Consult the main project documentation

---

**Last Updated**: September 7, 2025  
**Compatible With**: MySQL 5.7+, MariaDB 10.3+, phpMyAdmin 4.9+
