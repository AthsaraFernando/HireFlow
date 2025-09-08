# Applicant Actor Technical Documentation

## Overview
The Applicant actor represents job seekers who can browse job listings, submit applications, track their application status, and manage their profiles in the HireFlow recruitment system.

## Database Tables & Relations

### Primary Tables Used by Applicant

#### 1. `users` Table (Applicants have role_id = 4)
```sql
- id (Primary Key)
- email (Unique identifier)
- password (Hashed password)
- full_name (Display name)
- role_id (4 for applicants)
- phone (Contact number)
- address (Contact address)
- status (active/inactive/suspended)
- last_login (Timestamp)
- created_at, updated_at (Audit fields)
```

#### 2. `job_posts` Table
```sql
- id (Primary Key)
- hr_id (Foreign Key to users table)
- title (Job title)
- description (Job description)
- requirements (Job requirements)
- department (Department name)
- location (Job location)
- salary_range (Salary information)
- employment_type (Full-time/Part-time/Contract/Internship)
- deadline (Application deadline)
- status (Open/Closed/Draft)
- created_at (Post creation date)
```

#### 3. `applications` Table
```sql
- id (Primary Key)
- applicant_id (Foreign Key to users.id)
- job_id (Foreign Key to job_posts.id)
- resume_path (Path to uploaded resume)
- cover_letter (Application cover letter)
- status (Applied/Under Review/Shortlisted/Interview Scheduled/Rejected/Offered)
- applied_at (Application submission timestamp)
```

#### 4. `interviews` Table
```sql
- id (Primary Key)
- application_id (Foreign Key to applications.id)
- interviewer_id (Foreign Key to users.id)
- scheduled_date (Interview date)
- scheduled_time (Interview time)
- status (Scheduled/Completed/Canceled)
- created_at (Schedule creation timestamp)
```

#### 5. `notifications` Table
```sql
- id (Primary Key)
- user_id (Foreign Key to users.id)
- title (Notification title)
- message (Notification message)
- type (info/success/warning/error)
- is_read (Boolean read status)
- created_at (Notification timestamp)
```

### Relationships
```
users (applicant) 1:N applications
job_posts 1:N applications
applications 1:N interviews
users (applicant) 1:N notifications
```

## File Structure

### Controllers
```
app/controllers/applicant/
└── Applicant.php          # Main applicant controller with all methods
```

### Models
```
app/models/
├── User.php               # User management (shared with other actors)
├── JobPost.php            # Job listings management
├── Application.php        # Application management
├── Notification.php       # Notification system
└── (others as needed)
```

### Views
```
app/views/applicant/
├── dashboard.view.php     # Main dashboard with statistics
├── jobs.view.php          # Job listings page
├── job-details.view.php   # Individual job details
├── applications.view.php  # My applications page
├── interviews.view.php    # Interview schedule page
├── profile.view.php       # Profile management
└── (other views)
```

### Assets
```
public/assets/
├── css/applicant/         # Applicant-specific stylesheets
│   ├── dashboard.style.css
│   ├── jobs.style.css
│   ├── applications.style.css
│   └── (other styles)
└── js/applicant/          # Applicant-specific JavaScript (if any)
```

## Applicant Controller Methods

### Core Methods

#### 1. `index()`
- **Purpose**: Default entry point, redirects to dashboard
- **Authentication**: Requires role_id = 4 (Applicant)
- **Route**: `/applicant`

#### 2. `dashboard()`
- **Purpose**: Main dashboard with statistics and recent activity
- **Data Fetched**:
  - User profile information
  - Application statistics (total, pending, shortlisted, etc.)
  - Recent applications
  - Upcoming interviews
  - Notifications count
- **Route**: `/applicant/dashboard`

#### 3. `jobs($action = null, $id = null)`
- **Purpose**: Job listings and job details
- **Actions**:
  - Default: Show all open jobs with filters
  - `details`: Show specific job details
- **Data Fetched**:
  - Active job posts
  - Job details with requirements and benefits
- **Routes**: 
  - `/applicant/jobs` (listings)
  - `/applicant/jobs/details/{id}` (specific job)

#### 4. `applications($action = null)`
- **Purpose**: Application management
- **Actions**:
  - Default: Show user's applications
  - `apply`: Process job application
- **Data Fetched**:
  - User's applications with job details
  - Application status history
- **Routes**:
  - `/applicant/applications` (list)
  - `/applicant/applications/apply` (apply form)

#### 5. `interviews($action = null)`
- **Purpose**: Interview schedule management
- **Data Fetched**:
  - Scheduled interviews
  - Past interviews
  - Interview feedback (if available)
- **Route**: `/applicant/interviews`

#### 6. `profile($action = null)`
- **Purpose**: Profile management
- **Actions**:
  - Default: View profile
  - `edit`: Edit profile form
  - `update`: Process profile updates
- **Routes**:
  - `/applicant/profile`
  - `/applicant/profile/edit`

## Key Features & Functionality (IMPLEMENTED)

### Dashboard Features ✅
1. **Real-time Statistics Cards**
   - Total applications (from database)
   - Pending applications (status = 'Applied')
   - Under review applications (status = 'Under Review')
   - Shortlisted applications (status = 'Shortlisted')
   - Interview scheduled count
   - Profile completion percentage

2. **Live Recent Activity**
   - Last 5 applications from database
   - Upcoming interviews from schedule
   - Unread notifications count

3. **Functional Quick Actions**
   - Browse jobs with real data
   - View applications with status tracking
   - Update profile with file uploads

### Job Browsing Features ✅
1. **Live Job Listings**
   - Real database job posts (status = 'Open')
   - Search and filter functionality (title, department, location, type)
   - Pagination for large result sets (12 jobs per page)
   - Employment type filters (Full-time, Part-time, Contract, Internship)
   - Location and department filters from database
   - Application status indicators (already applied/not applied)

2. **Complete Job Details**
   - Full job information from database
   - Requirements parsing from database
   - Dynamic responsibilities and benefits
   - Application status checking
   - Functional Apply button with validation

### Application Management ✅
1. **Live My Applications**
   - Real database applications list
   - Live status tracking (Applied, Under Review, Shortlisted, etc.)
   - Complete application details with job information
   - Application statistics dashboard
   - Duplicate application prevention

2. **Functional Application Process**
   - Resume file upload (PDF, DOC, DOCX validation)
   - Cover letter text input
   - File size and type validation (5MB limit)
   - Database storage and tracking
   - Success/error notifications
   - Automatic notification creation

### Interview Management ✅
1. **Live Interview Schedule**
   - Real database interviews (from interviews table)
   - Upcoming vs past interview separation
   - Complete interview details (date, time, interviewer, type)
   - Interview statistics (total, upcoming, completed)
   - Integration with job applications
   - Status tracking (Scheduled, Completed, Canceled)

### Profile Management ✅
1. **Functional Profile Information**
   - Real user data from database
   - Personal details editing (name, phone, address)
   - Contact information management
   - Profile picture upload (JPEG, PNG, GIF - 2MB limit)
   - Profile completion calculation
   - Data validation and error handling

2. **Account Features**
   - Session-based authentication
   - Profile update notifications
   - File upload management
   - Data persistence in database

## Security & Access Control

### Authentication Requirements
- All applicant routes require authentication (`Auth::requireRole(4)`)
- Session-based authentication with CSRF protection
- Role-based access control (RBAC)

### Data Protection
- Users can only access their own data
- File upload validation for resumes
- SQL injection prevention through prepared statements
- XSS protection through input sanitization

## API Endpoints (Internal)

### Data Retrieval Methods
```php
// Dashboard data
getDashboardStats($userId)
getRecentApplications($userId, $limit = 5)
getUpcomingInterviews($userId)

// Job browsing  
getActiveJobs($filters = [], $limit = 20)
getJobDetails($jobId)

// Application management
getUserApplications($userId)
submitApplication($userId, $jobId, $data)

// Profile management
getUserProfile($userId)
updateUserProfile($userId, $data)
```

## Error Handling

### Common Error Scenarios
1. **Database Connection Issues**
   - Fallback to cached data or show appropriate message
   - Log errors for admin review

2. **No Data Available**
   - Display "0" for counts
   - Show empty state messages
   - Provide action buttons to get started

3. **Permission Issues**
   - Redirect to appropriate page
   - Show access denied message

4. **File Upload Errors**
   - Validate file types and sizes
   - Show user-friendly error messages
   - Provide retry options

## Performance Considerations

### Database Optimization
- Proper indexing on frequently queried columns
- Limit result sets with pagination
- Use appropriate JOINs for related data
- Cache frequently accessed data

### Frontend Optimization
- Lazy loading for large datasets
- Progressive enhancement for JavaScript features
- Responsive design for mobile compatibility
- Optimized asset loading

## Future Enhancements

### Potential Features
1. **Advanced Job Matching**
   - AI-powered job recommendations
   - Skills-based matching
   - Salary negotiations

2. **Communication Features**
   - Direct messaging with HR
   - Interview scheduling tools
   - Application status updates

3. **Portfolio Management**
   - Project showcase
   - Skills assessment
   - Certification tracking

4. **Analytics & Insights**
   - Application success rates
   - Interview performance
   - Career progression tracking

## Testing Strategy

### Unit Tests
- Model validation
- Data retrieval methods
- Authentication checks

### Integration Tests
- Complete user workflows
- Database interactions
- File upload processes

### User Acceptance Tests
- Job application process
- Profile management
- Interview scheduling

## Implementation Status

### ✅ Completed Features
1. **Dashboard with Real Data**
   - Live statistics from database
   - Recent applications display
   - Upcoming interviews
   - Profile completion tracking
   - Notification counts

2. **Job Management**
   - Job listings with database integration
   - Search and filter functionality
   - Job details with application status
   - Pagination support

3. **Application System**
   - Complete application workflow
   - File upload (resume) with validation
   - Database storage and tracking
   - Status management
   - Duplicate prevention

4. **Profile Management**
   - Profile viewing and editing
   - File uploads (profile picture)
   - Data validation and updates
   - Session integration

5. **Interview Tracking**
   - Interview schedule display
   - Statistics calculation
   - Status tracking

6. **Notification System**
   - Notification display
   - Unread count tracking
   - Mark as read functionality

### 📊 Database Integration
- All data now fetches from real database tables
- Proper error handling for empty data (displays 0 instead of errors)
- SQL injection prevention through prepared statements
- File upload security with validation

### 🔧 Technical Improvements
- Enhanced models with comprehensive methods
- Controller methods updated for real data
- Proper error handling throughout
- File upload management
- Session data integration

### 🚀 Working Buttons & Features
- ✅ Apply for jobs (with file upload)
- ✅ View job details
- ✅ Filter and search jobs
- ✅ Edit profile (with image upload)
- ✅ View applications with real status
- ✅ Dashboard statistics
- ✅ Pagination in job listings
- ✅ Notification management

---

## Applicant System Architecture

### Controllers Overview

#### Main Controller: `app/controllers/applicant/Applicant.php`
The central controller that handles all applicant functionality through method routing.

**Key Methods:**
- `index()` - Redirects to dashboard (entry point)
- `dashboard()` - Main dashboard with statistics and recent activity
- `jobs($action, $id)` - Job browsing with search/filter capabilities
- `jobDetails($id)` - Individual job post details
- `applications($action)` - Application management and history
- `applyJob()` - Job application form display
- `processJobApplication()` - Handles application submission with file uploads
- `interviews($action)` - Interview scheduling and management
- `interviewFeedback()` - Interview feedback viewing
- `profile($action)` - Profile management
- `updateProfile()` - Profile update processing
- `notifications($action)` - Notification management

**Helper Methods:**
- `getUserData($user_id)` - Retrieves user information for navigation
- `calculateProfileCompletion($user)` - Calculates profile completion percentage

### Models Used by Applicant

#### 1. `app/models/Application.php`
Manages job applications and application statistics.
**Key Methods:**
- `getUserApplications($user_id)` - Gets all applications for a user
- `getApplicationStats($user_id)` - Statistics breakdown by status
- `hasAppliedToJob($user_id, $job_id)` - Checks if user applied to specific job
- `submitApplication($data)` - Creates new application record

#### 2. `app/models/JobPost.php`
Handles job listings, search, and filtering.
**Key Methods:**
- `getActiveJobs($limit, $offset)` - Gets open job posts with pagination
- `searchJobs($filters, $limit, $offset)` - Advanced search with filters
- `getJobCount($filters)` - Total count for pagination
- `getJobById($id)` - Single job post retrieval

#### 3. `app/models/Interview.php`
Manages interview scheduling and tracking.
**Key Methods:**
- `getUserInterviews($user_id)` - Gets all interviews for a user
- `getUpcomingInterviews($user_id)` - Future scheduled interviews
- `getInterviewCount($user_id)` - Interview statistics

#### 4. `app/models/Notification.php`
Handles user notifications and messaging.
**Key Methods:**
- `getUserNotifications($user_id)` - Gets user notifications
- `getUnreadCount($user_id)` - Count of unread notifications
- `markAsRead($notification_id)` - Mark notification as read

#### 5. `app/models/User.php`
User account management and profile data.
**Key Methods:**
- `where(['id' => $user_id])` - Get user by ID
- `updateProfile($user_id, $data)` - Update user profile
- `validateProfileUpdate($data, $user_id)` - Profile validation

### Views Structure

#### Main Layout Views
All applicant views follow consistent structure with sidebar navigation and dynamic content area.

#### 1. Dashboard (`app/views/applicant/dashboard.view.php`)
**Purpose**: Main landing page showing overview of user activity
**Data Dependencies**: `$user`, `$recent_applications`, `$upcoming_interviews`
**Key Sections**:
- Statistics cards (applications, interviews, pending, shortlisted)
- Recent applications list
- Upcoming interviews
- Quick action buttons

#### 2. Job Browsing (`app/views/applicant/jobs.view.php`)
**Purpose**: Browse and search available job positions
**Data Dependencies**: `$jobs`, `$pagination`, `$filters`, `$user`
**Key Features**:
- Search box and filters (location, type, department)
- Job cards with requirements preview
- Pagination controls
- Apply buttons with status checking

#### 3. Job Details (`app/views/applicant/job-details.view.php`)
**Purpose**: Detailed view of individual job posting
**Data Dependencies**: `$job`, `$user`, `$has_applied`
**Key Sections**:
- Job information (title, department, location, salary)
- Full description and requirements
- Application form or status
- Apply button functionality

#### 4. Applications (`app/views/applicant/applications.view.php`)
**Purpose**: View and manage submitted applications
**Data Dependencies**: `$applications`, `$stats`, `$user`
**Key Features**:
- Application status filtering
- Application cards with job details
- Status indicators and dates
- Direct links to job posts

#### 5. Interviews (`app/views/applicant/interviews.view.php`)
**Purpose**: Interview scheduling and management
**Data Dependencies**: `$interviews`, `$stats`, `$user`
**Key Sections**:
- Upcoming interviews list
- Interview history
- Interview statistics
- Calendar integration ready

#### 6. Profile Management (`app/views/applicant/profile.view.php`)
**Purpose**: User profile viewing and editing
**Data Dependencies**: `$user`, `$profile_data`
**Key Features**:
- Personal information display/edit
- Profile picture upload
- Resume upload and management
- Contact information updates

#### 7. Interview Feedback (`app/views/applicant/feedback.view.php`)
**Purpose**: View interview feedback and results
**Data Dependencies**: `$feedbacks`, `$user`
**Status**: Placeholder implementation for future feedback system

### Data Flow Architecture

#### Request Flow:
1. **Route Processing**: `public/index.php` → `App::loadController()` 
2. **Authentication**: `Auth::requireRole(4)` (Applicant role verification)
3. **Controller Method**: Appropriate method in `Applicant.php`
4. **Data Retrieval**: Models fetch data from database
5. **View Rendering**: Controller calls `$this->view()` with data
6. **Response**: HTML rendered with dynamic content

#### File Upload Flow:
1. **Form Submission**: Profile picture or resume upload
2. **Validation**: File type, size, and security checks
3. **Storage**: Files saved to `public/assets/uploads/`
4. **Database**: File paths stored in user/application records
5. **Display**: Dynamic file links in views

#### Search & Filter Flow:
1. **User Input**: Search terms and filter selections
2. **GET Parameters**: Filters passed via URL parameters
3. **Model Query**: `JobPost::searchJobs()` with dynamic WHERE clauses
4. **Result Processing**: Jobs formatted for display
5. **Pagination**: Results split across pages with navigation

### Security Implementation

#### Authentication & Authorization:
- **Session Management**: Secure session handling in `init.php`
- **Role Verification**: `Auth::requireRole(4)` on all methods
- **CSRF Protection**: Ready for token implementation
- **Input Validation**: Data sanitization in models

#### File Upload Security:
- **Type Restrictions**: Only allowed file extensions
- **Size Limits**: 2MB for images, 5MB for documents
- **Path Validation**: Secure file naming and storage
- **Access Control**: Protected upload directories

---

## Recent Bug Fixes (September 8, 2025)

### Dashboard Statistics Issue
- **Problem**: Dashboard showed hardcoded "3 shortlisted applications" instead of real data
- **Solution**: Fixed `dashboard.view.php` to use `<?= $user['shortlisted_count'] ?>` instead of hardcoded value
- **Result**: Dashboard now shows correct count (0 for current test user)

### Job Browsing Issue  
- **Problem**: Browse Jobs page showed only 1 job despite 16 active jobs in database
- **Solution**: Fixed `searchJobs()` method in `JobPost.php` to properly handle pagination with parameters
- **Technical Fix**: Resolved PDO parameter binding conflict with LIMIT/OFFSET clauses
- **Result**: All 16 active jobs now display correctly with proper filtering

### Implementation Details
```php
// Fixed dashboard view
<h3><?= $user['shortlisted_count'] ?></h3>  // Previously: <h3>3</h3>

// Fixed JobPost::searchJobs() method
// Uses manual pagination when filters are applied to avoid PDO binding issues
if (!empty($params)) {
    $baseQuery = "SELECT * FROM job_posts WHERE {$whereClause} ORDER BY created_at DESC";
    $results = $this->query($baseQuery, $params);
    return array_slice($results, $offset, $limit);
}
```

### User Model Fix (September 8, 2025)
- **Problem**: Fatal error `Call to undefined method User::find()`
- **Solution**: Updated `getUserData()` method to use `User::where(['id' => $user_id])` instead of non-existent `find()` method
- **Technical Fix**: 
```php
// Fixed implementation
private function getUserData($user_id)
{
    $userModel = new User();
    $users = $userModel->where(['id' => $user_id]);
    $current_user = $users[0] ?? null;
    
    return [
        'name' => $current_user['full_name'] ?? 'User',
        'email' => $current_user['email'] ?? ''
    ];
}
```

---

**Last Updated**: September 8, 2025
**Version**: 2.2 (Complete System Documentation + Final Fixes)
**Maintainer**: Development Team
