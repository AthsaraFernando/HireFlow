CREATE DATABASE hireflow_db;
USE hireflow_db;

CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE -- ['System Admin', 'HR Admin', 'Recruitment Manager', 'Applicant']
)

INSERT INTO roles (role_name) VALUES
('System Admin'),
('HR Admin'),
('Recruitment Manager'),
('Applicant');

DROP TABLE roles;
DROP TABLE users;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- System Admin
INSERT INTO users (full_name, email, password, role_id, status)
VALUES ('Sineth Mendis', 'sineth@hireflow.com', 'admin123', 1, 'active');

-- HR Admin
INSERT INTO users (full_name, email, password, role_id, status)
VALUES ('Hasindu Rodrigo', 'hasindu@hireflow.com', 'hradmin123', 2, 'active');

-- Recruitment Manager
INSERT INTO users (full_name, email, password, role_id, status)
VALUES ('Tehan Fernando', 'tehan@hireflow.com', 'recruit123', 3, 'active');

-- Applicants
INSERT INTO users (full_name, email, password, role_id, status)
VALUES 
('Athsara Manitha', 'athsara1@gmail.com', 'applicant1', 4, 'active'),
('Chamali Perera', 'chamali.perera@gmail.com', 'applicant2', 4, 'active'),
('Nuwan Silva', 'nuwan.silva@gmail.com', 'applicant3', 4, 'active');

SELECT * FROM roles;
SELECT * FROM users;

DELETE FROM users;
DELETE FROM roles;

CREATE TABLE IF NOT EXISTS job_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hr_id INT NOT NULL, -- created by HR Admin
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    department VARCHAR(100),
    location VARCHAR(100),
    deadline DATE,
    status ENUM('Open', 'Closed', 'Draft') DEFAULT 'Draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hr_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    applicant_id INT NOT NULL,
    job_id INT NOT NULL,
    resume_path VARCHAR(255) NOT NULL,
    cover_letter TEXT,
    status ENUM('Applied', 'Shortlisted', 'Interview', 'Rejected', 'Offered') DEFAULT 'Applied',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(applicant_id, job_id), -- Only one application per job
    FOREIGN KEY (applicant_id) REFERENCES users(id),
    FOREIGN KEY (job_id) REFERENCES job_posts(id)
);

CREATE TABLE IF NOT EXISTS interviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    interviewer_id INT NOT NULL, -- Recruitment Manager
    scheduled_time DATETIME NOT NULL,
    status ENUM('Scheduled', 'Completed', 'Canceled') DEFAULT 'Scheduled',
    FOREIGN KEY (application_id) REFERENCES applications(id),
    FOREIGN KEY (interviewer_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    interview_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 10),
    comments TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (interview_id) REFERENCES interviews(id)
);

CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(255),
    log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

SHOW TABLES;
DROP DATABASE hireflow_db;





