# HireFlow - Actor-wise File Structure & Explanation

## Document Purpose
This document provides a comprehensive breakdown of the HireFlow system organized by user roles (actors), explaining the purpose, functionality, and relationships of each file within the system.

---

## System Architecture Overview

HireFlow follows the **Model-View-Controller (MVC)** architecture pattern:
- **Models**: Handle data logic and database interactions
- **Views**: Present information to users (UI templates)
- **Controllers**: Process user input and coordinate between models and views

### URL Routing Pattern
```
http://localhost/HireFlow/public/[actor]/[controller]/[method]/[parameters]

Examples:
/applicant/dashboard → applicant/Dashboard.php → index()
/systemadmin/usermanage → systemadmin/Usermanage.php → index()
```

---

## ACTOR 1: SYSTEM ADMINISTRATOR

### Purpose
System Administrators have full control over the HireFlow system, managing users, monitoring system activity, and maintaining system integrity.

### Controller Files

#### `app/controllers/systemadmin/Systemadmin.php`
- **Role**: Main system admin controller
- **Responsibilities**: Core admin functionality, system overview
- **Methods**: User authentication, system status checks
- **Access Level**: Highest (full system access)
- **Dependencies**: Database, User model, logging functions

#### `app/controllers/systemadmin/Dashboard.php`
- **Role**: Admin dashboard controller
- **Responsibilities**: System statistics, quick overview, admin navigation
- **Key Features**: User counts, system health, recent activity
- **Data Sources**: User tables, log files, system metrics
- **View**: `systemadmin/dashboard.view.php`

#### `app/controllers/systemadmin/Usermanage.php`
- **Role**: User management controller
- **Responsibilities**: Create, read, update, delete user accounts
- **Key Features**: User listing, role assignment, account status management
- **Security**: User permission validation, audit logging
- **View**: `systemadmin/usermanage.view.php`

#### `app/controllers/systemadmin/Accesslogs.php`
- **Role**: System access monitoring
- **Responsibilities**: Track user logins, system access, security events
- **Key Features**: Login history, failed attempts, session tracking
- **Security**: IP logging, timestamp recording, activity patterns
- **View**: `systemadmin/accesslogs.view.php`

#### `app/controllers/systemadmin/Viewdata.php`
- **Role**: System data visualization
- **Responsibilities**: Display system data, generate reports
- **Key Features**: Data tables, search functionality, export options
- **Data Sources**: All system tables, aggregated statistics
- **View**: `systemadmin/viewdata.view.php`

### View Files

#### `app/views/systemadmin/dashboard.view.php`
- **Purpose**: Admin dashboard interface
- **Layout**: Sidebar navigation + main content area
- **Components**: Statistics cards, recent activity, quick actions
- **Styling**: `public/assets/css/systemadmin/dashboard.style.css`
- **Interactive Elements**: Charts, graphs, navigation links

#### `app/views/systemadmin/usermanage.view.php`
- **Purpose**: User management interface
- **Layout**: Data table with user listings
- **Components**: User table, add/edit forms, search filters
- **Functionality**: CRUD operations, role assignments, bulk actions
- **Security**: Permission checks, confirmation dialogs

#### `app/views/systemadmin/accesslogs.view.php`
- **Purpose**: System access logs display
- **Layout**: Chronological log table
- **Components**: Log entries, filters, pagination
- **Features**: Date range selection, IP filtering, export functionality
- **Security**: Sensitive data masking, access restrictions

#### `app/views/systemadmin/viewdata.view.php`
- **Purpose**: System data viewing interface
- **Layout**: Flexible data display
- **Components**: Data tables, charts, filters
- **Features**: Search, sort, export, drill-down capabilities
- **Performance**: Pagination, lazy loading, caching

### CSS Files

#### `public/assets/css/systemadmin/dashboard.style.css`
- **Purpose**: System admin specific styling
- **Components**: Admin navigation, dashboard widgets, data tables
- **Design**: Professional, data-heavy interface design
- **Responsive**: Desktop-first approach for admin workflows
- **Theme**: Blue/gray professional color scheme

---

## ACTOR 2: APPLICANT (✅ COMPLETE IMPLEMENTATION)

### Purpose
Applicants are job seekers who use the system to find opportunities, submit applications, track progress, and manage their professional profile.

### Controller Files

#### `app/controllers/applicant/Dashboard.php`
- **Role**: Applicant main dashboard controller
- **Responsibilities**: Application overview, personal statistics, quick actions
- **Key Features**: 
  - Application counts (total: 5, shortlisted: 2, rejected: 1, pending: 2)
  - Recent applications display
  - Upcoming interviews (1 scheduled)
  - Quick action buttons for common tasks
- **Data Sources**: Applications table, interviews table, user profile
- **View**: `applicant/dashboard.view.php`
- **URL**: `/applicant/dashboard`

#### `app/controllers/applicant/Jobs.php`
- **Role**: Job browsing and job details controller
- **Responsibilities**: Display available jobs, detailed job information
- **Methods**: 
  - `index()`: List all available jobs with search/filter
  - `details($job_id)`: Show detailed job information
- **Key Features**: 
  - Job search and filtering
  - Company information display
  - Job requirements and benefits
  - Direct application links
- **Dummy Data**: 5 sample jobs across different industries
- **Views**: `applicant/jobs.view.php`, `applicant/job-details.view.php`
- **URLs**: `/applicant/jobs`, `/applicant/jobs/details/{id}`

#### `app/controllers/applicant/Applications.php`
- **Role**: Application management controller
- **Responsibilities**: Submit applications, track status, manage submissions
- **Methods**:
  - `index()`: Display all user applications
  - `apply($job_id)`: Show application form for specific job
  - `withdraw($app_id)`: Cancel/withdraw application
- **Key Features**:
  - Application status tracking (Submitted, Under Review, Interview, Decision)
  - Application history with timestamps
  - Document upload interface
  - Withdrawal functionality
- **Dummy Data**: 5 sample applications with various statuses
- **Views**: `applicant/applications.view.php`, `applicant/apply.view.php`
- **URLs**: `/applicant/applications`, `/applicant/applications/apply/{id}`, `/applicant/applications/withdraw/{id}`

#### `app/controllers/applicant/Interviews.php`
- **Role**: Interview management controller
- **Responsibilities**: Display interview schedules, show feedback
- **Methods**:
  - `index()`: Show upcoming and past interviews
  - `feedback($interview_id)`: Display interview feedback
- **Key Features**:
  - Interview calendar display
  - Interview preparation guidelines
  - Feedback and rating display
  - Interview status tracking
- **Dummy Data**: 3 sample interviews (1 scheduled, 2 completed)
- **Views**: `applicant/interviews.view.php`, `applicant/feedback.view.php`
- **URLs**: `/applicant/interviews`, `/applicant/interviews/feedback/{id}`

#### `app/controllers/applicant/Profile.php`
- **Role**: Profile management controller
- **Responsibilities**: Manage personal and professional information
- **Methods**: `index()`: Display and edit profile information
- **Key Features**:
  - Personal information management
  - Education history tracking
  - Work experience portfolio
  - Skills management
  - Profile completion tracking (85% complete)
- **Data Sections**:
  - Personal: Name, email, phone, location
  - Education: 2 degrees (Bachelor's, Master's)
  - Experience: 3 previous positions
  - Skills: 8 technical skills
- **View**: `applicant/profile.view.php`
- **URL**: `/applicant/profile`

### View Files

#### `app/views/applicant/dashboard.view.php`
- **Purpose**: Main applicant dashboard interface
- **Layout**: Sidebar navigation + dashboard cards
- **Components**: 
  - Statistics overview (applications, interviews)
  - Recent activity feed
  - Quick action buttons
  - Progress indicators
- **Interactive Elements**: Status badges, progress bars, action buttons
- **Responsive**: Mobile-optimized grid layout
- **Styling**: `applicant/dashboard.style.css`

#### `app/views/applicant/jobs.view.php`
- **Purpose**: Job listings and search interface
- **Layout**: Search header + job grid
- **Components**:
  - Search and filter controls
  - Job cards with company logos
  - Pagination controls
  - Category filters
- **Features**: Real-time search, filter by location/type
- **Responsive**: Card-based responsive grid
- **Styling**: `applicant/jobs.style.css`

#### `app/views/applicant/job-details.view.php`
- **Purpose**: Detailed job information display
- **Layout**: Two-column (job details + company info)
- **Components**:
  - Job description and requirements
  - Company information sidebar
  - Benefits and perks
  - Application button and actions
- **Features**: Social sharing, save job, apply directly
- **Responsive**: Single-column on mobile
- **Styling**: `applicant/job-details.style.css`

#### `app/views/applicant/applications.view.php`
- **Purpose**: Application management interface
- **Layout**: Table-based application listing
- **Components**:
  - Applications data table
  - Status filter tabs
  - Action buttons (view, withdraw)
  - Search functionality
- **Features**: Status-based filtering, bulk actions
- **Responsive**: Horizontal scroll on mobile
- **Styling**: `applicant/applications.style.css`

#### `app/views/applicant/apply.view.php`
- **Purpose**: Job application form
- **Layout**: Multi-step application form
- **Components**:
  - Personal information section
  - Resume/CV upload
  - Cover letter text area
  - Additional documents upload
  - Terms and conditions
- **Features**: Form validation, file upload progress
- **Responsive**: Single-column form layout
- **Styling**: `applicant/apply.style.css`

#### `app/views/applicant/interviews.view.php`
- **Purpose**: Interview schedule display
- **Layout**: Calendar-style interview list
- **Components**:
  - Upcoming interviews cards
  - Past interviews history
  - Interview details (time, location, interviewer)
  - Preparation materials links
- **Features**: Calendar navigation, status indicators
- **Responsive**: Card-based mobile layout
- **Styling**: `applicant/interviews.style.css`

#### `app/views/applicant/feedback.view.php`
- **Purpose**: Interview feedback display
- **Layout**: Detailed feedback sections
- **Components**:
  - Overall rating display
  - Detailed feedback sections
  - Improvement suggestions
  - Next steps information
- **Features**: Rating visualizations, expandable sections
- **Responsive**: Single-column responsive layout
- **Styling**: `applicant/feedback.style.css`

#### `app/views/applicant/profile.view.php`
- **Purpose**: Profile management interface
- **Layout**: Two-column (overview + editable sections)
- **Components**:
  - Profile completion tracker
  - Personal information section
  - Education history with add/edit
  - Work experience management
  - Skills portfolio
  - Profile photo upload
- **Features**: Modal edit forms, progress tracking, validation
- **Interactive Elements**: Edit buttons, modal dialogs, skill tags
- **Responsive**: Single-column on mobile
- **Styling**: `applicant/profile.style.css`

### CSS Files

#### `public/assets/css/applicant/dashboard.style.css`
- **Purpose**: Base styles for applicant module
- **Components**: Sidebar navigation, card layouts, grid systems
- **Features**: CSS Grid layouts, flexbox components, responsive breakpoints
- **Color Scheme**: #0180ff primary, consistent theme
- **Architecture**: Base file imported by other applicant CSS files

#### `public/assets/css/applicant/jobs.style.css`
- **Inherits**: dashboard.style.css
- **Purpose**: Job listing and search interface styling
- **Components**: Job cards, search filters, pagination
- **Features**: Hover effects, gradient backgrounds, smooth transitions
- **Responsive**: Card grid with mobile optimization

#### `public/assets/css/applicant/job-details.style.css`
- **Inherits**: dashboard.style.css
- **Purpose**: Detailed job page styling
- **Components**: Two-column layout, requirement lists, benefit cards
- **Features**: Typography hierarchy, icon integration, action buttons
- **Layout**: Responsive two-column design

#### `public/assets/css/applicant/applications.style.css`
- **Inherits**: dashboard.style.css
- **Purpose**: Application management interface styling
- **Components**: Data tables, status badges, action buttons
- **Features**: Status color coding, table responsiveness, hover effects
- **Interactive**: Row interactions, button states

#### `public/assets/css/applicant/apply.style.css`
- **Inherits**: dashboard.style.css
- **Purpose**: Application form styling
- **Components**: Multi-step forms, file upload areas, form validation
- **Features**: Form progression indicators, error states, success feedback
- **Layout**: Clean single-column form design

#### `public/assets/css/applicant/interviews.style.css`
- **Inherits**: dashboard.style.css
- **Purpose**: Interview management styling
- **Components**: Interview cards, calendar views, time displays
- **Features**: Timeline layouts, status indicators, card animations
- **Interactive**: Hover states, expandable details

#### `public/assets/css/applicant/feedback.style.css`
- **Inherits**: dashboard.style.css
- **Purpose**: Interview feedback display styling
- **Components**: Rating displays, feedback sections, progress bars
- **Features**: Star ratings, score visualizations, structured layout
- **Design**: Clean, professional feedback presentation

#### `public/assets/css/applicant/profile.style.css`
- **Inherits**: dashboard.style.css
- **Purpose**: Profile management styling
- **Components**: Profile forms, modal dialogs, skill tags, completion tracking
- **Features**: Two-column layout, editable sections, modal functionality
- **Interactive**: Edit interfaces, progress indicators, form validation

---

## ACTOR 3: RECRUITER (Future Implementation)

### Planned Purpose
Recruiters will be responsible for posting job openings, reviewing applications, and managing the initial stages of the recruitment process.

### Planned Controller Files
- `app/controllers/recruiter/Dashboard.php` - Recruiter dashboard with job posting stats
- `app/controllers/recruiter/Jobs.php` - Job posting and management
- `app/controllers/recruiter/Applications.php` - Application review and screening
- `app/controllers/recruiter/Interviews.php` - Interview scheduling
- `app/controllers/recruiter/Reports.php` - Recruitment analytics

### Planned Features
- Job posting with requirements specification
- Application screening and filtering
- Candidate communication
- Interview scheduling coordination
- Recruitment pipeline management

---

## ACTOR 4: HR PERSONNEL (Future Implementation)

### Planned Purpose
HR Personnel will oversee the entire recruitment process, manage policy compliance, and coordinate between different stakeholders.

### Planned Controller Files
- `app/controllers/hr/Dashboard.php` - HR overview dashboard
- `app/controllers/hr/Pipeline.php` - Complete recruitment pipeline
- `app/controllers/hr/Reports.php` - HR analytics and reporting
- `app/controllers/hr/Policies.php` - Recruitment policy management
- `app/controllers/hr/Communications.php` - Candidate communication

### Planned Features
- End-to-end recruitment oversight
- Policy compliance monitoring
- Advanced reporting and analytics
- Candidate relationship management
- Integration with external HR systems

---

## ACTOR 5: DEPARTMENT HEAD (Future Implementation)

### Planned Purpose
Department Heads will participate in the final stages of recruitment, reviewing shortlisted candidates and making final hiring decisions.

### Planned Controller Files
- `app/controllers/department/Dashboard.php` - Department hiring overview
- `app/controllers/department/Reviews.php` - Candidate review interface
- `app/controllers/department/Decisions.php` - Final hiring decisions
- `app/controllers/department/Team.php` - Team composition planning

### Planned Features
- Final candidate review
- Hiring decision workflow
- Team planning and forecasting
- Department-specific analytics

---

## SHARED SYSTEM FILES

### Core Framework Files

#### `app/core/App.php`
- **Purpose**: Main application router and request handler
- **Responsibilities**: URL parsing, controller loading, method routing
- **Key Features**: 
  - Folder-based controller support (applicant/, systemadmin/)
  - Method parameter passing
  - 404 error handling
  - Clean URL structure
- **URL Routing Logic**:
  ```php
  /actor/controller/method/parameters
  Example: /applicant/jobs/details/1
  ```

#### `app/core/Controller.php`
- **Purpose**: Base controller class
- **Responsibilities**: Common controller functionality, view loading
- **Methods**: View rendering, data passing, error handling
- **Inheritance**: All controllers extend this base class

#### `app/core/Database.php`
- **Purpose**: Database connection and query management
- **Responsibilities**: MySQL connection, query execution, result handling
- **Security**: Prepared statements, injection prevention
- **Configuration**: Database credentials and settings

#### `app/core/Model.php`
- **Purpose**: Base model class for data handling
- **Responsibilities**: Database interactions, data validation
- **Methods**: CRUD operations, relationship handling
- **Inheritance**: All models extend this base class

#### `app/core/config.php`
- **Purpose**: System configuration settings
- **Contains**: Database settings, system constants, environment variables
- **Security**: Sensitive configuration management

#### `app/core/functions.php`
- **Purpose**: Global utility functions
- **Contains**: Helper functions, formatting utilities, common operations
- **Usage**: Available throughout the application

#### `app/core/init.php`
- **Purpose**: System initialization
- **Responsibilities**: Autoloading, session management, error handling
- **Execution**: Runs before application start

### Model Files

#### `app/models/User.php`
- **Purpose**: User data model
- **Responsibilities**: User account management, authentication
- **Methods**: User CRUD, login validation, profile management
- **Relationships**: Roles, applications, interviews

#### `app/models/Role.php`
- **Purpose**: User role management model
- **Responsibilities**: Role definitions, permissions
- **Methods**: Role assignment, permission checking
- **Integration**: User authentication, access control

### Authentication & General Controllers

#### `app/controllers/Home.php`
- **Purpose**: Homepage controller
- **Responsibilities**: Landing page, general information
- **View**: `home.view.php`
- **URL**: `/` or `/home`

#### `app/controllers/Signin.php`
- **Purpose**: User authentication controller
- **Responsibilities**: Login form, authentication validation
- **Security**: Password verification, session management
- **Redirection**: Role-based dashboard routing

#### `app/controllers/Signout.php`
- **Purpose**: User logout controller
- **Responsibilities**: Session termination, cleanup
- **Security**: Secure logout, session invalidation

#### `app/controllers/Signup.php`
- **Purpose**: User registration controller
- **Responsibilities**: New user registration, account creation
- **Validation**: Input validation, duplicate checking
- **View**: `signup.view.php`

#### `app/controllers/_404.php`
- **Purpose**: Error handling controller
- **Responsibilities**: 404 error display, error logging
- **View**: `404.view.php`

### Public Assets Structure

#### CSS Organization
```
public/assets/css/
├── main.css                    # Global styles
├── utils.css                   # Utility classes
├── home.style.css             # Homepage styles
├── signup.style.css           # Registration styles
├── components/                # Reusable components
│   ├── alert.css             # Alert styling
│   ├── button.css            # Button components
│   ├── card.css              # Card layouts
│   ├── input.css             # Form inputs
│   ├── modal.css             # Modal dialogs
│   ├── table.css             # Data tables
│   └── toast.css             # Toast notifications
├── applicant/                # Applicant-specific styles
│   └── [8 CSS files]         # Complete applicant styling
└── systemadmin/              # Admin-specific styles
    └── dashboard.style.css   # Admin dashboard
```

#### JavaScript Organization
```
public/assets/js/
├── main.js                   # Global JavaScript
└── components/              # Component scripts
    ├── modal.js            # Modal functionality
    └── toast.js            # Toast notifications
```

#### Image Assets
```
public/assets/images/
└── logo.png                 # Company logo
```

---

## File Relationships & Dependencies

### Controller Dependencies
```
Controllers → Views → CSS Files
Controllers → Models → Database
Controllers → Core Classes → System Functions
```

### Applicant Module Flow
```
URL: /applicant/dashboard
↓
App.php (routing)
↓
applicant/Dashboard.php (controller)
↓
applicant/dashboard.view.php (view)
↓
applicant/dashboard.style.css (styling)
```

### CSS Import Structure
```
applicant/dashboard.style.css (base styles)
↑
applicant/jobs.style.css
applicant/applications.style.css
applicant/interviews.style.css
applicant/profile.style.css
[All other applicant CSS files import dashboard.style.css]
```

---

## Security & Access Control

### Access Levels
1. **Public**: Home, Signin, Signup (no authentication required)
2. **Applicant**: Applicant module (applicant role required)
3. **System Admin**: System admin module (admin role required)
4. **Recruiter**: Future - Recruiter module (recruiter role required)
5. **HR**: Future - HR module (HR role required)
6. **Department Head**: Future - Department module (department head role required)

### File Access Patterns
- **Public Files**: Accessible to all users
- **Actor-Specific Controllers**: Role-based access control
- **Shared Models**: Permission-based data access
- **Core Files**: System-level access only

---

## Development Status Summary

### ✅ COMPLETED MODULES
- **System Administrator**: Basic functionality implemented
- **Applicant**: Complete implementation with 15+ features
- **Core System**: MVC framework, routing, basic structure
- **Authentication Framework**: Controllers created, integration pending

### ⏳ IN PROGRESS
- Database integration
- Authentication system completion
- File upload functionality

### 📋 PLANNED MODULES
- Recruiter module
- HR Personnel module
- Department Head module
- Advanced reporting system

---

**Document Version**: 1.0.0
**Last Updated**: [Current Date]
**Coverage**: Complete file-by-file breakdown of current system
**Status**: Ready for development continuation
