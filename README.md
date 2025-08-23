# HireFlow - Recruitment Management System

## Project Overview

HireFlow is a comprehensive web-based recruitment management system built with PHP and MySQL. The system supports multiple user roles including System Administrators, Applicants, Recruiters, HR Personnel, and Department Heads to streamline the entire hiring process.

## Quick Setup

- Clone the project into the htdocs folder inside the xampp folder
- Run the my_db.session.sql file to set up the sample database table
- Open the public folder using localhost (Make sure to start Apache, MySQL in the XAMPP dashboard)
- Base URL: `http://localhost/HireFlow/public`

## Project Structure

```
HireFlow/
├── README.md                           # This file
├── developer-sectionsmd.md            # Development guidelines
├── HireFlow_Proposal.docx.md          # Project proposal
├── my_db.session.sql                  # Database session file
├── app/                               # Application logic
│   ├── controllers/                   # MVC Controllers
│   │   ├── _404.php                  # 404 error controller
│   │   ├── Home.php                  # Homepage controller
│   │   ├── Signin.php                # Login controller
│   │   ├── Signout.php               # Logout controller
│   │   ├── Signup.php                # Registration controller
│   │   ├── applicant/                # Applicant module controllers
│   │   │   ├── Applications.php      # Application management
│   │   │   ├── Dashboard.php         # Applicant dashboard
│   │   │   ├── Interviews.php        # Interview management
│   │   │   ├── Jobs.php              # Job browsing
│   │   │   └── Profile.php           # Profile management
│   │   └── systemadmin/              # System admin controllers
│   │       ├── Accesslogs.php        # Access logs management
│   │       ├── Dashboard.php         # Admin dashboard
│   │       ├── Systemadmin.php       # Admin main controller
│   │       ├── Usermanage.php        # User management
│   │       └── Viewdata.php          # Data viewing
│   ├── core/                         # Core system files
│   │   ├── App.php                   # Main application router
│   │   ├── config.php                # Configuration settings
│   │   ├── Controller.php            # Base controller class
│   │   ├── Database.php              # Database connection
│   │   ├── functions.php             # Utility functions
│   │   ├── init.php                  # System initialization
│   │   └── Model.php                 # Base model class
│   ├── models/                       # Data models
│   │   ├── Role.php                  # Role model
│   │   └── User.php                  # User model
│   └── views/                        # View templates
│       ├── 404.view.php              # 404 error page
│       ├── home.view.php             # Homepage
│       ├── signup.view.php           # Registration form
│       ├── applicant/                # Applicant views
│       │   ├── applications.view.php # Application management
│       │   ├── apply.view.php        # Job application form
│       │   ├── dashboard.view.php    # Applicant dashboard
│       │   ├── feedback.view.php     # Interview feedback
│       │   ├── interviews.view.php   # Interview schedules
│       │   ├── job-details.view.php  # Job details page
│       │   ├── jobs.view.php         # Job listings
│       │   └── profile.view.php      # Profile management
│       └── systemadmin/              # Admin views
│           ├── accesslogs.view.php   # Access logs
│           ├── dashboard.view.php    # Admin dashboard
│           ├── usermanage.view.php   # User management
│           └── viewdata.view.php     # Data viewing
└── public/                           # Public web files
    ├── index.php                     # Application entry point
    ├── robots.txt                    # Search engine instructions
    └── assets/                       # Static assets
        ├── css/                      # Stylesheets
        │   ├── home.style.css        # Homepage styles
        │   ├── main.css              # Global styles
        │   ├── signup.style.css      # Registration styles
        │   ├── utils.css             # Utility classes
        │   ├── components/           # Component styles
        │   │   ├── alert.css         # Alert components
        │   │   ├── button.css        # Button styles
        │   │   ├── card.css          # Card components
        │   │   ├── input.css         # Input field styles
        │   │   ├── modal.css         # Modal dialogs
        │   │   ├── table.css         # Table styles
        │   │   └── toast.css         # Toast notifications
        │   ├── applicant/            # Applicant-specific styles
        │   │   ├── applications.style.css   # Application management
        │   │   ├── apply.style.css          # Application form
        │   │   ├── dashboard.style.css      # Dashboard styles
        │   │   ├── feedback.style.css       # Feedback page
        │   │   ├── interviews.style.css     # Interview pages
        │   │   ├── job-details.style.css    # Job details
        │   │   ├── jobs.style.css           # Job listings
        │   │   └── profile.style.css        # Profile management
        │   └── systemadmin/          # Admin-specific styles
        │       └── dashboard.style.css      # Admin dashboard
        ├── images/                   # Image assets
        │   └── logo.png              # Company logo
        └── js/                       # JavaScript files
            ├── main.js               # Global JavaScript
            └── components/           # Component scripts
                ├── modal.js          # Modal functionality
                └── toast.js          # Toast notifications
```

## Technology Stack

- **Backend**: PHP 8.x (No frameworks - Pure PHP)
- **Database**: MySQL 8.x
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Server**: Apache (XAMPP)
- **Architecture**: Model-View-Controller (MVC)

## User Roles & Access

### 1. System Administrator
- **Access**: Full system control
- **Features**: User management, system configuration, access logs, data viewing
- **URL**: `/systemadmin/dashboard`

### 2. Applicant (✅ COMPLETED)
- **Access**: Job browsing and application management
- **Features**: 
  - Personal dashboard with application overview
  - Browse and search job listings
  - View detailed job descriptions
  - Apply for positions
  - Track application status
  - Manage interview schedules
  - View interview feedback
  - Update personal profile
  - Withdraw applications
- **URL**: `/applicant/dashboard`

### 3. Recruiter (Future Implementation)
- **Access**: Job posting and candidate management

### 4. HR Personnel (Future Implementation)
- **Access**: Full recruitment process management

### 5. Department Head (Future Implementation)
- **Access**: Department-specific hiring oversight

## Applicant Module - Complete Feature Set

### Dashboard (`/applicant/dashboard`)
- Application statistics overview (5 applications, 2 shortlisted, 1 rejected, 2 pending)
- Recent applications summary
- Upcoming interview notifications
- Quick action buttons for common tasks

### Job Management
- **Job Listings** (`/applicant/jobs`): Browse available positions with search and filter
- **Job Details** (`/applicant/jobs/details/{id}`): View detailed job information, requirements, benefits
- **Application Form** (`/applicant/applications/apply/{id}`): Complete application form with file uploads

### Application Management
- **My Applications** (`/applicant/applications`): View all submitted applications with status tracking
- **Application Status**: Track progress (Submitted → Under Review → Interview → Decision)
- **Withdraw Application** (`/applicant/applications/withdraw/{id}`): Cancel applications

### Interview Management
- **Interview Schedule** (`/applicant/interviews`): View scheduled interviews with details
- **Interview Feedback** (`/applicant/interviews/feedback/{id}`): View detailed feedback and ratings

### Profile Management (`/applicant/profile`)
- **Personal Information**: Contact details, location, professional links
- **Education History**: Add/edit educational background with institutions and GPAs
- **Work Experience**: Manage professional experience with descriptions
- **Skills Management**: Update technical and soft skills
- **Profile Completion**: Track completion percentage with tips

## Testing URLs - Applicant Module

```bash
# Main Dashboard
http://localhost/HireFlow/public/applicant/dashboard

# Job Management
http://localhost/HireFlow/public/applicant/jobs
http://localhost/HireFlow/public/applicant/jobs/details/1

# Application Management
http://localhost/HireFlow/public/applicant/applications
http://localhost/HireFlow/public/applicant/applications/apply/1
http://localhost/HireFlow/public/applicant/applications/withdraw/1

# Interview Management
http://localhost/HireFlow/public/applicant/interviews
http://localhost/HireFlow/public/applicant/interviews/feedback/1

# Profile Management
http://localhost/HireFlow/public/applicant/profile
```

## Development Notes

### MVC Architecture
- **Models**: Handle data logic and database interactions
- **Views**: Present data to users (HTML templates)
- **Controllers**: Handle user input and coordinate between models and views

### URL Routing Pattern
```
/actor/controller/method/parameters
Examples:
/applicant/dashboard          → applicant/Dashboard.php → index()
/applicant/jobs/details/123   → applicant/Jobs.php → details(123)
/systemadmin/usermanage       → systemadmin/Usermanage.php → index()
```

### File Organization
- Controllers: PascalCase (e.g., `Dashboard.php`)
- Views: lowercase with dots (e.g., `dashboard.view.php`)
- CSS: lowercase with hyphens (e.g., `dashboard.style.css`)
- Each view has corresponding CSS file for specific styling

### Responsive Design
- Mobile-first approach
- Grid layouts with CSS Grid and Flexbox
- Consistent color scheme with #0180ff primary color
- Component-based CSS architecture

## Current Status

### ✅ Completed Features
- Complete Applicant module with 5 controllers
- 8 responsive view templates
- 8 CSS stylesheets with consistent design
- Updated routing system for applicant URLs
- Dummy data for testing all functionalities

### ⏳ In Progress
- Database integration
- Authentication system
- File upload functionality

### 📋 Next Steps
1. Implement remaining actor modules (Recruiter, HR, Department Head)
2. Add database connectivity
3. Implement authentication and session management
4. Add file upload capabilities
5. Create admin panel for job management

---

**Last Updated**: [Current Date]
**Version**: 1.0.0 - Applicant Module Complete
**Developed By**: HireFlow Development Team

