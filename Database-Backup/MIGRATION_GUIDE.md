# Database Migration - Add Application Columns and Data

## Overview
This migration adds two new columns to the `applications` table, inserts 5 new dummy applications, and updates 3 applications to 'Shortlisted' status.

## Changes Made

### 1. New Columns Added
- `applicant_name` (VARCHAR 255) - Stores the applicant's full name
- `job_title` (VARCHAR 255) - Stores the job position title

### 2. New Dummy Applications (5 records)
| ID | Applicant Name | Job Title | Status |
|----|----------------|-----------|---------|
| 7 | Hansini Perera | Junior Data Analyst | Applied |
| 8 | Nuwan Silva | Project Manager | Under Review |
| 9 | Priya Jayasinghe | Senior Software Engineer | Applied |
| 10 | Kamal Fernando | Marketing Specialist | Applied |
| 11 | Kelum Disanayake | HR Assistant | Applied |

### 3. Updated to 'Shortlisted' Status
Three applications will be updated to 'Shortlisted' status (IDs: 8, 9)

## How to Run This Migration

### Option 1: Using phpMyAdmin (Recommended)
1. Open phpMyAdmin in your browser: `http://localhost/phpmyadmin`
2. Select the `hireflow_db` database from the left sidebar
3. Click on the **SQL** tab at the top
4. Open the file: `QUICK_RUN_MIGRATION.sql`
5. Copy all the SQL code
6. Paste it into the SQL query box
7. Click **Go** to execute

### Option 2: Using MySQL Command Line
```bash
mysql -u root -p hireflow_db < Database-Backup/QUICK_RUN_MIGRATION.sql
```

### Option 3: Using Terminal/Command Prompt
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/HireFlow
mysql -u root -p
```
Then in MySQL:
```sql
USE hireflow_db;
SOURCE Database-Backup/QUICK_RUN_MIGRATION.sql;
```

## Verification

After running the migration, verify the changes:

```sql
-- Check total applications
SELECT COUNT(*) as total FROM applications;

-- Check shortlisted applications
SELECT id, applicant_name, job_title, status 
FROM applications 
WHERE status = 'Shortlisted';

-- View all applications
SELECT id, applicant_name, job_title, status, applied_at 
FROM applications 
ORDER BY applied_at DESC;
```

Expected Results:
- Total Applications: **11** (6 original + 5 new)
- Shortlisted Applications: **At least 3**

## Rollback (If Needed)

If you need to undo these changes:

```sql
-- Remove the added columns
ALTER TABLE applications 
DROP COLUMN applicant_name,
DROP COLUMN job_title;

-- Delete the 5 new applications (IDs 7-11)
DELETE FROM applications WHERE id IN (7, 8, 9, 10, 11);

-- Reset status back (if you tracked original statuses)
-- You'll need to do this manually based on your needs
```

## Impact on Team Members

### How Others Get These Changes:

1. **Commit the migration file to Git:**
   ```bash
   git add Database-Backup/migration_add_application_columns_and_data.sql
   git add Database-Backup/QUICK_RUN_MIGRATION.sql
   git add Database-Backup/MIGRATION_GUIDE.md
   git commit -m "Add applicant_name and job_title columns to applications table with dummy data"
   git push origin RecruitManager_New_Temp
   ```

2. **Notify team members** via Slack/Teams:
   ```
   📢 Database Update Required!
   
   I've added new columns to the applications table and some test data.
   
   To update your local database:
   1. Pull latest code: git pull
   2. Run: Database-Backup/QUICK_RUN_MIGRATION.sql in phpMyAdmin
   
   See Database-Backup/MIGRATION_GUIDE.md for details.
   ```

3. **Team members run the migration:**
   - Pull your latest code
   - Execute `QUICK_RUN_MIGRATION.sql` in their phpMyAdmin
   - Their database will now match yours

## Notes

- ⚠️ **Backup first**: Always backup your database before running migrations
- 🔄 **Idempotent**: The migration checks for existing columns before adding
- 📊 **Data Integrity**: Uses existing user and job data (IDs 4-8 for users, 1-5 for jobs)
- ✅ **Safe**: Won't break existing functionality

## Testing the Interview Schedule Feature

After running this migration, test the interview schedule feature:

1. Login as Recruitment Manager: `recruiter@hireflow.com` / `Password@1`
2. Go to **Interview Schedule** page
3. Click **Schedule New Interview**
4. The dropdown should now show at least 3 shortlisted candidates
5. Test scheduling an interview

## Troubleshooting

**Error: Column already exists**
- The migration is safe to re-run. It will skip existing columns.

**Error: Duplicate entry**
- Check if applications already exist with the same applicant_id and job_id
- The UNIQUE constraint prevents duplicate applications

**No candidates showing in dropdown**
- Verify shortlisted status: `SELECT * FROM applications WHERE status = 'Shortlisted'`
- Check the InterviewSchedule controller is loading correctly

---

**Migration Created:** October 20, 2025  
**Branch:** RecruitManager_New_Temp  
**Status:** Ready to Execute ✅
