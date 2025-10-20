-- application_table_migration
-- This sql query include adding columns, insert dummy data, and update statuses
-- ====================================================================

-- 1. Add applicant_name and job_title columns
ALTER TABLE applications 
ADD COLUMN applicant_name VARCHAR(255) AFTER applicant_id,
ADD COLUMN job_title VARCHAR(255) AFTER job_id;

-- 2. Insert 5 new dummy applications
INSERT INTO applications (applicant_id, applicant_name, job_id, job_title, resume_path, cover_letter, status) VALUES
(5, 'Hansini Perera', 3, 'Junior Data Analyst', '/uploads/resumes/hansini_resume_data.pdf', 'I am excited about the opportunity to work as a Data Analyst.', 'Applied'),
(6, 'Nuwan Silva', 5, 'Project Manager', '/uploads/resumes/nuwan_resume_pm.pdf', 'With my experience in coordinating teams, I believe I can excel as a Project Manager.', 'Under Review'),
(7, 'Priya Jayasinghe', 1, 'Senior Software Engineer', '/uploads/resumes/priya_resume_dev.pdf', 'I have 6 years of experience in full-stack development.', 'Applied'),
(8, 'Kamal Fernando', 2, 'Marketing Specialist', '/uploads/resumes/kamal_resume_marketing.pdf', 'My creative approach to digital marketing aligns perfectly with this position.', 'Applied'),
(4, 'Kelum Disanayake', 4, 'HR Assistant', '/uploads/resumes/kelum_resume_hr.pdf', 'I have excellent communication skills and interest in HR.', 'Applied');

-- 3. Update 3 applications to 'Shortlisted' status
UPDATE applications SET status = 'Shortlisted' WHERE id IN (8, 9);

