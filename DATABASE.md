# HireFlow Database Documentation

## Overview
HireFlow uses MySQL database to store all application data including users, job posts, applications, interviews, and system logs.

## Database Setup Instructions

### For New Users (First Time Setup)
1. **Install XAMPP** (if not already installed)
   - Download from [https://www.apachefriends.org/](https://www.apachefriends.org/)
   - Install and start Apache and MySQL services

2. **Create Database**
   - Open phpMyAdmin (usually at `http://localhost/phpmyadmin`)
   - Or use MySQL command line
   - Run the SQL script: `my_db.session.sql`

3. **Execute Database Script**
   ```sql
   -- Method 1: Using phpMyAdmin
   -- Copy and paste the contents of my_db.session.sql into SQL tab and execute
   
   -- Method 2: Using MySQL command line
   mysql -u root -p < my_db.session.sql
   ```

4. **Verify Setup**
   - Check that `hireflow_db` database is created
   - Verify all tables are present with sample data

### Database Configuration
Update the database configuration in `app/core/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'hireflow_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // Default XAMPP password is empty
```

## Database Schema

### Core Tables

#### 1. `roles`
Stores user role definitions
```sql
- id (Primary Key)
- role_name (System Admin, HR Admin, Recruitment Manager, Applicant)
- description
- created_at
```

#### 2. `users`
Stores all user accounts across different roles
```sql
- id (Primary Key)
- full_name
- email (Unique)
- password (Hashed)
- phone
- address
- role_id (Foreign Key → roles.id)
- status (active, inactive, suspended)
- profile_picture
- last_login
- created_at, updated_at
```

#### 3. `job_posts`
Stores job postings created by HR Admins
```sql
- id (Primary Key)
- hr_id (Foreign Key → users.id)
- title
- description
- requirements
- responsibilities
- department
- location
- salary_range
- employment_type (Full-time, Part-time, Contract, Internship)
- experience_level (Entry, Mid, Senior, Executive)
- deadline
- status (Open, Closed, Draft)
- applications_count
- created_at, updated_at
```

#### 4. `applications`
Stores job applications submitted by applicants
```sql
- id (Primary Key)
- applicant_id (Foreign Key → users.id)
- job_id (Foreign Key → job_posts.id)
- resume_path
- cover_letter
- additional_documents
- status (Applied, Under Review, Shortlisted, Interview Scheduled, etc.)
- notes
- applied_at, updated_at
- UNIQUE constraint (applicant_id, job_id) - one application per job
```

#### 5. `interviews`
Stores interview scheduling and details
```sql
- id (Primary Key)
- application_id (Foreign Key → applications.id)
- interviewer_id (Foreign Key → users.id)
- interview_type (Phone, Video, In-person, Panel)
- scheduled_date, scheduled_time
- duration_minutes
- location
- meeting_link
- status (Scheduled, Completed, Canceled, Rescheduled)
- notes
- created_at, updated_at
```

#### 6. `feedback`
Stores interview feedback from recruitment managers
```sql
- id (Primary Key)
- interview_id (Foreign Key → interviews.id)
- technical_rating (1-10)
- communication_rating (1-10)
- overall_rating (1-10)
- strengths, weaknesses
- comments
- recommendation (Strongly Recommend, Recommend, etc.)
- submitted_at
```

### Supporting Tables

#### 7. `notifications`
System-wide notifications for users
```sql
- id (Primary Key)
- user_id (Foreign Key → users.id)
- title, message
- type (info, success, warning, error)
- is_read, read_at
- created_at
```

#### 8. `access_logs`
Security and audit logging
```sql
- id (Primary Key)
- user_id (Foreign Key → users.id)
- ip_address, user_agent
- action, resource, method
- status_code, response_time_ms
- created_at
```

#### 9. `system_settings`
Configuration settings for the application
```sql
- id (Primary Key)
- setting_key (Unique)
- setting_value, description
- updated_by (Foreign Key → users.id)
- updated_at
```

## Sample Data Included

### Default Users
- **System Admin**: sineth@hireflow.com (password: admin123)
- **HR Admin**: hasindu@hireflow.com (password: hradmin123)
- **Recruitment Manager**: tehan@hireflow.com (password: recruit123)
- **Sample Applicants**: Various test applicants with applications

### Sample Job Posts
- Senior Software Engineer (Open)
- Marketing Specialist (Open)
- Junior Data Analyst (Open)
- HR Assistant (Open)
- Project Manager (Draft)

### Sample Applications
- Multiple applications across different jobs with various statuses
- Sample interview schedules and feedback

## Future Backend Development Considerations

### Tables to Add/Enhance
1. **Documents Management**
   ```sql
   CREATE TABLE documents (
       id INT PRIMARY KEY AUTO_INCREMENT,
       user_id INT,
       application_id INT,
       file_name VARCHAR(255),
       file_path VARCHAR(500),
       file_type VARCHAR(50),
       file_size INT,
       uploaded_at TIMESTAMP
   );
   ```

2. **Email Templates**
   ```sql
   CREATE TABLE email_templates (
       id INT PRIMARY KEY AUTO_INCREMENT,
       template_name VARCHAR(100),
       subject VARCHAR(255),
       body TEXT,
       variables TEXT, -- JSON format
       created_by INT,
       is_active BOOLEAN
   );
   ```

3. **Audit Trail**
   ```sql
   CREATE TABLE audit_trail (
       id INT PRIMARY KEY AUTO_INCREMENT,
       table_name VARCHAR(100),
       record_id INT,
       action ENUM('INSERT', 'UPDATE', 'DELETE'),
       old_values JSON,
       new_values JSON,
       user_id INT,
       timestamp TIMESTAMP
   );
   ```

### Security Enhancements
- Password hashing using `password_hash()` and `password_verify()`
- Session management and CSRF protection
- File upload validation and security
- SQL injection prevention using prepared statements
- Role-based access control implementation

### Performance Optimizations
- Add database indexes on frequently queried columns
- Implement database connection pooling
- Add caching layer for frequently accessed data
- Optimize queries with proper joins and indexes

### Data Integrity
- Add more foreign key constraints
- Implement triggers for data validation
- Add check constraints for data ranges
- Set up database backups and recovery procedures

## Maintenance

### Regular Tasks
1. **Backup Database** - Weekly automated backups
2. **Clean Old Logs** - Remove access logs older than 6 months
3. **Archive Applications** - Move old applications to archive tables
4. **Update Statistics** - Refresh application counts and analytics data

### Monitoring
- Monitor database size and performance
- Track slow queries and optimize
- Monitor user activity and access patterns
- Set up alerts for system errors

## Current Status
✅ Database schema designed and implemented  
✅ Sample data populated for testing  
✅ Basic tables for core functionality ready  
🔄 Frontend development in progress  
⏳ Backend API development pending  
⏳ Authentication system pending  
⏳ File upload system pending  
