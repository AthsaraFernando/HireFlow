-- ====================================================================
-- INTERVIEW EVALUATIONS MIGRATION
-- ====================================================================
-- Purpose: Create a dedicated table for recruitment manager interview
--          feedback with score fields, recommendation, and soft delete.
-- Date: 2026-04-12
-- ====================================================================

USE hireflow_db;

START TRANSACTION;

CREATE TABLE IF NOT EXISTS interview_evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    interview_id INT NOT NULL,
    technical_skills TINYINT NOT NULL,
    problem_solving TINYINT NOT NULL,
    communication TINYINT NOT NULL,
    cultural_fit TINYINT NOT NULL,
    experience_relevance TINYINT NOT NULL,
    manager_points TINYINT NOT NULL,
    interview_notes TEXT,
    recommendation ENUM('Hire', 'Reject', 'Pending') NOT NULL,
    created_by INT NOT NULL,
    updated_by INT DEFAULT NULL,
    is_deleted TINYINT(1) NOT NULL DEFAULT 0,
    deleted_by INT DEFAULT NULL,
    deleted_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT uq_interview_evaluations_interview UNIQUE (interview_id),
    CONSTRAINT fk_interview_evaluations_interview
        FOREIGN KEY (interview_id) REFERENCES interviews(id),
    CONSTRAINT fk_interview_evaluations_created_by
        FOREIGN KEY (created_by) REFERENCES users(id),
    CONSTRAINT fk_interview_evaluations_updated_by
        FOREIGN KEY (updated_by) REFERENCES users(id),
    CONSTRAINT fk_interview_evaluations_deleted_by
        FOREIGN KEY (deleted_by) REFERENCES users(id),

    CONSTRAINT chk_technical_skills_range CHECK (technical_skills BETWEEN 1 AND 10),
    CONSTRAINT chk_problem_solving_range CHECK (problem_solving BETWEEN 1 AND 10),
    CONSTRAINT chk_communication_range CHECK (communication BETWEEN 1 AND 10),
    CONSTRAINT chk_cultural_fit_range CHECK (cultural_fit BETWEEN 1 AND 10),
    CONSTRAINT chk_experience_relevance_range CHECK (experience_relevance BETWEEN 1 AND 10),
    CONSTRAINT chk_manager_points_range CHECK (manager_points BETWEEN 1 AND 50)
);

CREATE INDEX idx_interview_evaluations_recommendation
    ON interview_evaluations(recommendation, is_deleted);

CREATE INDEX idx_interview_evaluations_deleted
    ON interview_evaluations(is_deleted, deleted_at);

COMMIT;

-- Verification
SELECT 'interview_evaluations table created/verified' AS migration_status;
DESCRIBE interview_evaluations;
