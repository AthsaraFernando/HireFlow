-- Add interview stage and interviewer role support to interviews table
-- This migration adds columns to support role-based interviewer assignment

ALTER TABLE interviews 
ADD COLUMN IF NOT EXISTS interview_stage ENUM('Screening', 'Technical', 'Managerial', 'HR Review', 'Final') DEFAULT 'Screening' AFTER interview_type,
ADD COLUMN IF NOT EXISTS interviewer_role ENUM('HR Admin', 'Recruitment Manager', 'Hiring Manager', 'Technical Lead', 'Panel') DEFAULT 'HR Admin' AFTER interviewer_id;

-- Update existing interviews to have default values
UPDATE interviews 
SET interview_stage = 'Screening', 
    interviewer_role = CASE 
        WHEN (SELECT role_id FROM users WHERE users.id = interviews.interviewer_id) = 2 THEN 'HR Admin'
        WHEN (SELECT role_id FROM users WHERE users.id = interviews.interviewer_id) = 3 THEN 'Recruitment Manager'
        ELSE 'HR Admin'
    END
WHERE interview_stage IS NULL OR interviewer_role IS NULL;