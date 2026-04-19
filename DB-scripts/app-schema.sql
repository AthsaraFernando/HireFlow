-- HireFlow database rebuild script
-- Target database: hireflow_two

CREATE DATABASE IF NOT EXISTS hireflow_two
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE hireflow_two;

-- 1. roles
CREATE TABLE IF NOT EXISTS roles (
  id INT(11) NOT NULL AUTO_INCREMENT,
  role_name VARCHAR(50) NOT NULL,
  description TEXT DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY role_name (role_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. users
CREATE TABLE IF NOT EXISTS users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  full_name VARCHAR(255) NOT NULL,
  role_id INT(11) NOT NULL,
  phone VARCHAR(20) DEFAULT NULL,
  address TEXT DEFAULT NULL,
  status ENUM('active','inactive','suspended') DEFAULT 'active',
  deleted_at DATETIME DEFAULT NULL,
  deleted_by INT(11) DEFAULT NULL,
  deleted_email VARCHAR(100) DEFAULT NULL,
  delete_reason VARCHAR(255) DEFAULT NULL,
  last_login TIMESTAMP NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  profile_picture VARCHAR(255) DEFAULT NULL,
  password_reset_token VARCHAR(255) DEFAULT NULL,
  password_reset_expires DATETIME DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY email (email),
  KEY role_id (role_id),
  KEY idx_users_deleted_at (deleted_at),
  KEY idx_users_deleted_by (deleted_by),
  CONSTRAINT fk_users_deleted_by FOREIGN KEY (deleted_by) REFERENCES users (id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT users_ibfk_1 FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. system_settings
CREATE TABLE IF NOT EXISTS system_settings (
  id INT(11) NOT NULL AUTO_INCREMENT,
  setting_key VARCHAR(100) NOT NULL,
  setting_value TEXT DEFAULT NULL,
  description TEXT DEFAULT NULL,
  updated_by INT(11) DEFAULT NULL,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY setting_key (setting_key),
  KEY updated_by (updated_by),
  CONSTRAINT system_settings_ibfk_1 FOREIGN KEY (updated_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4. access_logs
CREATE TABLE IF NOT EXISTS access_logs (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) DEFAULT NULL,
  ip_address VARCHAR(45) DEFAULT NULL,
  action VARCHAR(255) NOT NULL,
  details TEXT DEFAULT NULL,
  user_agent TEXT DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  CONSTRAINT access_logs_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 5. departments
CREATE TABLE IF NOT EXISTS departments (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  description TEXT DEFAULT NULL,
  head_of_department INT(11) DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY name (name),
  KEY head_of_department (head_of_department),
  CONSTRAINT departments_ibfk_1 FOREIGN KEY (head_of_department) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 6. job_posts
CREATE TABLE IF NOT EXISTS job_posts (
  id INT(11) NOT NULL AUTO_INCREMENT,
  hr_id INT(11) NOT NULL,
  title VARCHAR(200) NOT NULL,
  department_id INT(11) DEFAULT NULL,
  description TEXT NOT NULL,
  requirements TEXT DEFAULT NULL,
  department VARCHAR(100) DEFAULT NULL,
  location VARCHAR(100) DEFAULT NULL,
  salary_range VARCHAR(100) DEFAULT NULL,
  employment_type ENUM('Full-time','Part-time','Contract','Internship') DEFAULT 'Full-time',
  deadline DATE DEFAULT NULL,
  status ENUM('Open','Closed','Draft') DEFAULT 'Draft',
  is_deleted TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY hr_id (hr_id),
  KEY department_id (department_id),
  KEY idx_is_deleted (is_deleted),
  KEY idx_status_deleted (status, is_deleted),
  CONSTRAINT job_posts_ibfk_1 FOREIGN KEY (hr_id) REFERENCES users (id),
  CONSTRAINT job_posts_ibfk_2 FOREIGN KEY (department_id) REFERENCES departments (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 7. applications
CREATE TABLE IF NOT EXISTS applications (
  id INT(11) NOT NULL AUTO_INCREMENT,
  applicant_id INT(11) NOT NULL,
  job_id INT(11) NOT NULL,
  resume_path VARCHAR(255) NOT NULL,
  cover_letter TEXT DEFAULT NULL,
  status ENUM('Applied','Under Review','Shortlisted','Interview Scheduled','Rejected','Offered') DEFAULT 'Applied',
  applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  form_data LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Stores form field responses as JSON' CHECK (json_valid(form_data)),
  form_id INT(11) DEFAULT NULL COMMENT 'Reference to the application form used',
  PRIMARY KEY (id),
  UNIQUE KEY applicant_id (applicant_id, job_id),
  KEY job_id (job_id),
  KEY idx_form_id (form_id),
  CONSTRAINT applications_ibfk_1 FOREIGN KEY (applicant_id) REFERENCES users (id),
  CONSTRAINT applications_ibfk_2 FOREIGN KEY (job_id) REFERENCES job_posts (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 8. db_backups
CREATE TABLE IF NOT EXISTS db_backups (
  id INT(11) NOT NULL AUTO_INCREMENT,
  backup_name VARCHAR(255) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  file_size BIGINT DEFAULT NULL,
  status VARCHAR(20) DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  restored_at DATETIME DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 9. interviews
CREATE TABLE IF NOT EXISTS interviews (
  id INT(11) NOT NULL AUTO_INCREMENT,
  application_id INT(11) NOT NULL,
  interviewer_id INT(11) NOT NULL,
  interview_type ENUM('Phone','Video','In-person','Panel') DEFAULT 'Video',
  scheduled_date DATE NOT NULL,
  scheduled_time TIME NOT NULL,
  duration_minutes INT(11) DEFAULT 60,
  location VARCHAR(255) DEFAULT NULL,
  meeting_link VARCHAR(500) DEFAULT NULL,
  status ENUM('Pending','Scheduled','Completed','Canceled','Rescheduled') NOT NULL DEFAULT 'Scheduled',
  notes TEXT DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY application_id (application_id),
  KEY idx_scheduled_date (scheduled_date),
  KEY idx_interviewer_status (interviewer_id, status),
  CONSTRAINT interviews_ibfk_1 FOREIGN KEY (application_id) REFERENCES applications (id),
  CONSTRAINT interviews_ibfk_2 FOREIGN KEY (interviewer_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 10. notifications
CREATE TABLE IF NOT EXISTS notifications (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  title VARCHAR(200) NOT NULL,
  message TEXT NOT NULL,
  type ENUM('info','success','warning','error') DEFAULT 'info',
  is_read TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  CONSTRAINT notifications_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 11. application_forms
CREATE TABLE IF NOT EXISTS application_forms (
  id INT(11) NOT NULL AUTO_INCREMENT,
  job_post_id INT(11) NOT NULL,
  created_by INT(11) NOT NULL,
  form_title VARCHAR(200) NOT NULL,
  form_description TEXT DEFAULT NULL,
  status ENUM('active','inactive','draft') DEFAULT 'draft',
  is_deleted TINYINT(1) DEFAULT 0,
  total_fields INT(11) DEFAULT 0,
  submission_count INT(11) DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  published_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY unique_form_per_job (job_post_id),
  KEY idx_status (status),
  KEY idx_created_by (created_by),
  KEY idx_job_post_id (job_post_id),
  KEY idx_is_deleted (is_deleted),
  CONSTRAINT application_forms_ibfk_1 FOREIGN KEY (job_post_id) REFERENCES job_posts (id) ON DELETE CASCADE,
  CONSTRAINT application_forms_ibfk_2 FOREIGN KEY (created_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. application_form_fields
CREATE TABLE IF NOT EXISTS application_form_fields (
  id INT(11) NOT NULL AUTO_INCREMENT,
  form_id INT(11) NOT NULL,
  field_category VARCHAR(100) NOT NULL,
  field_name VARCHAR(100) NOT NULL,
  field_label VARCHAR(200) NOT NULL,
  field_type VARCHAR(50) NOT NULL,
  field_options TEXT DEFAULT NULL,
  is_required TINYINT(1) DEFAULT 0,
  is_enabled TINYINT(1) DEFAULT 1,
  is_deleted TINYINT(1) DEFAULT 0,
  field_order INT(11) DEFAULT 0,
  validation_rules TEXT DEFAULT NULL,
  placeholder VARCHAR(200) DEFAULT NULL,
  help_text TEXT DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_form_id (form_id),
  KEY idx_field_category (field_category),
  KEY idx_field_order (form_id, field_order),
  KEY idx_is_deleted (is_deleted),
  CONSTRAINT application_form_fields_ibfk_1 FOREIGN KEY (form_id) REFERENCES application_forms (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. interview_evaluations
CREATE TABLE IF NOT EXISTS interview_evaluations (
  id INT(11) NOT NULL AUTO_INCREMENT,
  interview_id INT(11) NOT NULL,
  technical_skills TINYINT(4) NOT NULL,
  problem_solving TINYINT(4) NOT NULL,
  communication TINYINT(4) NOT NULL,
  cultural_fit TINYINT(4) NOT NULL,
  experience_relevance TINYINT(4) NOT NULL,
  manager_points TINYINT(4) NOT NULL,
  interview_notes TEXT DEFAULT NULL,
  recommendation ENUM('Hire','Reject','Pending') NOT NULL,
  created_by INT(11) NOT NULL,
  updated_by INT(11) DEFAULT NULL,
  is_deleted TINYINT(1) NOT NULL DEFAULT 0,
  deleted_by INT(11) DEFAULT NULL,
  deleted_at DATETIME DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_interview_evaluations_interview (interview_id),
  KEY fk_interview_evaluations_created_by (created_by),
  KEY fk_interview_evaluations_updated_by (updated_by),
  KEY fk_interview_evaluations_deleted_by (deleted_by),
  KEY idx_interview_evaluations_recommendation (recommendation, is_deleted),
  KEY idx_interview_evaluations_deleted (is_deleted, deleted_at),
  CONSTRAINT fk_interview_evaluations_interview FOREIGN KEY (interview_id) REFERENCES interviews (id),
  CONSTRAINT fk_interview_evaluations_created_by FOREIGN KEY (created_by) REFERENCES users (id),
  CONSTRAINT fk_interview_evaluations_updated_by FOREIGN KEY (updated_by) REFERENCES users (id),
  CONSTRAINT fk_interview_evaluations_deleted_by FOREIGN KEY (deleted_by) REFERENCES users (id),
  CONSTRAINT chk_technical_skills_range CHECK (technical_skills BETWEEN 1 AND 10),
  CONSTRAINT chk_problem_solving_range CHECK (problem_solving BETWEEN 1 AND 10),
  CONSTRAINT chk_communication_range CHECK (communication BETWEEN 1 AND 10),
  CONSTRAINT chk_cultural_fit_range CHECK (cultural_fit BETWEEN 1 AND 10),
  CONSTRAINT chk_experience_relevance_range CHECK (experience_relevance BETWEEN 1 AND 10),
  CONSTRAINT chk_manager_points_range CHECK (manager_points BETWEEN 1 AND 50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 14. job_categories
CREATE TABLE IF NOT EXISTS job_categories (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  department INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY name (name),
  KEY idx_job_categories_department (department),
  CONSTRAINT fk_job_categories_department FOREIGN KEY (department) REFERENCES departments (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 15. saved_jobs
CREATE TABLE IF NOT EXISTS saved_jobs (
  id INT(11) NOT NULL AUTO_INCREMENT,
  applicant_id INT(11) NOT NULL,
  job_id INT(11) NOT NULL,
  note TEXT DEFAULT NULL,
  saved_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY unique_saved_job (applicant_id, job_id),
  KEY idx_saved_jobs_applicant (applicant_id),
  KEY idx_saved_jobs_job (job_id),
  CONSTRAINT fk_saved_jobs_applicant FOREIGN KEY (applicant_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_saved_jobs_job FOREIGN KEY (job_id) REFERENCES job_posts (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 16. announcements
CREATE TABLE IF NOT EXISTS announcements (
  id INT(11) NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  created_by INT(11) DEFAULT NULL,
  updated_by INT(11) DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY fk_announcements_created_by (created_by),
  KEY fk_announcements_updated_by (updated_by),
  CONSTRAINT fk_announcements_created_by FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_announcements_updated_by FOREIGN KEY (updated_by) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
