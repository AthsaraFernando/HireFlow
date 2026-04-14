# Interview Issue Fix

## Summary
This document records:
- The SQL queries that were run.
- Why those SQL changes were needed.
- The code changes made after the SQL updates.
- Why the code changes were required.

## SQL Queries Run

```sql
ALTER TABLE interviews
MODIFY COLUMN status ENUM('Pending','Scheduled','Completed','Canceled','Rescheduled')
NOT NULL DEFAULT 'Scheduled';
```

```sql
UPDATE interviews
SET status = 'Scheduled'
WHERE status IS NULL OR status = '';
```

```sql
UPDATE applications a
LEFT JOIN interviews i ON i.application_id = a.id
SET a.status = CASE
    WHEN i.id IS NOT NULL THEN 'Interview Scheduled'
    ELSE 'Applied'
END
WHERE a.status IS NULL OR a.status = '';
```

```sql
SHOW COLUMNS FROM interviews LIKE 'status';

SELECT status, COUNT(*) AS count
FROM interviews
GROUP BY status
ORDER BY status;

SELECT status, COUNT(*) AS count
FROM applications
GROUP BY status
ORDER BY status;
```

## Why These SQL Queries Were Needed

1. The application code was creating interviews with `status = 'Pending'`, but the live `interviews.status` enum did not include `Pending` on some environments.
2. That mismatch caused database writes to fail on stricter SQL configurations.
3. Existing bad data (blank statuses) was present in `applications`, which can break workflow filtering and reporting.
4. Verification queries confirm the enum and status data are now consistent.

## Code Changes Made

### 1) Interview model: return real DB outcome instead of forced success

File changed:
- `app/models/Interview.php`

Changes:
- `createInterview($data)` now returns real insert success:
  - before: always returned `true`.
  - after: returns `($insertId !== false)`.
- `updateInterview($id, $data)` now returns the real result of `$this->update(...)`.
- `deleteInterview($id)` now returns the real result of `$this->query(...)`.

Why:
- The previous implementation could report success even when the database operation failed.
- This caused the UI to show "Interview scheduled successfully" even when no row was inserted.

### 2) Interview scheduling controller: only send success when both operations succeed

File changed:
- `app/controllers/recruitment/InterviewSchedule.php`

Changes:
- In `create()`:
  - after `createInterview(...)`, the code now checks application status update result too.
  - only returns success JSON if:
    - interview insert succeeded, and
    - application status update to `Interview Scheduled` succeeded.
  - if any step fails, returns failure JSON with model error details when available.
- In `update()`:
  - failure response now includes model errors when available.

Why:
- Prevents false-success responses.
- Makes failures visible so issues can be diagnosed quickly on any environment.

## Root Cause Addressed

The issue was a combination of:
1. Database enum mismatch (`Pending` missing in some DBs), and
2. Code paths that returned success unconditionally.

After SQL alignment plus code changes, interview scheduling behavior is now tied to actual database success/failure instead of assumed success.
