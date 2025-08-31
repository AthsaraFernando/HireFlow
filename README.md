# HireFlow - Recruitment Management System

A comprehensive recruitment management system built with PHP MVC architecture, designed to streamline the hiring process for organizations with multiple stakeholders.

## 🚀 Quick Start & Testing
**Test all views here:** [http://localhost/HireFlow/public/url-test.php](http://localhost/HireFlow/public/url-test.php)

## 📋 Project Overview

HireFlow is a multi-actor recruitment management system that supports:
- **System Admins**: Technical maintenance and user management
- **HR Admins**: Job posting and recruitment operations management  
- **Recruitment Managers**: Candidate evaluation and hiring decisions
- **Applicants**: Job browsing and application submission

## 🏗️ System Architecture

### MVC Framework
- **Models**: Database interactions and business logic
- **Views**: User interface templates with responsive design
- **Controllers**: Request handling and application flow
- **Core**: Database connection, routing, and utilities

### Technology Stack
- **Backend**: PHP 8+ with custom MVC framework
- **Database**: MySQL with comprehensive schema
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Styling**: Custom CSS framework with modern design
- **Server**: Apache (XAMPP development environment)

## ⚙️ Installation & Setup

### Prerequisites
- XAMPP (Apache + MySQL + PHP 8+)
- Web browser (Chrome, Firefox, Safari, Edge)

### Installation Steps
1. **Download & Extract**
   ```bash
   # Clone or extract HireFlow into XAMPP htdocs
   C:\xampp\htdocs\HireFlow\
   ```

2. **Database Setup**
   ```bash
   # Start XAMPP services
   - Open XAMPP Control Panel
   - Start Apache and MySQL services
   
   # Import database
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import my_db.session.sql file
   ```

3. **Access Application**
   ```bash
   # Main application
   http://localhost/HireFlow/public
   
   # URL testing dashboard
   http://localhost/HireFlow/public/url-test.php
   ```

## 📊 Development Progress

### ✅ Phase 1: Foundation (COMPLETE)
- [x] Database schema and sample data
- [x] MVC framework core
- [x] Authentication system
- [x] Common views (home, signin, signup)
- [x] Routing and error handling

### ✅ Phase 2: System Admin (COMPLETE - 8/8 views)
- [x] Dashboard with system overview
- [x] User management (create HR/Recruitment accounts)
- [x] Access logs and monitoring
- [x] Data viewing and management
- [x] System settings configuration
- [x] Backup and restore functionality
- [x] Security settings
- [x] System reports and analytics

### ✅ Phase 3: HR Admin (COMPLETE - 10/10 views)
- [x] HR Dashboard with recruitment metrics
- [x] Job Posts management (CRUD operations)
- [x] Job creation with comprehensive forms
- [x] Job editing with change tracking
- [x] Detailed job viewing with statistics
- [x] Applications management with filtering
- [x] Detailed application review
- [x] Applicant database with advanced search
- [x] Interview scheduling with calendar
- [x] HR reports and analytics dashboard

### ✅ Phase 4: Recruitment Manager (COMPLETE - 10/10 views)
- [x] Recruitment dashboard with metrics and analytics
- [x] Assigned jobs management and overview
- [x] Application review and evaluation system
- [x] Interview management and scheduling
- [x] Candidate assessment and scoring
- [x] Recruitment reports and insights
- [x] Shortlisted candidates management
- [x] Interview calendar and timeline
- [x] Candidate database with search
- [x] Evaluation tools and feedback

### ✅ Phase 5: Applicant (COMPLETE - 8/8 views)
- [x] Applicant dashboard with personal stats
- [x] Job browsing with advanced search and filters
- [x] Job application process with form submission
- [x] Application tracking with status updates
- [x] Profile management with skills and experience
- [x] Interview schedule with appointment management
- [x] Interview feedback and performance review
- [x] Professional profile with portfolio support

## 🔐 Security & Business Logic

### Account Creation Policy
- **Applicants**: Self-registration through public signup page ✅
- **HR Admins**: Created by System Admin only (no public signup) ✅
- **Recruitment Managers**: Created by System Admin only (no public signup) ✅
- **System Admins**: Created by existing System Admins only ✅

### Authentication & Authorization
- Role-based access control (RBAC)
- Secure password hashing
- Session management
- Route protection based on user roles

## 🎨 UI/UX Features

### Design System
- **Modern Interface**: Clean, professional design
- **Responsive Layout**: Mobile-first approach
- **Consistent Styling**: Unified color scheme and typography
- **Interactive Elements**: Modals, dropdowns, charts
- **Accessibility**: Screen reader friendly, keyboard navigation

### Key Components
- Dashboard cards with metrics
- Advanced filtering and search
- Data tables with sorting/pagination
- Calendar and scheduling interfaces
- Charts and analytics visualizations
- Form validation and error handling

## 📁 Project Structure

```
HireFlow/
├── app/
│   ├── controllers/          # Application logic
│   │   ├── systemadmin/     # System Admin controllers
│   │   └── hradmin/         # HR Admin controllers
│   ├── models/              # Database models
│   ├── views/               # UI templates
│   │   ├── components/      # Reusable components
│   │   ├── systemadmin/     # System Admin views
│   │   └── hradmin/         # HR Admin views
│   └── core/                # Framework core files
├── public/                  # Web-accessible files
│   ├── assets/             # CSS, JS, images
│   ├── index.php           # Application entry point
│   └── url-test.php        # Testing dashboard
├── DATABASE.md             # Database documentation
├── README.md              # Project documentation
└── my_db.session.sql      # Database setup file
```

## 🧪 Testing & Quality Assurance

### URL Testing Dashboard
- **Comprehensive Navigation**: All views accessible from single page
- **Status Indicators**: Visual feedback for implemented/pending features
- **Quick Access**: Direct links to test all functionality
- **Progress Tracking**: Color-coded implementation status

### Manual Testing Approach
1. Navigate to testing dashboard
2. Test each view systematically
3. Verify business logic compliance
4. Check responsive design
5. Validate form submissions

## 📈 Analytics & Reporting

### System Admin Reports
- User activity monitoring
- System performance metrics
- Security audit logs
- Data backup status

### HR Admin Analytics
- Recruitment funnel analysis
- Job posting performance
- Application source tracking
- Interview scheduling metrics
- Hiring conversion rates

## 🛠️ Development Guidelines

### Code Standards
- **PHP**: PSR-4 autoloading, consistent naming
- **CSS**: BEM methodology, mobile-first responsive
- **JavaScript**: ES6+ features, event-driven architecture
- **Database**: Normalized schema, prepared statements

### File Organization
- Logical separation of concerns
- Reusable component architecture
- Consistent naming conventions
- Comprehensive documentation

## 🔄 Future Enhancements

### Planned Features
- Email notifications system
- Advanced reporting dashboards
- API endpoints for integrations
- Mobile application
- Multi-language support
- Advanced security features

### Performance Optimizations
- Database query optimization
- Caching implementation
- Asset minification
- Progressive web app features

## 📞 Support & Documentation

### Additional Resources
- **Database Schema**: See [DATABASE.md](DATABASE.md)
- **API Documentation**: Coming in future phases
- **User Guides**: Integrated help system planned

### Development Status
- **Current Phase**: Phase 5 Complete (All Core Modules)
- **System Status**: Fully Functional Frontend Complete
- **Overall Progress**: 100% complete (All 42 views implemented)
- **Ready for**: Production deployment and backend integration

---

**Note**: This is an active development project. Features marked as "pending" are planned for future implementation phases. Use the URL testing dashboard to explore currently available functionality.

