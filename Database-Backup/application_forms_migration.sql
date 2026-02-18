
USE hireflow_db;


CREATE TABLE IF NOT EXISTS application_forms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_post_id INT NOT NULL,
    created_by INT NOT NULL, 
    form_title VARCHAR(200) NOT NULL,
    form_description TEXT,
    status ENUM('active', 'inactive', 'draft') DEFAULT 'draft',
    
    job_title VARCHAR(200),
    department VARCHAR(100),
    location VARCHAR(100),
    employment_type VARCHAR(50),
    
    -- Form metadata
    total_fields INT DEFAULT 0,
    submission_count INT DEFAULT 0,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published_at TIMESTAMP NULL,
    
    UNIQUE KEY unique_form_per_job (job_post_id),
    FOREIGN KEY (job_post_id) REFERENCES job_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX idx_status (status),
    INDEX idx_created_by (created_by),
    INDEX idx_job_post_id (job_post_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS application_form_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    form_id INT NOT NULL,
    field_category VARCHAR(100) NOT NULL, 
    field_name VARCHAR(100) NOT NULL, 
    field_label VARCHAR(200) NOT NULL,
    field_type VARCHAR(50) NOT NULL, 
    field_options TEXT NULL, 
    is_required BOOLEAN DEFAULT FALSE,
    is_enabled BOOLEAN DEFAULT TRUE,
    field_order INT DEFAULT 0,
    validation_rules TEXT NULL, -- JSON for validation rules
    placeholder VARCHAR(200),
    help_text TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (form_id) REFERENCES application_forms(id) ON DELETE CASCADE,
    INDEX idx_form_id (form_id),
    INDEX idx_field_category (field_category),
    INDEX idx_field_order (form_id, field_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE applications 
ADD COLUMN IF NOT EXISTS form_data JSON DEFAULT NULL COMMENT 'Stores form field responses as JSON',
ADD COLUMN IF NOT EXISTS form_id INT DEFAULT NULL COMMENT 'Reference to the application form used',
ADD INDEX IF NOT EXISTS idx_form_id (form_id);


SELECT 'APPLICATION FORMS MIGRATION COMPLETED' as status;

SHOW TABLES LIKE 'application_%';

-- Show table structures
DESCRIBE application_forms;
DESCRIBE application_form_fields;

-- Show the modified applications table
DESCRIBE applications;

-- Show record counts
SELECT 
    'application_forms' as table_name, COUNT(*) as record_count FROM application_forms
UNION ALL SELECT 
    'application_form_fields' as table_name, COUNT(*) as record_count FROM application_form_fields;


