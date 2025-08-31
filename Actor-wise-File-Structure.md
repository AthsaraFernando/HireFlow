# Actor-wise File Structure & URL Mapping

## Overview
This document outlines the complete file structure and URL mapping for all actors in the HireFlow system.

## URL Structure Convention
```
/HireFlow/public/[actor]/[action]/[parameters]
```

## Common Views & URLs

### Authentication & General
| View File | URL | Status | Description |
|-----------|-----|--------|-------------|
| `home.view.php` | `/HireFlow/public` | ✅ | Main landing page |
| `signin.view.php` | `/HireFlow/public/signin` | ✅ | User authentication |
| `signup.view.php` | `/HireFlow/public/signup` | ✅ | User registration |
| `forgot-password.view.php` | `/HireFlow/public/forgot-password` | ✅ | Password reset request |
| `reset-password.view.php` | `/HireFlow/public/reset-password` | ✅ | Password reset form |
| `profile.view.php` | `/HireFlow/public/profile` | ✅ | User profile management |
| `change-password.view.php` | `/HireFlow/public/change-password` | ✅ | Password change form |
| `404.view.php` | `/HireFlow/public/404` | ✅ | Error page |

### Testing & Navigation
| View File | URL | Status | Description |
|-----------|-----|--------|-------------|
| `url-test.php` | `/HireFlow/public/url-test.php` | ✅ | URL testing dashboard |

## System Admin Actor

### File Structure
```
app/
├── controllers/
│   └── systemadmin/
│       ├── Systemadmin.php
│       ├── Dashboard.php ✅
│       ├── Usermanage.php ✅
│       ├── Accesslogs.php ✅
│       ├── Viewdata.php ✅
│       ├── SystemSettings.php ✅
│       ├── BackupRestore.php ✅
│       ├── SecuritySettings.php ✅
│       └── Reports.php ✅
└── views/
    └── systemadmin/
        ├── dashboard.view.php ✅
        ├── usermanage.view.php ✅
        ├── accesslogs.view.php ✅
        ├── viewdata.view.php ✅
        ├── system-settings.view.php ✅
        ├── backup-restore.view.php ✅
        ├── security-settings.view.php ✅
        └── reports.view.php ✅
```

### URL Mapping
| View | URL | Status | Description |
|------|-----|--------|-------------|
| Dashboard | `/HireFlow/public/systemadmin/dashboard` | ✅ | Admin overview dashboard |
| User Management | `/HireFlow/public/systemadmin/usermanage` | ✅ | Manage all users and roles |
| Access Logs | `/HireFlow/public/systemadmin/accesslogs` | ✅ | System access and activity logs |
| View Data | `/HireFlow/public/systemadmin/viewdata` | ✅ | Database data viewer |
| System Settings | `/HireFlow/public/systemadmin/system-settings` | ✅ | System configuration |
| Backup & Restore | `/HireFlow/public/systemadmin/backup-restore` | ✅ | Database backup/restore |
| Security Settings | `/HireFlow/public/systemadmin/security-settings` | ✅ | Security configuration |
| Reports | `/HireFlow/public/systemadmin/reports` | ✅ | System reports and analytics |

## HR Admin Actor

### File Structure
```
app/
├── controllers/
│   └── hradmin/
│       ├── Dashboard.php
│       ├── JobPosts.php
│       ├── CreateJob.php
│       ├── EditJob.php
│       ├── ViewJob.php
│       ├── Applications.php
│       ├── ViewApplication.php
│       ├── ApplicantDatabase.php
│       ├── InterviewSchedule.php
│       ├── Reports.php
│       └── Notifications.php
└── views/
    └── hradmin/
        ├── dashboard.view.php
        ├── job-posts.view.php
        ├── create-job.view.php
        ├── edit-job.view.php
        ├── view-job.view.php
        ├── applications.view.php
        ├── view-application.view.php
        ├── applicant-database.view.php
        ├── interview-schedule.view.php
        ├── reports.view.php
        └── notifications.view.php
```

### URL Mapping
| View | URL | Status | Description |
|------|-----|--------|-------------|
| Dashboard | `/HireFlow/public/hradmin/dashboard` | ⏳ | HR overview dashboard |
| Job Posts | `/HireFlow/public/hradmin/job-posts` | ⏳ | Manage job postings |
| Create Job | `/HireFlow/public/hradmin/create-job` | ⏳ | Create new job posting |
| Edit Job | `/HireFlow/public/hradmin/edit-job/[id]` | ⏳ | Edit existing job posting |
| View Job | `/HireFlow/public/hradmin/view-job/[id]` | ⏳ | View job details |
| Applications | `/HireFlow/public/hradmin/applications` | ⏳ | View all applications |
| View Application | `/HireFlow/public/hradmin/view-application/[id]` | ⏳ | View application details |
| Applicant Database | `/HireFlow/public/hradmin/applicant-database` | ⏳ | Manage applicant profiles |
| Interview Schedule | `/HireFlow/public/hradmin/interview-schedule` | ⏳ | Schedule interviews |
| Reports | `/HireFlow/public/hradmin/reports` | ⏳ | HR reports and analytics |
| Notifications | `/HireFlow/public/hradmin/notifications` | ⏳ | System notifications |

## Recruitment Manager Actor

### File Structure
```
app/
├── controllers/
│   └── recruitment/
│       ├── Dashboard.php ✅
│       ├── AssignedJobs.php ✅
│       ├── Applications.php ✅
│       ├── ShortlistCandidates.php ✅
│       ├── InterviewSchedule.php ✅
│       ├── ConductInterview.php ✅
│       ├── InterviewFeedback.php ✅
│       ├── CandidateEvaluation.php ✅
│       ├── Reports.php ✅
│       └── Notifications.php ✅
└── views/
    └── recruitment/
        ├── dashboard.view.php ✅
        ├── assigned-jobs.view.php ✅
        ├── applications.view.php ✅
        ├── shortlist-candidates.view.php ✅
        ├── interview-schedule.view.php ✅
        ├── conduct-interview.view.php ✅
        ├── interview-feedback.view.php ✅
        ├── candidate-evaluation.view.php ✅
        ├── reports.view.php ✅
        └── notifications.view.php ✅
```

### URL Mapping
| View | URL | Status | Description |
|------|-----|--------|-------------|
| Dashboard | `/HireFlow/public/recruitment/dashboard` | ✅ | Recruitment overview |
| Assigned Jobs | `/HireFlow/public/recruitment/assigned-jobs` | ✅ | Jobs assigned for evaluation |
| Applications | `/HireFlow/public/recruitment/applications` | ✅ | Applications to review |
| Shortlist Candidates | `/HireFlow/public/recruitment/shortlist-candidates` | ✅ | Candidate shortlisting |
| Interview Schedule | `/HireFlow/public/recruitment/interview-schedule` | ✅ | Interview management |
| Conduct Interview | `/HireFlow/public/recruitment/conduct-interview/[id]` | ✅ | Interview interface |
| Interview Feedback | `/HireFlow/public/recruitment/interview-feedback` | ✅ | Submit interview feedback |
| Candidate Evaluation | `/HireFlow/public/recruitment/candidate-evaluation` | ✅ | Evaluate candidates |
| Reports | `/HireFlow/public/recruitment/reports` | ✅ | Recruitment reports |
| Notifications | `/HireFlow/public/recruitment/notifications` | ✅ | System notifications |

## Applicant Actor

### File Structure
```
app/
├── controllers/
│   └── applicant/
│       ├── Dashboard.php
│       ├── BrowseJobs.php
│       ├── JobDetails.php
│       ├── ApplyJob.php
│       ├── MyApplications.php
│       ├── ApplicationStatus.php
│       ├── ProfileEdit.php
│       ├── UploadDocuments.php
│       └── Notifications.php
└── views/
    └── applicant/
        ├── dashboard.view.php
        ├── browse-jobs.view.php
        ├── job-details.view.php
        ├── apply-job.view.php
        ├── my-applications.view.php
        ├── application-status.view.php
        ├── profile-edit.view.php
        ├── upload-documents.view.php
        └── notifications.view.php
```

### URL Mapping
| View | URL | Status | Description |
|------|-----|--------|-------------|
| Dashboard | `/HireFlow/public/applicant/dashboard` | ⏳ | Applicant overview |
| Browse Jobs | `/HireFlow/public/applicant/browse-jobs` | ⏳ | Job listings and search |
| Job Details | `/HireFlow/public/applicant/job-details/[id]` | ⏳ | Detailed job information |
| Apply for Job | `/HireFlow/public/applicant/apply-job/[id]` | ⏳ | Job application form |
| My Applications | `/HireFlow/public/applicant/my-applications` | ⏳ | Track applications |
| Application Status | `/HireFlow/public/applicant/application-status/[id]` | ⏳ | Application progress |
| Edit Profile | `/HireFlow/public/applicant/profile-edit` | ⏳ | Profile management |
| Upload Documents | `/HireFlow/public/applicant/upload-documents` | ⏳ | Document management |
| Notifications | `/HireFlow/public/applicant/notifications` | ⏳ | System notifications |

## Shared Components

### File Structure
```
app/views/components/
├── header.view.php ✅
├── footer.view.php ✅
├── sidebar.view.php
└── navigation.view.php
```

## CSS Structure
```
public/assets/css/
├── main.css ✅
├── components/
│   ├── alert.css ✅
│   ├── button.css ✅
│   ├── card.css ✅
│   ├── input.css ✅
│   ├── modal.css ✅
│   ├── table.css ✅
│   └── toast.css ✅
├── systemadmin/
│   └── dashboard.style.css ✅
├── hradmin/
│   └── [to be created]
├── recruitment/
│   └── [to be created]
└── applicant/
    └── [to be created]
```

## Development Status Legend
- ✅ **Implemented** - File exists and functional
- ⏳ **Pending** - Planned for development
- ❌ **Error** - Implementation issue

## Next Development Steps

### ✅ Phase 2: System Admin Views - **COMPLETED!**
~~1. `system-settings.view.php`~~ ✅ **COMPLETED**
~~2. `backup-restore.view.php`~~ ✅ **COMPLETED**
~~3. `security-settings.view.php`~~ ✅ **COMPLETED**
~~4. `reports.view.php`~~ ✅ **COMPLETED**

**🎉 System Admin actor is now 100% complete with all 8 views functional!**

### Phase 3: HR Admin Views (Complete)
1. All 11 HR Admin views
2. CSS styling for HR Admin section
3. Controllers for HR Admin functionality

### Phase 4: Recruitment Manager Views (Complete)
1. All 10 Recruitment Manager views
2. CSS styling for Recruitment section
3. Controllers for Recruitment functionality

### Phase 5: Applicant Views (Complete)
1. All 9 Applicant views
2. CSS styling for Applicant section
3. Controllers for Applicant functionality

## File Naming Conventions

### Controllers
- PascalCase: `Dashboard.php`, `UserManage.php`
- Grouped in actor folders: `systemadmin/`, `hradmin/`, etc.

### Views
- kebab-case: `dashboard.view.php`, `user-manage.view.php`
- Actor-specific folders in views directory

### CSS
- kebab-case: `dashboard.style.css`
- Component-based organization

### URLs
- kebab-case: `/system-admin/user-manage`
- RESTful patterns where applicable

## Testing Access
All views are accessible directly via URL for testing purposes without authentication. Use the [URL Test Page](http://localhost/HireFlow/public/url-test.php) for easy navigation and testing.
