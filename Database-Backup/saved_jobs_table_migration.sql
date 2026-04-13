-- Saved jobs table for applicants
CREATE TABLE IF NOT EXISTS saved_jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    applicant_id INT NOT NULL,
    job_id INT NOT NULL,
    note TEXT,
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_saved_job (applicant_id, job_id),
    INDEX idx_saved_jobs_applicant (applicant_id),
    INDEX idx_saved_jobs_job (job_id),
    CONSTRAINT fk_saved_jobs_applicant
        FOREIGN KEY (applicant_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_saved_jobs_job
        FOREIGN KEY (job_id) REFERENCES job_posts(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
