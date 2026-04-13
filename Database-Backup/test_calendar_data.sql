-- Test data for dynamic calendar display
-- Run this to populate some sample interviews for testing

USE hireflow_db;

-- Insert a few test interviews for this week
-- Note: Adjust dates to current week for testing

SET @today = CURDATE();
SET @monday = DATE_SUB(@today, INTERVAL WEEKDAY(@today) DAY);

-- Sample interview 1: Monday 10 AM
INSERT INTO interviews (
    application_id, 
    interviewer_id, 
    interviewer_role,
    interview_type, 
    interview_stage,
    scheduled_date, 
    scheduled_time, 
    duration_minutes, 
    meeting_link, 
    status
) 
SELECT 
    a.id,
    (SELECT id FROM users WHERE role_id = 2 LIMIT 1),
    'HR Admin',
    'Video',
    'Screening',
    DATE_ADD(@monday, INTERVAL 0 DAY),
    '10:00:00',
    60,
    'https://zoom.us/j/test123',
    'Scheduled'
FROM applications a 
WHERE a.status = 'Shortlisted' 
LIMIT 1;

-- Sample interview 2: Tuesday 2 PM
INSERT INTO interviews (
    application_id, 
    interviewer_id, 
    interviewer_role,
    interview_type, 
    interview_stage,
    scheduled_date, 
    scheduled_time, 
    duration_minutes, 
    location, 
    status
) 
SELECT 
    a.id,
    (SELECT id FROM users WHERE role_id = 3 LIMIT 1),
    'Recruitment Manager',
    'In-person',
    'Technical',
    DATE_ADD(@monday, INTERVAL 1 DAY),
    '14:00:00',
    90,
    'Conference Room A',
    'Scheduled'
FROM applications a 
WHERE a.status = 'Shortlisted' 
AND a.id NOT IN (SELECT application_id FROM interviews)
LIMIT 1;

-- Sample interview 3: Wednesday 11 AM
INSERT INTO interviews (
    application_id, 
    interviewer_id, 
    interviewer_role,
    interview_type, 
    interview_stage,
    scheduled_date, 
    scheduled_time, 
    duration_minutes, 
    meeting_link, 
    status
) 
SELECT 
    a.id,
    (SELECT id FROM users WHERE role_id = 3 LIMIT 1),
    'Recruitment Manager',
    'Video',
    'Managerial',
    DATE_ADD(@monday, INTERVAL 2 DAY),
    '11:00:00',
    60,
    'https://meet.google.com/test456',
    'Scheduled'
FROM applications a 
WHERE a.status = 'Shortlisted' 
AND a.id NOT IN (SELECT application_id FROM interviews)
LIMIT 1;

-- Sample interview 4: Friday 1 PM
INSERT INTO interviews (
    application_id, 
    interviewer_id, 
    interviewer_role,
    interview_type, 
    interview_stage,
    scheduled_date, 
    scheduled_time, 
    duration_minutes, 
    meeting_link, 
    status
) 
SELECT 
    a.id,
    (SELECT id FROM users WHERE role_id = 2 LIMIT 1),
    'HR Admin',
    'Video',
    'Final',
    DATE_ADD(@monday, INTERVAL 4 DAY),
    '13:00:00',
    45,
    'https://zoom.us/j/final789',
    'Scheduled'
FROM applications a 
WHERE a.status = 'Shortlisted' 
AND a.id NOT IN (SELECT application_id FROM interviews)
LIMIT 1;

SELECT 'Sample interviews created for this week!' as status;