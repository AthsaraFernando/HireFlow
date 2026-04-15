# Applicant Notifications (CRUD, Table-Backed)

## Overview

Applicant notifications are now persisted in the `notifications` table and exposed as full CRUD operations.

## Required Migration

`is_deleted` is required for soft deletion.

```sql
ALTER TABLE notifications
ADD COLUMN is_deleted TINYINT(1) NOT NULL DEFAULT 0 AFTER is_read;

UPDATE notifications
SET is_deleted = 0
WHERE is_deleted IS NULL;

CREATE INDEX idx_notifications_user_read_deleted
ON notifications (user_id, is_read, is_deleted);
```

## 1) Create Notifications

Notifications are generated from relevant source records in:

- `interviews` (statuses: `Scheduled`, `Rescheduled`, `Canceled`)
- `interview_evaluations` (recommendations: `Hire`, `Reject`)

On applicant notification access, the system syncs source events into `notifications` and inserts missing records.

## 2) View Notifications

The bell dropdown and the applicant notifications page now read from `notifications` table records for that applicant.

- Clicking the bell opens a popup list.
- Clicking any popup notification marks it as read immediately and then navigates.
- A small delete (`x`) button is available directly in the popup list.

## 3) Mark as Read

When an applicant clicks a notification (or uses mark-read), the notification record is updated:

- `is_read = 1`

`read_at` is not required in the current implementation.
If you later add a `read_at` column, the mark-read query can be extended to store timestamps.

Read records are shown in grey.

## 4) Delete Notifications

Applicants can delete their own notifications using soft delete.

- Delete operation sets `is_deleted = 1` in `notifications`.
- Soft-deleted notifications are excluded from all applicant notification UIs.
- The UI updates immediately after successful deletion.

## Non-Trigger Events

These do not create applicant notifications in this flow:

- Application submitted events
- Profile edits
- Saved jobs actions
- Dashboard visits