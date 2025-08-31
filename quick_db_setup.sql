-- HireFlow Database Quick Setup
-- Run this if the main SQL file is taking too long

CREATE DATABASE IF NOT EXISTS hireflow_db;
USE hireflow_db;

-- Drop tables if they exist (for clean setup)
DROP TABLE IF EXISTS access_logs;
DROP TABLE IF EXISTS system_settings;
DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS interviews;
DROP TABLE IF EXISTS applications;
DROP TABLE IF EXISTS job_posts;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;

-- Create roles table
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role_id INT NOT NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    profile_picture VARCHAR(255),
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- Create job_posts table
CREATE TABLE job_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hr_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    requirements TEXT,
    department VARCHAR(100),
    location VARCHAR(100),
    salary_range VARCHAR(100),
    employment_type ENUM('Full-time', 'Part-time', 'Contract', 'Internship') DEFAULT 'Full-time',
    deadline DATE,
    status ENUM('Open', 'Closed', 'Draft') DEFAULT 'Draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hr_id) REFERENCES users(id)
);

-- Create applications table
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    applicant_id INT NOT NULL,
    job_id INT NOT NULL,
    resume_path VARCHAR(255) NOT NULL,
    cover_letter TEXT,
    status ENUM('Applied', 'Under Review', 'Shortlisted', 'Interview Scheduled', 'Rejected', 'Offered') DEFAULT 'Applied',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(applicant_id, job_id),
    FOREIGN KEY (applicant_id) REFERENCES users(id),
    FOREIGN KEY (job_id) REFERENCES job_posts(id)
);

-- Create interviews table
CREATE TABLE interviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    interviewer_id INT NOT NULL,
    scheduled_date DATE NOT NULL,
    scheduled_time TIME NOT NULL,
    status ENUM('Scheduled', 'Completed', 'Canceled') DEFAULT 'Scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES applications(id),
    FOREIGN KEY (interviewer_id) REFERENCES users(id)
);

-- Create notifications table
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create access_logs table
CREATE TABLE access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    ip_address VARCHAR(45),
    action VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert basic data
INSERT INTO roles (role_name, description) VALUES
('System Admin', 'System management and configuration'),
('HR Admin', 'HR operations and job management'),
('Recruitment Manager', 'Candidate evaluation and interviews'),
('Applicant', 'Job seekers and candidates');

INSERT INTO users (full_name, email, password, role_id, status) VALUES
('Admin User', 'admin@hireflow.com', 'admin123', 1, 'active'),
('HR Manager', 'hr@hireflow.com', 'hr123', 2, 'active'),
('Recruiter', 'recruiter@hireflow.com', 'rec123', 3, 'active'),
('John Doe', 'john@example.com', 'user123', 4, 'active'),
('Jane Smith', 'jane@example.com', 'user123', 4, 'active');

INSERT INTO job_posts (hr_id, title, description, department, location, status, deadline) VALUES
(2, 'Software Engineer', 'Looking for a skilled software developer', 'IT', 'Colombo', 'Open', '2025-12-31'),
(2, 'Marketing Specialist', 'Digital marketing expert needed', 'Marketing', 'Kandy', 'Open', '2025-11-30'),
(2, 'Data Analyst', 'Analyze business data and trends', 'Analytics', 'Galle', 'Open', '2025-10-31');

INSERT INTO applications (applicant_id, job_id, resume_path, status) VALUES
(4, 1, '/uploads/john_resume.pdf', 'Applied'),
(5, 1, '/uploads/jane_resume.pdf', 'Under Review'),
(4, 2, '/uploads/john_resume_2.pdf', 'Shortlisted');

-- Show created tables
SHOW TABLES;
SELECT COUNT(*) as 'Total Users' FROM users;
SELECT COUNT(*) as 'Total Jobs' FROM job_posts;
SELECT COUNT(*) as 'Total Applications' FROM applications;
