-- Report demo data migration
-- Purpose: add realistic DB records so HR reports change based on live tables.

USE hireflow_db;

-- 1) Ensure applications can represent completed hires used by report logic
ALTER TABLE applications
MODIFY COLUMN status ENUM('Applied','Under Review','Shortlisted','Interview Scheduled','Rejected','Offered','Hired') DEFAULT 'Applied';

-- 2) Add source tracking column used by report source aggregation
ALTER TABLE applications
ADD COLUMN IF NOT EXISTS application_source VARCHAR(100) NULL AFTER status;

-- 3) Seed diverse applications in the last 30 days (idempotent by applicant_id + job_id unique key)
INSERT IGNORE INTO applications
(applicant_id, job_id, resume_path, cover_letter, status, application_source, applied_at)
VALUES
(46, 18, '/uploads/resumes/demo_46_18.pdf', 'Demo report seed', 'Hired', 'LinkedIn', '2026-04-10 09:15:00'),
(59, 17, '/uploads/resumes/demo_59_17.pdf', 'Demo report seed', 'Offered', 'Indeed', '2026-04-08 10:30:00'),
(65, 14, '/uploads/resumes/demo_65_14.pdf', 'Demo report seed', 'Interview Scheduled', 'Company Website', '2026-04-06 14:00:00'),
(66, 15, '/uploads/resumes/demo_66_15.pdf', 'Demo report seed', 'Shortlisted', 'Referral', '2026-04-03 11:20:00'),
(67, 16, '/uploads/resumes/demo_67_16.pdf', 'Demo report seed', 'Under Review', 'LinkedIn', '2026-04-01 16:40:00'),
(5, 25, '/uploads/resumes/demo_5_25.pdf', 'Demo report seed', 'Applied', 'Job Fair', '2026-03-28 08:45:00'),
(2, 14, '/uploads/resumes/demo_2_14.pdf', 'Demo report seed', 'Hired', 'Company Website', '2026-03-21 13:10:00');

-- 4) Seed interviews tied to seeded applications (idempotent by app/interviewer/date/time)
INSERT INTO interviews
(application_id, interviewer_id, interview_type, scheduled_date, scheduled_time, duration_minutes, location, meeting_link, status, notes)
SELECT a.id, 3, 'Video', '2026-04-12', '10:00:00', 60, 'Online', 'https://meet.example.com/seed-1', 'Completed', 'Seeded for report demo'
FROM applications a
WHERE a.applicant_id = 46 AND a.job_id = 18
AND NOT EXISTS (
    SELECT 1 FROM interviews i
    WHERE i.application_id = a.id
      AND i.interviewer_id = 3
      AND i.scheduled_date = '2026-04-12'
      AND i.scheduled_time = '10:00:00'
);

INSERT INTO interviews
(application_id, interviewer_id, interview_type, scheduled_date, scheduled_time, duration_minutes, location, meeting_link, status, notes)
SELECT a.id, 4, 'In-person', '2026-04-09', '11:30:00', 45, 'HQ Room A', NULL, 'Completed', 'Seeded for report demo'
FROM applications a
WHERE a.applicant_id = 59 AND a.job_id = 17
AND NOT EXISTS (
    SELECT 1 FROM interviews i
    WHERE i.application_id = a.id
      AND i.interviewer_id = 4
      AND i.scheduled_date = '2026-04-09'
      AND i.scheduled_time = '11:30:00'
);

INSERT INTO interviews
(application_id, interviewer_id, interview_type, scheduled_date, scheduled_time, duration_minutes, location, meeting_link, status, notes)
SELECT a.id, 3, 'Phone', '2026-04-15', '09:45:00', 30, 'Phone', NULL, 'Scheduled', 'Seeded for report demo'
FROM applications a
WHERE a.applicant_id = 65 AND a.job_id = 14
AND NOT EXISTS (
    SELECT 1 FROM interviews i
    WHERE i.application_id = a.id
      AND i.interviewer_id = 3
      AND i.scheduled_date = '2026-04-15'
      AND i.scheduled_time = '09:45:00'
);

INSERT INTO interviews
(application_id, interviewer_id, interview_type, scheduled_date, scheduled_time, duration_minutes, location, meeting_link, status, notes)
SELECT a.id, 4, 'Video', '2026-03-25', '15:15:00', 60, 'Online', 'https://meet.example.com/seed-4', 'Completed', 'Seeded for report demo'
FROM applications a
WHERE a.applicant_id = 2 AND a.job_id = 14
AND NOT EXISTS (
    SELECT 1 FROM interviews i
    WHERE i.application_id = a.id
      AND i.interviewer_id = 4
      AND i.scheduled_date = '2026-03-25'
      AND i.scheduled_time = '15:15:00'
);
