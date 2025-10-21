-- ====================================================================
-- INTERVIEW TABLE UPDATES
-- ====================================================================
-- Migration file to update the interviews table structure
-- Created: October 20, 2025
-- Purpose: Add missing columns and update status enum for interview scheduling
-- ====================================================================

USE hireflow_db;

-- Check current table structure
SELECT 'Current interviews table structure:' as info;
DESCRIBE interviews;

-- Add missing columns if they don't exist

-- Add interview_type column
ALTER TABLE interviews 
ADD COLUMN IF NOT EXISTS interview_type ENUM('Phone', 'Video', 'In-person', 'Panel') DEFAULT 'Video' 
AFTER interviewer_id;

-- Add duration_minutes column
ALTER TABLE interviews 
ADD COLUMN IF NOT EXISTS duration_minutes INT DEFAULT 60 
AFTER scheduled_time;

-- Add location column
ALTER TABLE interviews 
ADD COLUMN IF NOT EXISTS location VARCHAR(255) 
AFTER duration_minutes;

-- Add meeting_link column
ALTER TABLE interviews 
ADD COLUMN IF NOT EXISTS meeting_link VARCHAR(500) 
AFTER location;

-- Add notes column
ALTER TABLE interviews 
ADD COLUMN IF NOT EXISTS notes TEXT 
AFTER meeting_link;

-- Add updated_at column
ALTER TABLE interviews 
ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
AFTER created_at;

-- Update status enum to include 'Pending' and 'Rescheduled'
ALTER TABLE interviews 
MODIFY COLUMN status ENUM('Pending', 'Scheduled', 'Completed', 'Canceled', 'Rescheduled') DEFAULT 'Pending';

-- Add indexes for better performance on scheduled interviews queries
ALTER TABLE interviews ADD INDEX IF NOT EXISTS idx_scheduled_date (scheduled_date);
ALTER TABLE interviews ADD INDEX IF NOT EXISTS idx_interviewer_status (interviewer_id, status);
ALTER TABLE interviews ADD INDEX IF NOT EXISTS idx_status_date (status, scheduled_date);

-- ====================================================================
-- VERIFICATION QUERY
-- ====================================================================
-- Run this query to verify the table structure
SELECT 'Updated interviews table structure:' as info;
DESCRIBE interviews;

-- ====================================================================
-- UPDATED INTERVIEWS TABLE STRUCTURE (EXPECTED)
-- ====================================================================
/*
After running this migration, the interviews table should have:

- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- application_id (INT, FOREIGN KEY to applications.id)
- interviewer_id (INT, FOREIGN KEY to users.id)
- interview_type (ENUM: 'Phone', 'Video', 'In-person', 'Panel', default 'Video') -- ADDED
- scheduled_date (DATE, NOT NULL)
- scheduled_time (TIME, NOT NULL)
- duration_minutes (INT, DEFAULT 60) -- ADDED - STORES THE DURATION
- location (VARCHAR 255) -- ADDED
- meeting_link (VARCHAR 500) -- ADDED
- notes (TEXT) -- ADDED
- status (ENUM: 'Pending', 'Scheduled', 'Completed', 'Canceled', 'Rescheduled', default 'Pending') -- UPDATED
- created_at (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- updated_at (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) -- ADDED

Foreign Keys:
- application_id references applications(id)
- interviewer_id references users(id)

Indexes:
- PRIMARY KEY on id
- INDEX on scheduled_date (idx_scheduled_date)
- INDEX on interviewer_id, status (idx_interviewer_status)
- INDEX on status, scheduled_date (idx_status_date)
*/

-- ====================================================================
-- NOTES
-- ====================================================================
/*
1. The duration_minutes column already exists in the table
2. Updated default status to 'Pending' for newly scheduled interviews
3. Added composite index on (status, scheduled_date) for better query performance
4. The table supports the following workflow:
   - New interviews are created with status 'Pending'
   - Status changes to 'Scheduled' when confirmed
   - Status changes to 'Completed' after interview is conducted
   - Status changes to 'Rescheduled' when date/time is modified
   - Status changes to 'Canceled' when interview is canceled
*/
