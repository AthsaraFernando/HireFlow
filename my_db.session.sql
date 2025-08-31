CREATE DATABASE IF NOT EXISTS hireflow_db;
USE hireflow_db;

-- Create roles table
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert roles with descriptions
INSERT INTO roles (role_name, description) VALUES
('System Admin', 'Manages system configuration, user accounts, and technical maintenance'),
('HR Admin', 'Manages job postings, applicant data, and recruitment operations'),
('Recruitment Manager', 'Evaluates candidates, conducts interviews, and provides feedback'),
('Applicant', 'External users who browse jobs and submit applications');

-- Create users table
CREATE TABLE IF NOT EXISTS users (
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

-- Insert sample users
-- System Admin
INSERT INTO users (full_name, email, password, phone, role_id, status)
VALUES ('Sineth Mendis', 'sineth@hireflow.com', 'admin123', '+94701234567', 1, 'active');

-- HR Admin
INSERT INTO users (full_name, email, password, phone, role_id, status)
VALUES ('Hasindu Rodrigo', 'hasindu@hireflow.com', 'hradmin123', '+94702345678', 2, 'active');

-- Recruitment Manager
INSERT INTO users (full_name, email, password, phone, role_id, status)
VALUES ('Tehan Isum', 'tehan@hireflow.com', 'recruit123', '+94703456789', 3, 'active');

-- Sample Applicants
INSERT INTO users (full_name, email, password, phone, role_id, status)
VALUES 
('Athsara Manitha', 'athsara1@gmail.com', 'applicant1', '+94771234567', 4, 'active'),
('Chamali Perera', 'chamali.perera@gmail.com', 'applicant2', '+94772345678', 4, 'active'),
('Nuwan Silva', 'nuwan.silva@gmail.com', 'applicant3', '+94773456789', 4, 'active'),
('Priya Jayasinghe', 'priya.j@gmail.com', 'applicant4', '+94774567890', 4, 'active'),
('Kamal Fernando', 'kamal.fernando@gmail.com', 'applicant5', '+94775678901', 4, 'active');

-- Create job posts table
CREATE TABLE IF NOT EXISTS job_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hr_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    requirements TEXT,
    responsibilities TEXT,
    department VARCHAR(100),
    location VARCHAR(100),
    salary_range VARCHAR(100),
    employment_type ENUM('Full-time', 'Part-time', 'Contract', 'Internship') DEFAULT 'Full-time',
    experience_level ENUM('Entry', 'Mid', 'Senior', 'Executive') DEFAULT 'Entry',
    deadline DATE,
    status ENUM('Open', 'Closed', 'Draft') DEFAULT 'Draft',
    applications_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (hr_id) REFERENCES users(id)
);

-- Insert sample job posts
INSERT INTO job_posts (hr_id, title, description, requirements, responsibilities, department, location, salary_range, employment_type, experience_level, deadline, status) VALUES
(2, 'Senior Software Engineer', 'We are looking for an experienced software engineer to join our development team.', 'Bachelor degree in Computer Science, 5+ years experience in web development, proficiency in PHP, JavaScript, MySQL', 'Design and develop web applications, collaborate with team members, code reviews, maintain existing systems', 'IT', 'Colombo', 'LKR 150,000 - 200,000', 'Full-time', 'Senior', '2025-09-30', 'Open'),
(2, 'Marketing Specialist', 'Join our marketing team to drive brand awareness and customer engagement.', 'Bachelor degree in Marketing, 2+ years experience in digital marketing, knowledge of social media platforms', 'Develop marketing campaigns, manage social media, analyze market trends, coordinate with sales team', 'Marketing', 'Kandy', 'LKR 80,000 - 120,000', 'Full-time', 'Mid', '2025-09-25', 'Open'),
(2, 'Junior Data Analyst', 'Entry-level position for fresh graduates interested in data analysis.', 'Bachelor degree in Statistics/Mathematics/Computer Science, knowledge of Excel, SQL, Python basics', 'Collect and analyze data, prepare reports, assist senior analysts, maintain databases', 'Analytics', 'Galle', 'LKR 60,000 - 80,000', 'Full-time', 'Entry', '2025-10-15', 'Open'),
(2, 'HR Assistant', 'Support the HR department with various administrative tasks.', 'Diploma in HR or related field, good communication skills, basic computer knowledge', 'Assist with recruitment, maintain employee records, coordinate meetings, handle inquiries', 'Human Resources', 'Colombo', 'LKR 50,000 - 70,000', 'Full-time', 'Entry', '2025-09-20', 'Open'),
(2, 'Project Manager', 'Lead and manage multiple projects across different departments.', 'Bachelor degree, PMP certification preferred, 3+ years project management experience', 'Plan and execute projects, manage timelines, coordinate teams, report to stakeholders', 'Management', 'Colombo', 'LKR 120,000 - 160,000', 'Full-time', 'Mid', '2025-10-05', 'Draft');

-- Create applications table
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    applicant_id INT NOT NULL,
    job_id INT NOT NULL,
    resume_path VARCHAR(255) NOT NULL,
    cover_letter TEXT,
    additional_documents TEXT,
    status ENUM('Applied', 'Under Review', 'Shortlisted', 'Interview Scheduled', 'Interview Completed', 'Rejected', 'Offered', 'Hired') DEFAULT 'Applied',
    notes TEXT,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE(applicant_id, job_id),
    FOREIGN KEY (applicant_id) REFERENCES users(id),
    FOREIGN KEY (job_id) REFERENCES job_posts(id)
);

-- Insert sample applications
INSERT INTO applications (applicant_id, job_id, resume_path, cover_letter, status) VALUES
(4, 1, '/uploads/resumes/athsara_resume.pdf', 'I am very interested in this position and believe my skills align well with your requirements.', 'Shortlisted'),
(5, 1, '/uploads/resumes/chamali_resume.pdf', 'With my experience in web development, I would be a great fit for this role.', 'Under Review'),
(6, 2, '/uploads/resumes/nuwan_resume.pdf', 'I am passionate about marketing and would love to contribute to your team.', 'Applied'),
(7, 3, '/uploads/resumes/priya_resume.pdf', 'As a recent graduate, I am excited to start my career in data analysis.', 'Interview Scheduled'),
(8, 4, '/uploads/resumes/kamal_resume.pdf', 'I have strong organizational skills that would benefit your HR department.', 'Applied'),
(4, 3, '/uploads/resumes/athsara_resume_v2.pdf', 'I am also interested in data analysis opportunities.', 'Applied');

-- Create interviews table
CREATE TABLE IF NOT EXISTS interviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    interviewer_id INT NOT NULL,
    interview_type ENUM('Phone', 'Video', 'In-person', 'Panel') DEFAULT 'Video',
    scheduled_date DATE NOT NULL,
    scheduled_time TIME NOT NULL,
    duration_minutes INT DEFAULT 60,
    location VARCHAR(255),
    meeting_link VARCHAR(500),
    status ENUM('Scheduled', 'Completed', 'Canceled', 'Rescheduled') DEFAULT 'Scheduled',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES applications(id),
    FOREIGN KEY (interviewer_id) REFERENCES users(id)
);

-- Insert sample interviews
INSERT INTO interviews (application_id, interviewer_id, interview_type, scheduled_date, scheduled_time, duration_minutes, meeting_link, status) VALUES
(1, 3, 'Video', '2025-09-05', '10:00:00', 60, 'https://meet.google.com/abc-def-ghi', 'Scheduled'),
(4, 3, 'In-person', '2025-09-03', '14:00:00', 45, 'Conference Room A, 2nd Floor', 'Scheduled');

-- Create feedback table
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    interview_id INT NOT NULL,
    technical_rating INT CHECK (technical_rating BETWEEN 1 AND 10),
    communication_rating INT CHECK (communication_rating BETWEEN 1 AND 10),
    overall_rating INT CHECK (overall_rating BETWEEN 1 AND 10),
    strengths TEXT,
    weaknesses TEXT,
    comments TEXT,
    recommendation ENUM('Strongly Recommend', 'Recommend', 'Neutral', 'Do Not Recommend', 'Strongly Do Not Recommend'),
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (interview_id) REFERENCES interviews(id)
);

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

-- Insert sample notifications
INSERT INTO notifications (user_id, title, message, type) VALUES
(4, 'Application Submitted', 'Your application for Senior Software Engineer position has been submitted successfully.', 'success'),
(4, 'Application Update', 'Your application for Senior Software Engineer has been shortlisted for interview.', 'info'),
(7, 'Interview Scheduled', 'Your interview for Junior Data Analyst position has been scheduled for September 3rd.', 'info'),
(2, 'New Application', 'A new application has been received for the Marketing Specialist position.', 'info'),
(3, 'Interview Reminder', 'You have an interview scheduled with Priya Jayasinghe tomorrow at 2:00 PM.', 'warning');

-- Create access logs table
CREATE TABLE IF NOT EXISTS access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    action VARCHAR(255) NOT NULL,
    resource VARCHAR(255),
    method VARCHAR(10),
    status_code INT,
    response_time_ms INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert sample access logs
INSERT INTO access_logs (user_id, ip_address, user_agent, action, resource, method, status_code) VALUES
(1, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', 'User login', '/signin', 'POST', 200),
(2, '192.168.1.101', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', 'View dashboard', '/hradmin/dashboard', 'GET', 200),
(3, '192.168.1.102', 'Mozilla/5.0 (MacOS)', 'View applications', '/recruitment/applications', 'GET', 200),
(4, '192.168.1.103', 'Mozilla/5.0 (iPhone)', 'Apply for job', '/applicant/apply/1', 'POST', 200),
(NULL, '192.168.1.104', 'Mozilla/5.0 (Android)', 'Failed login attempt', '/signin', 'POST', 401);

-- Create system settings table (for future use)
CREATE TABLE IF NOT EXISTS system_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    description TEXT,
    updated_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Insert default system settings
INSERT INTO system_settings (setting_key, setting_value, description, updated_by) VALUES
('site_name', 'HireFlow', 'Name of the recruitment system', 1),
('max_file_size', '5242880', 'Maximum file upload size in bytes (5MB)', 1),
('allowed_file_types', 'pdf,doc,docx', 'Allowed file types for resume upload', 1),
('session_timeout', '3600', 'Session timeout in seconds', 1),
('email_notifications', 'true', 'Enable/disable email notifications', 1);

-- Show all tables
SHOW TABLES;

-- Display sample data
SELECT 'ROLES' as Table_Name;
SELECT * FROM roles;

SELECT 'USERS' as Table_Name;
SELECT id, full_name, email, role_id, status FROM users;

SELECT 'JOB POSTS' as Table_Name;
SELECT id, title, department, location, status, deadline FROM job_posts;

SELECT 'APPLICATIONS' as Table_Name;
SELECT id, applicant_id, job_id, status, applied_at FROM applications;





