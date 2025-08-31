-- HireFlow Database: Add Missing Tables
-- This script adds the notifications and system_settings tables if they don't exist

USE hireflow_db;

-- Create notifications table
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert sample notifications (only if table was just created)
INSERT IGNORE INTO notifications (user_id, title, message, type) VALUES
(4, 'Application Submitted', 'Your application for Senior Software Engineer position has been submitted successfully.', 'success'),
(4, 'Application Update', 'Your application for Senior Software Engineer has been shortlisted for interview.', 'info'),
(7, 'Interview Scheduled', 'Your interview for Junior Data Analyst position has been scheduled for September 3rd.', 'info'),
(2, 'New Application', 'A new application has been received for the Marketing Specialist position.', 'info'),
(3, 'Interview Reminder', 'You have an interview scheduled with Priya Jayasinghe tomorrow at 2:00 PM.', 'warning');

-- Create system_settings table
CREATE TABLE IF NOT EXISTS system_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    description TEXT,
    updated_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Insert default system settings (only if table was just created)
INSERT IGNORE INTO system_settings (setting_key, setting_value, description, updated_by) VALUES
('site_name', 'HireFlow', 'Name of the recruitment system', 1),
('max_file_size', '5242880', 'Maximum file upload size in bytes (5MB)', 1),
('allowed_file_types', 'pdf,doc,docx', 'Allowed file types for resume upload', 1),
('session_timeout', '3600', 'Session timeout in seconds', 1),
('email_notifications', 'true', 'Enable/disable email notifications', 1);

-- Verify all tables exist
SELECT 'DATABASE VERIFICATION' as Status;
SHOW TABLES;

-- Count records in each table
SELECT 'RECORD COUNTS' as Status;
SELECT 'roles' as Table_Name, COUNT(*) as Record_Count FROM roles
UNION ALL
SELECT 'users' as Table_Name, COUNT(*) as Record_Count FROM users
UNION ALL
SELECT 'job_posts' as Table_Name, COUNT(*) as Record_Count FROM job_posts
UNION ALL
SELECT 'applications' as Table_Name, COUNT(*) as Record_Count FROM applications
UNION ALL
SELECT 'interviews' as Table_Name, COUNT(*) as Record_Count FROM interviews
UNION ALL
SELECT 'feedback' as Table_Name, COUNT(*) as Record_Count FROM feedback
UNION ALL
SELECT 'notifications' as Table_Name, COUNT(*) as Record_Count FROM notifications
UNION ALL
SELECT 'access_logs' as Table_Name, COUNT(*) as Record_Count FROM access_logs
UNION ALL
SELECT 'system_settings' as Table_Name, COUNT(*) as Record_Count FROM system_settings;
