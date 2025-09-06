# 🗄️ HireFlow Database Setup Guide

## 📋 Quick Setup (Recommended)

### For New Developers
Follow these steps to set up the complete HireFlow database:

### 1. Prerequisites
- ✅ XAMPP installed and running
- ✅ Apache and MySQL services started
- ✅ Project cloned to `C:\xampp\htdocs\HireFlow`

### 2. Database Setup (One-Click)

1. **Create Database**
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Create new database: `hireflow_db`
   - Set collation: `utf8mb4_general_ci`

2. **Run Automated Setup**
   ```
   http://localhost/HireFlow/database-setup.php
   ```
   
   This script will:
   - ✅ Create all 9 tables with proper structure
   - ✅ Insert sample roles and departments
   - ✅ Set up proper foreign key relationships
   - ✅ Prepare system for initial admin creation

3. **Create Initial Administrator**
   ```
   http://localhost/HireFlow/admin-setup.php
   ```
   
   This one-time setup page will:
   - ✅ Create your System Administrator account
   - ✅ Set your custom credentials
   - ✅ Automatically disable after first admin is created

### 3. Test Authentication
   ```
   http://localhost/HireFlow/public?url=signin
   ```

## 🔐 User Creation Process

### Initial Setup
1. **System Administrator**: Created via one-time setup page
2. **Other Admin Accounts**: Created by System Admin through User Management
3. **Applicant Accounts**: Self-registration through normal signup

### Login Process
- Use your email and password created during admin setup
- Other admins will receive credentials from System Administrator
- Applicants can register themselves through the normal signup process

## 🔧 Manual Setup (Alternative)

If you prefer manual setup or need to troubleshoot:

### 1. Database Configuration
Edit `app/core/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'hireflow_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // Usually empty for XAMPP
```

### 2. Run SQL Commands
Execute the SQL from `DATABASE.md` or use phpMyAdmin to import.

### 3. Migration (If Updating)
If you have an existing database:
```
http://localhost/HireFlow/migrate-database.php
```

## 📊 Database Structure

### Core Tables
1. **roles** - User permission levels
2. **departments** - Organizational structure
3. **users** - All system users (admins, HR, applicants)
4. **job_posts** - Job listings
5. **applications** - Job applications
6. **interviews** - Interview scheduling
7. **access_logs** - Security audit trail
8. **notifications** - System notifications
9. **system_settings** - Application configuration

### Key Features
- 🔐 **Secure Authentication** - Bcrypt password hashing
- 👥 **Role-Based Access** - System Admin, HR, Recruitment Manager, Applicant
- 📝 **Complete Audit Trail** - All user actions logged
- 🔄 **Foreign Key Integrity** - Proper relational structure

## 🚨 Troubleshooting

### Common Issues

1. **"Invalid password" error**
   - Run: `http://localhost/HireFlow/final-password-fix.php`
   - This recreates sample users with proper password hashes

2. **Missing columns error**
   - Run: `http://localhost/HireFlow/migrate-database.php`
   - This adds any missing database columns

3. **Database connection error**
   - Check XAMPP MySQL is running
   - Verify database name is `hireflow_db`
   - Check config.php settings

### Test Scripts
- **Database Test**: `http://localhost/HireFlow/test-auth.php`
- **Login Test**: `http://localhost/HireFlow/public?url=signin`

## 📚 Documentation
- **Full Database Schema**: See `DATABASE.md`
- **Authentication Guide**: See `AUTHENTICATION-FINAL-RESOLUTION.md`
- **API Documentation**: See individual controller files

---

**For Support**: Check the documentation files or create an issue on GitHub.

**Database Version**: Phase 6A Authentication System  
**Last Updated**: September 2025
