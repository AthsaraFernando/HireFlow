CREATE TABLE IF NOT EXISTS `job_postings` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `company` VARCHAR(255) NOT NULL,
    `location` VARCHAR(255) NOT NULL,
    `salary` VARCHAR(100) NOT NULL,
    `department` VARCHAR(255) NOT NULL,
    `deadline` DATE NOT NULL,
    `description` TEXT,
    `status` ENUM('Open', 'Closed', 'Draft') DEFAULT 'Open',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
