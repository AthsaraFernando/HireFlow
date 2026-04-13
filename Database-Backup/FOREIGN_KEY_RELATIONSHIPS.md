# Foreign Key Relationships - Applications, Users, and Job_Posts Tables

## Date: October 21, 2025

## Summary
✅ **Foreign keys are properly configured** between the three tables.

---

## Current Foreign Key Relationships

### 1. Applications Table Foreign Keys

#### FK 1: `applications.applicant_id` → `users.id`
- **Constraint Name**: `applications_ibfk_1`
- **Column**: `applicant_id` (INT, NOT NULL)
- **References**: `users.id`
- **Update Rule**: `RESTRICT`
- **Delete Rule**: `RESTRICT`
- **Purpose**: Links each application to the user who applied (the applicant)

#### FK 2: `applications.job_id` → `job_posts.id`
- **Constraint Name**: `applications_ibfk_2`
- **Column**: `job_id` (INT, NOT NULL)
- **References**: `job_posts.id`
- **Update Rule**: `RESTRICT`
- **Delete Rule**: `RESTRICT`
- **Purpose**: Links each application to the job posting

### 2. Other Related Foreign Keys

#### Job_Posts Table:
- **`job_posts.hr_id`** → `users.id` (The HR admin who created the job post)

#### Interviews Table:
- **`interviews.application_id`** → `applications.id` (Links interview to application)
- **`interviews.interviewer_id`** → `users.id` (The user conducting the interview)

---

## Complete Relationship Diagram

```
┌─────────────┐
│   USERS     │
│             │
│ id (PK)     │◄──────────┐
│ full_name   │           │
│ email       │           │
│ role_id     │           │
└─────────────┘           │
      ▲                   │
      │                   │
      │ hr_id             │ applicant_id
      │ (job creator)     │ (applicant)
      │                   │
┌─────────────┐     ┌─────────────────┐
│  JOB_POSTS  │     │  APPLICATIONS   │
│             │     │                 │
│ id (PK)     │◄────┤ id (PK)         │
│ hr_id (FK)  │     │ applicant_id FK │
│ title       │     │ job_id (FK)     │
│ department  │     │ applicant_name  │
└─────────────┘     │ job_title       │
      │             │ resume_path     │
      │ job_id      │ status          │
      │             └─────────────────┘
      │                     │
      └─────────────────────┘
                            │ application_id
                            │
                            ▼
                    ┌─────────────┐
                    │ INTERVIEWS  │
                    │             │
                    │ id (PK)     │
                    │ app_id (FK) │
                    │ interv_id FK│
                    └─────────────┘
```

---

## Relationship Details

### Applications ↔ Users (Applicant Relationship)

**Type**: Many-to-One
- **Direction**: `applications.applicant_id` → `users.id`
- **Cardinality**: Many applications can belong to one user (applicant)
- **Constraint**: RESTRICT (Cannot delete user if they have applications)

**Business Logic**:
- One user (applicant) can submit multiple applications
- Each application must belong to exactly one user
- Cannot delete a user who has submitted applications

**Example**:
```
User ID 4 (Athsara Manitha) has submitted:
  - Application #1 for Job #1 (Software Engineer)
  - Application #6 for Job #3 (Data Analyst)
```

### Applications ↔ Job_Posts Relationship

**Type**: Many-to-One
- **Direction**: `applications.job_id` → `job_posts.id`
- **Cardinality**: Many applications can be for one job post
- **Constraint**: RESTRICT (Cannot delete job post if it has applications)

**Business Logic**:
- One job post can receive multiple applications
- Each application is for exactly one job post
- Cannot delete a job post that has received applications

**Example**:
```
Job Post #1 (Software Engineer) has received:
  - Application from User #4 (Athsara)
  - Application from User #5 (Chamali)
```

### Job_Posts ↔ Users (Creator Relationship)

**Type**: Many-to-One
- **Direction**: `job_posts.hr_id` → `users.id`
- **Cardinality**: Many job posts can be created by one HR admin
- **Constraint**: RESTRICT

**Business Logic**:
- One HR admin user can create multiple job posts
- Each job post must be created by exactly one HR admin
- Cannot delete HR admin who has created job posts

---

## Referential Integrity Rules

### RESTRICT Policy
All foreign keys use **RESTRICT** for both UPDATE and DELETE operations.

#### What RESTRICT Means:

**ON DELETE RESTRICT**:
- ❌ Cannot delete a user if they have applications
- ❌ Cannot delete a job post if it has applications
- ✅ Must delete/update applications first before deleting parent records

**ON UPDATE RESTRICT**:
- ❌ Cannot update the ID of a user if referenced by applications
- ❌ Cannot update the ID of a job post if referenced by applications
- ✅ Ensures data consistency and prevents orphaned records

#### Example Scenarios:

**Scenario 1: Try to delete a user with applications**
```sql
DELETE FROM users WHERE id = 4;
-- ERROR: Cannot delete or update a parent row: 
-- a foreign key constraint fails (applications references user id = 4)
```

**Scenario 2: Try to delete a job post with applications**
```sql
DELETE FROM job_posts WHERE id = 1;
-- ERROR: Cannot delete or update a parent row: 
-- a foreign key constraint fails (applications references job_post id = 1)
```

**Scenario 3: Correct way to delete**
```sql
-- First delete dependent applications
DELETE FROM applications WHERE job_id = 1;
-- Then delete the job post
DELETE FROM job_posts WHERE id = 1;
-- SUCCESS
```

---

## Additional Constraints

### Unique Constraint on Applications
```sql
UNIQUE KEY unique_application (applicant_id, job_id)
```

**Purpose**: Prevents duplicate applications
- ✅ One user can only apply once to the same job
- ❌ Cannot have multiple applications from same user for same job

**Example**:
```sql
-- First application - SUCCESS
INSERT INTO applications (applicant_id, job_id, ...) VALUES (4, 1, ...);

-- Try to apply again to same job - FAIL
INSERT INTO applications (applicant_id, job_id, ...) VALUES (4, 1, ...);
-- ERROR: Duplicate entry '4-1' for key 'unique_application'
```

### Indexes for Performance

**Applications table has indexes on**:
1. `idx_status` - For filtering by application status
2. `idx_job_id` - For looking up applications by job
3. `idx_applicant_id` - For looking up applications by applicant

These indexes speed up common queries like:
- "Show me all shortlisted applications"
- "Show me all applications for this job"
- "Show me all applications from this user"

---

## Data Flow Example

### When a User Applies for a Job:

```
1. User (id=4) views Job Post (id=1)
   └─ Users table: id=4, full_name="Athsara Manitha"
   └─ Job_Posts table: id=1, title="Software Engineer"

2. User submits application
   └─ New record in Applications table:
      ├─ applicant_id = 4 (FK → users.id)
      ├─ job_id = 1 (FK → job_posts.id)
      ├─ applicant_name = "Athsara Manitha" (stored directly)
      ├─ job_title = "Software Engineer" (stored directly)
      └─ status = "Applied"

3. FK Validation happens automatically:
   ✅ Check: Does user id=4 exist? YES
   ✅ Check: Does job_post id=1 exist? YES
   ✅ Check: Is (4,1) combination unique? YES
   ✅ INSERT succeeds

4. Application data is now linked:
   applications.applicant_id (4) → users.id (4)
   applications.job_id (1) → job_posts.id (1)
```

---

## Current Database State

### Query to Verify Relationships:
```sql
SELECT 
    a.id as application_id,
    a.applicant_id,
    u.full_name as applicant_from_users,
    a.applicant_name as applicant_from_applications,
    a.job_id,
    jp.title as job_from_job_posts,
    a.job_title as job_from_applications,
    a.status
FROM applications a
JOIN users u ON a.applicant_id = u.id
JOIN job_posts jp ON a.job_id = jp.id
LIMIT 5;
```

**Note**: This query works because the foreign keys are properly set up!

---

## Foreign Key Status

### ✅ All Foreign Keys Working Correctly

1. **applications.applicant_id → users.id** ✅
   - Constraint exists: `applications_ibfk_1`
   - Properly enforced: RESTRICT
   - Index exists: `idx_applicant_id`

2. **applications.job_id → job_posts.id** ✅
   - Constraint exists: `applications_ibfk_2`
   - Properly enforced: RESTRICT
   - Index exists: `idx_job_id`

3. **Additional Related FKs** ✅
   - job_posts.hr_id → users.id
   - interviews.application_id → applications.id
   - interviews.interviewer_id → users.id

### Why Data Denormalization?

You might notice that `applications` table has both:
- `applicant_id` (FK to users) **AND** `applicant_name` (stored directly)
- `job_id` (FK to job_posts) **AND** `job_title` (stored directly)

**Reasons**:
1. **Performance**: Avoid JOINs for displaying application lists
2. **Historical Data**: Keep snapshot of applicant name and job title at time of application
3. **Flexibility**: Names/titles can change in users/job_posts tables without affecting application records

**Trade-off**: Slightly more storage space vs significantly faster queries

---

## Recommendations

### ✅ Current Setup is Good

The foreign keys are properly configured with appropriate constraints.

### 💡 Potential Improvements (Optional)

#### 1. Consider CASCADE for Better UX
```sql
-- Current: RESTRICT (must delete applications manually first)
-- Option: CASCADE (auto-delete applications when user/job is deleted)

ALTER TABLE applications 
DROP FOREIGN KEY applications_ibfk_1;

ALTER TABLE applications
ADD CONSTRAINT applications_ibfk_1 
FOREIGN KEY (applicant_id) REFERENCES users(id)
ON DELETE CASCADE;
```

**Pros**: Easier cleanup, automatic orphan prevention
**Cons**: Could accidentally delete many applications

#### 2. Consider SET NULL for Soft Deletes
```sql
-- Allow applicant_id to be NULL when user is deleted
-- Keep application record but mark user as deleted

ALTER TABLE applications 
MODIFY applicant_id INT NULL;

ALTER TABLE applications
DROP FOREIGN KEY applications_ibfk_1;

ALTER TABLE applications
ADD CONSTRAINT applications_ibfk_1 
FOREIGN KEY (applicant_id) REFERENCES users(id)
ON DELETE SET NULL;
```

**Pros**: Preserves application history even if user deleted
**Cons**: Requires NULL handling in queries

---

## Testing Foreign Keys

### Test 1: Verify FK Exists
```sql
-- Check foreign key constraints
SELECT * FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_SCHEMA = 'hireflow_db' 
AND TABLE_NAME = 'applications' 
AND REFERENCED_TABLE_NAME IS NOT NULL;
```
**Result**: ✅ Shows both foreign keys

### Test 2: Try Invalid Insert
```sql
-- Try to insert application with non-existent user
INSERT INTO applications (applicant_id, job_id, resume_path) 
VALUES (99999, 1, 'test.pdf');
```
**Expected**: ❌ FK violation error
**Result**: ✅ Error thrown (FK working)

### Test 3: Try Invalid Delete
```sql
-- Try to delete user with applications
DELETE FROM users WHERE id = 4;
```
**Expected**: ❌ FK violation error (RESTRICT)
**Result**: ✅ Error thrown (FK working)

---

## Summary

### Foreign Key Configuration: ✅ PROPERLY SET UP

| From Table   | From Column  | To Table  | To Column | Constraint          | Rules           |
|--------------|--------------|-----------|-----------|---------------------|-----------------|
| applications | applicant_id | users     | id        | applications_ibfk_1 | RESTRICT/RESTRICT|
| applications | job_id       | job_posts | id        | applications_ibfk_2 | RESTRICT/RESTRICT|

### Additional Context:
- Unique constraint prevents duplicate applications ✅
- Indexes optimize query performance ✅
- Denormalized fields (applicant_name, job_title) improve query speed ✅
- RESTRICT policy ensures data integrity ✅

**Conclusion**: The foreign key relationships are correctly implemented and working as intended! 🎉
