
START TRANSACTION;

ALTER TABLE application_forms
DROP COLUMN IF EXISTS job_title,
DROP COLUMN IF EXISTS department,
DROP COLUMN IF EXISTS location,
DROP COLUMN IF EXISTS employment_type;

ALTER TABLE application_forms
ADD COLUMN IF NOT EXISTS is_deleted TINYINT(1) DEFAULT 0 AFTER status;

-- Add index for better query performance
ALTER TABLE application_forms
ADD INDEX idx_is_deleted (is_deleted);

ALTER TABLE application_form_fields
ADD COLUMN IF NOT EXISTS is_deleted TINYINT(1) DEFAULT 0 AFTER is_enabled;

-- Add index for better query performance
ALTER TABLE application_form_fields
ADD INDEX idx_is_deleted (is_deleted);

ALTER TABLE job_posts
ADD COLUMN IF NOT EXISTS is_deleted TINYINT(1) DEFAULT 0 AFTER status;

-- Add index for better query performance
ALTER TABLE job_posts
ADD INDEX idx_is_deleted (is_deleted);

-- Add index for combined status and is_deleted queries
ALTER TABLE job_posts
ADD INDEX idx_status_deleted (status, is_deleted);

UPDATE application_forms SET is_deleted = 0 WHERE is_deleted IS NULL;
UPDATE application_form_fields SET is_deleted = 0 WHERE is_deleted IS NULL;
UPDATE job_posts SET is_deleted = 0 WHERE is_deleted IS NULL;

UPDATE application_forms SET is_deleted = 1 WHERE status = 'inactive';


COMMIT;

