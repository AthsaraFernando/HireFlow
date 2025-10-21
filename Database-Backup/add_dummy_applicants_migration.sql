-- ====================================================================
-- ADD DUMMY APPLICANTS MIGRATION
-- Date: October 21, 2025
-- ====================================================================
-- This migration adds 4 new applicant users and their applications
-- 2 applications will have 'Shortlisted' status for testing interview scheduling
-- ====================================================================

-- STEP 1: Add 4 new applicant users (role_id = 4)
-- ====================================================================

INSERT INTO users (email, password, full_name, role_id, phone, address, status, created_at, updated_at) VALUES
('shenal.mevindu@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Shenal Mevindu', 4, '+94771234501', '123 Main Street, Colombo', 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('tharindu.dilshan@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Tharindu Dilshan', 4, '+94771234502', '456 Lake Road, Kandy', 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('abhijith.kandauda@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Abhijith Kandauda', 4, '+94771234503', '789 Hill View, Galle', 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('dilshan.paris@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dilshan Paris', 4, '+94771234504', '321 Beach Road, Matara', 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Note: Password hash is for 'password' (bcrypt hashed)
-- Users can login with: email and password: 'password'

-- STEP 2: Add applications for these users
-- ====================================================================
-- 2 applications with 'Shortlisted' status (for Shenal and Tharindu)
-- 2 applications with other statuses (for Abhijith and Dilshan)

-- Get the user IDs (they will be auto-incremented from current max ID)
-- Assuming current max user ID is 8, new users will be 9, 10, 11, 12
-- Adjust if needed based on your database

-- Application 1: Shenal Mevindu - Software Engineer (Shortlisted)
INSERT INTO applications (applicant_id, job_id, resume_path, cover_letter, status, applied_at) 
VALUES (
    (SELECT id FROM users WHERE email = 'shenal.mevindu@gmail.com'),
    1,  -- Software Engineer job
    '/uploads/resumes/shenal_mevindu_resume.pdf',
    'Dear Hiring Manager,\n\nI am writing to express my strong interest in the Software Engineer position. With my solid foundation in computer science and hands-on experience in web development, I am confident in my ability to contribute to your team.\n\nI have extensive experience working with PHP, JavaScript, and modern frameworks. I am passionate about writing clean, maintainable code and following best practices.\n\nI look forward to the opportunity to discuss how my skills can benefit your organization.\n\nBest regards,\nShenal Mevindu',
    'Shortlisted',
    CURRENT_TIMESTAMP
);

-- Application 2: Tharindu Dilshan - Marketing Specialist (Shortlisted)
INSERT INTO applications (applicant_id, job_id, resume_path, cover_letter, status, applied_at) 
VALUES (
    (SELECT id FROM users WHERE email = 'tharindu.dilshan@gmail.com'),
    2,  -- Marketing Specialist job
    '/uploads/resumes/tharindu_dilshan_resume.pdf',
    'Dear Hiring Manager,\n\nI am excited to apply for the Marketing Specialist position. With my background in digital marketing and proven track record in social media campaigns, I believe I would be a valuable addition to your marketing team.\n\nMy experience includes SEO optimization, content creation, and analytics-driven marketing strategies. I am eager to bring my creative approach and analytical skills to your organization.\n\nThank you for considering my application.\n\nSincerely,\nTharindu Dilshan',
    'Shortlisted',
    CURRENT_TIMESTAMP
);

-- Application 3: Abhijith Kandauda - Data Analyst (Applied)
INSERT INTO applications (applicant_id, job_id, resume_path, cover_letter, status, applied_at) 
VALUES (
    (SELECT id FROM users WHERE email = 'abhijith.kandauda@gmail.com'),
    3,  -- Data Analyst job
    '/uploads/resumes/abhijith_kandauda_resume.pdf',
    'Dear Hiring Manager,\n\nI am applying for the Data Analyst position with great enthusiasm. My strong analytical skills and proficiency in data analysis tools make me an ideal candidate for this role.\n\nI have experience working with SQL, Python, and various data visualization tools. I am passionate about turning data into actionable insights.\n\nI would welcome the opportunity to discuss my qualifications further.\n\nBest regards,\nAbhijith Kandauda',
    'Applied',
    CURRENT_TIMESTAMP
);

-- Application 4: Dilshan Paris - Software Engineer (Under Review)
INSERT INTO applications (applicant_id, job_id, resume_path, cover_letter, status, applied_at) 
VALUES (
    (SELECT id FROM users WHERE email = 'dilshan.paris@gmail.com'),
    1,  -- Software Engineer job
    '/uploads/resumes/dilshan_paris_resume.pdf',
    'Dear Hiring Manager,\n\nI am writing to apply for the Software Engineer position. With my background in computer science and passion for software development, I am confident I can make meaningful contributions to your team.\n\nI have strong skills in full-stack development, including experience with PHP, JavaScript, React, and MySQL. I am a quick learner and always eager to adopt new technologies.\n\nThank you for your time and consideration.\n\nSincerely,\nDilshan Paris',
    'Under Review',
    CURRENT_TIMESTAMP
);

-- ====================================================================
-- VERIFICATION QUERIES
-- ====================================================================
-- Run these queries after executing the migration to verify the data

-- 1. Verify new users were created
-- SELECT id, email, full_name, role_id FROM users WHERE email IN ('shenal.mevindu@gmail.com', 'tharindu.dilshan@gmail.com', 'abhijith.kandauda@gmail.com', 'dilshan.paris@gmail.com');

-- 2. Verify applications were created
-- SELECT a.id, u.full_name, jp.title, a.status 
-- FROM applications a 
-- JOIN users u ON a.applicant_id = u.id 
-- JOIN job_posts jp ON a.job_id = jp.id 
-- WHERE u.email IN ('shenal.mevindu@gmail.com', 'tharindu.dilshan@gmail.com', 'abhijith.kandauda@gmail.com', 'dilshan.paris@gmail.com');

-- 3. Verify shortlisted candidates for interview scheduling
-- SELECT a.id as application_id, u.full_name as candidate_name, u.role_id, jp.title as job_title, a.status
-- FROM applications a
-- JOIN users u ON a.applicant_id = u.id
-- JOIN job_posts jp ON a.job_id = jp.id
-- LEFT JOIN interviews i ON a.id = i.application_id
-- WHERE a.status = 'Shortlisted' 
-- AND u.role_id = 4
-- AND i.id IS NULL
-- ORDER BY a.applied_at DESC;

-- ====================================================================
-- SUMMARY
-- ====================================================================
-- Users Added: 4
--   1. Shenal Mevindu (Applicant - Shortlisted for Software Engineer)
--   2. Tharindu Dilshan (Applicant - Shortlisted for Marketing Specialist)
--   3. Abhijith Kandauda (Applicant - Applied for Data Analyst)
--   4. Dilshan Paris (Applicant - Under Review for Software Engineer)
--
-- Applications Added: 4
--   - 2 with 'Shortlisted' status (ready for interview scheduling)
--   - 1 with 'Applied' status
--   - 1 with 'Under Review' status
--
-- All users have role_id = 4 (Applicant)
-- Password for all users: 'password'
-- ====================================================================
