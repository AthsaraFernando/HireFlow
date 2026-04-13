START TRANSACTION;

CREATE TABLE IF NOT EXISTS job_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    department INT NOT NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_job_categories_department (department),
    CONSTRAINT fk_job_categories_department
        FOREIGN KEY (department) REFERENCES departments(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
