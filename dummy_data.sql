-- ====================================================================
-- HIREFLOW DUMMY DATA SCRIPT
-- ====================================================================
-- This script inserts comprehensive dummy data for testing and development
-- Run this AFTER creating the database schema using database_schema.sql
-- 
-- Default Users Included:
-- System Admin: admin@hireflow.com / Password@1
-- HR Admin: hr@hireflow.com / Password@1
-- Recruitment Manager: recruiter@hireflow.com / Password@1
-- Applicant: athsara@hireflow.com / Password@1
-- ====================================================================

USE hireflow_db;

-- ====================================================================
-- 1. ADDITIONAL DEPARTMENTS
-- ====================================================================
INSERT INTO departments (name, description, created_by) VALUES
('Information Technology', 'Software development, system administration, and IT support roles', 1),
('Human Resources', 'HR operations, recruitment, and employee relations', 1),
('Finance & Accounting', 'Financial planning, accounting, and budget management', 1),
('Marketing & Sales', 'Digital marketing, sales operations, and customer relations', 1),
('Operations', 'Business operations, logistics, and process management', 1),
('Customer Support', 'Customer service and technical support roles', 1),
('Research & Development', 'Product research, innovation, and development', 1),
('Quality Assurance', 'Testing, quality control, and process improvement', 1);

-- ====================================================================
-- 2. JOB POSTS - COMPREHENSIVE LISTINGS
-- ====================================================================
INSERT INTO job_posts (title, description, requirements, department_id, employment_type, salary_range, location, application_deadline, status, created_by) VALUES

-- IT Department Jobs
('Senior Software Engineer', 
'We are seeking an experienced Software Engineer to join our dynamic development team. You will be responsible for designing, developing, and maintaining high-quality software applications using modern technologies and best practices.',
'• Bachelor''s degree in Computer Science or related field
• 5+ years of experience in software development
• Proficiency in PHP, JavaScript, Python, or Java
• Experience with database design (MySQL, PostgreSQL)
• Knowledge of web frameworks (Laravel, React, Vue.js)
• Understanding of version control systems (Git)
• Strong problem-solving and analytical skills
• Excellent communication and teamwork abilities', 
1, 'full-time', '$70,000 - $90,000', 'Colombo, Sri Lanka', '2025-10-15', 'active', 2),

('Frontend Developer', 
'Join our creative team as a Frontend Developer and help us build beautiful, responsive, and user-friendly web applications. You will work closely with designers and backend developers to create exceptional user experiences.',
'• Bachelor''s degree in Computer Science, Web Development, or related field
• 3+ years of frontend development experience
• Expert knowledge of HTML5, CSS3, and JavaScript (ES6+)
• Experience with modern frameworks (React, Vue.js, Angular)
• Proficiency in CSS preprocessors (SASS, LESS)
• Understanding of responsive design principles
• Experience with build tools (Webpack, Gulp, npm)
• Knowledge of version control (Git)
• Eye for design and attention to detail', 
1, 'full-time', '$50,000 - $70,000', 'Colombo, Sri Lanka', '2025-09-30', 'active', 2),

('DevOps Engineer', 
'We are looking for a skilled DevOps Engineer to help us streamline our development and deployment processes. You will be responsible for maintaining our CI/CD pipelines, cloud infrastructure, and ensuring system reliability.',
'• Bachelor''s degree in Computer Science, Engineering, or related field
• 4+ years of experience in DevOps or system administration
• Experience with cloud platforms (AWS, Azure, Google Cloud)
• Proficiency in containerization (Docker, Kubernetes)
• Knowledge of CI/CD tools (Jenkins, GitLab CI, GitHub Actions)
• Experience with infrastructure as code (Terraform, CloudFormation)
• Scripting skills (Bash, Python, PowerShell)
• Understanding of monitoring tools (Prometheus, Grafana)
• Strong troubleshooting and problem-solving skills', 
1, 'full-time', '$65,000 - $85,000', 'Remote', '2025-10-01', 'active', 2),

-- HR Department Jobs
('HR Business Partner', 
'Join our HR team as an HR Business Partner and play a key role in supporting our organizational growth. You will work closely with management to develop HR strategies, policies, and programs that align with business objectives.',
'• Bachelor''s degree in Human Resources, Business Administration, or related field
• 5+ years of HR experience with focus on business partnering
• Strong knowledge of employment law and HR best practices
• Experience in talent acquisition and performance management
• Excellent interpersonal and communication skills
• Proficiency in HRIS systems and MS Office suite
• Professional HR certification (SHRM, HRCI) preferred
• Ability to handle confidential information with discretion
• Strong analytical and problem-solving skills', 
2, 'full-time', '$55,000 - $75,000', 'Colombo, Sri Lanka', '2025-10-20', 'active', 2),

('Talent Acquisition Specialist', 
'We are seeking a dynamic Talent Acquisition Specialist to join our growing HR team. You will be responsible for identifying, attracting, and hiring top talent across various departments and skill levels.',
'• Bachelor''s degree in Human Resources, Psychology, or related field
• 3+ years of experience in recruitment and talent acquisition
• Experience with various recruitment channels (job boards, social media, networking)
• Proficiency in applicant tracking systems (ATS)
• Strong interviewing and assessment skills
• Knowledge of employment laws and regulations
• Excellent communication and negotiation skills
• Ability to work in a fast-paced environment
• Experience with technical recruitment preferred', 
2, 'full-time', '$45,000 - $60,000', 'Colombo, Sri Lanka', '2025-09-25', 'active', 2),

-- Finance Department Jobs
('Financial Analyst', 
'Join our Finance team as a Financial Analyst and contribute to our company''s financial planning and analysis efforts. You will be responsible for preparing financial reports, conducting analysis, and supporting strategic decision-making.',
'• Bachelor''s degree in Finance, Accounting, Economics, or related field
• 3+ years of experience in financial analysis or related role
• Strong proficiency in Excel and financial modeling
• Experience with financial software (SAP, Oracle, QuickBooks)
• Knowledge of accounting principles and financial regulations
• Excellent analytical and quantitative skills
• Strong attention to detail and accuracy
• Ability to communicate complex financial information clearly
• CFA or similar certification preferred', 
3, 'full-time', '$50,000 - $65,000', 'Colombo, Sri Lanka', '2025-10-10', 'active', 2),

-- Marketing Department Jobs
('Digital Marketing Manager', 
'We are looking for a creative and results-driven Digital Marketing Manager to lead our digital marketing initiatives. You will develop and execute comprehensive digital marketing strategies to increase brand awareness and drive customer acquisition.',
'• Bachelor''s degree in Marketing, Communications, or related field
• 4+ years of experience in digital marketing
• Proven experience with digital marketing channels (SEO, SEM, social media, email)
• Proficiency in marketing tools (Google Analytics, AdWords, Facebook Ads Manager)
• Experience with marketing automation platforms
• Strong analytical skills and data-driven mindset
• Excellent written and verbal communication skills
• Creative thinking and problem-solving abilities
• Experience with content management systems', 
4, 'full-time', '$55,000 - $70,000', 'Colombo, Sri Lanka', '2025-09-28', 'active', 2),

-- Customer Support Jobs
('Customer Success Manager', 
'Join our Customer Success team and help us build lasting relationships with our clients. You will be responsible for ensuring customer satisfaction, driving product adoption, and identifying growth opportunities.',
'• Bachelor''s degree in Business, Communications, or related field
• 3+ years of experience in customer success, account management, or related role
• Strong customer service and relationship management skills
• Experience with CRM systems (Salesforce, HubSpot)
• Excellent communication and presentation skills
• Problem-solving and conflict resolution abilities
• Data analysis skills to track customer metrics
• Ability to work collaboratively across teams
• Technical aptitude to understand our products', 
6, 'full-time', '$45,000 - $60,000', 'Colombo, Sri Lanka', '2025-10-05', 'active', 2),

-- QA Department Jobs
('QA Engineer', 
'We are seeking a detail-oriented QA Engineer to join our quality assurance team. You will be responsible for testing our software applications, identifying bugs, and ensuring our products meet the highest quality standards.',
'• Bachelor''s degree in Computer Science, Engineering, or related field
• 3+ years of experience in software testing and quality assurance
• Experience with manual and automated testing methodologies
• Knowledge of testing tools (Selenium, TestRail, JIRA)
• Understanding of software development lifecycle (SDLC)
• Experience with API testing and database testing
• Strong analytical and problem-solving skills
• Excellent attention to detail
• Good communication skills for reporting issues', 
8, 'full-time', '$45,000 - $60,000', 'Colombo, Sri Lanka', '2025-10-12', 'active', 2),

-- Entry Level Positions
('Junior Web Developer', 
'Perfect opportunity for a fresh graduate or junior developer to join our development team. You will work under the guidance of senior developers to build and maintain web applications while learning industry best practices.',
'• Bachelor''s degree in Computer Science, Web Development, or related field
• 0-2 years of experience in web development
• Basic knowledge of HTML, CSS, JavaScript
• Familiarity with at least one programming language (PHP, Python, Java)
• Understanding of database concepts
• Eagerness to learn and grow
• Good problem-solving skills
• Strong work ethic and attention to detail
• Portfolio of personal or academic projects preferred', 
1, 'full-time', '$35,000 - $45,000', 'Colombo, Sri Lanka', '2025-10-25', 'active', 2),

-- Part-time/Contract Positions
('UI/UX Designer (Contract)', 
'We are looking for a talented UI/UX Designer for a 6-month contract to help redesign our product interfaces. You will work closely with our product and development teams to create intuitive and beautiful user experiences.',
'• Bachelor''s degree in Design, HCI, or related field
• 3+ years of experience in UI/UX design
• Proficiency in design tools (Figma, Sketch, Adobe Creative Suite)
• Strong portfolio demonstrating design thinking and process
• Experience with user research and usability testing
• Knowledge of design systems and prototyping
• Understanding of front-end development constraints
• Excellent visual design skills
• Strong communication and collaboration skills', 
1, 'contract', '$40 - $60 per hour', 'Remote', '2025-09-20', 'active', 2);

-- ====================================================================
-- 3. APPLICATIONS - REALISTIC APPLICATION DATA
-- ====================================================================
INSERT INTO applications (job_post_id, applicant_id, cover_letter, resume_path, status, applied_at) VALUES

-- Applications for Senior Software Engineer (job_post_id: 1)
(1, 4, 'Dear Hiring Manager,

I am excited to apply for the Senior Software Engineer position at HireFlow. With over 6 years of experience in full-stack development, I have developed a strong foundation in PHP, JavaScript, and database design. 

In my current role at TechCorp, I led the development of a customer management system that improved efficiency by 40%. I am passionate about clean code, best practices, and continuous learning. I would love to bring my expertise to your innovative team.

Looking forward to discussing how I can contribute to HireFlow''s success.

Best regards,
Athsara Manitha', '/uploads/resumes/athsara_resume.pdf', 'under_review', '2025-09-01 09:15:00'),

(1, 5, 'Dear HireFlow Team,

I am writing to express my interest in the Senior Software Engineer role. My 7 years of experience in software development, particularly in web applications and API development, align perfectly with your requirements.

I have extensive experience with PHP frameworks, modern JavaScript, and cloud technologies. At my previous company, I architected and developed a microservices-based application that now serves over 100,000 users daily.

I am excited about the opportunity to contribute to your team and help build innovative solutions.

Sincerely,
Chamali Perera', '/uploads/resumes/chamali_resume.pdf', 'shortlisted', '2025-09-02 14:30:00'),

-- Applications for Frontend Developer (job_post_id: 2)
(2, 6, 'Hello,

I am thrilled to apply for the Frontend Developer position. As a passionate frontend developer with 4 years of experience, I specialize in creating responsive, user-friendly interfaces using React, Vue.js, and modern CSS.

My portfolio includes e-commerce platforms, corporate websites, and web applications that have received excellent user feedback. I am particularly drawn to HireFlow''s focus on user experience and would love to contribute to your frontend initiatives.

Thank you for considering my application.

Best,
Nuwan Silva', '/uploads/resumes/nuwan_resume.pdf', 'applied', '2025-09-03 11:45:00'),

(2, 7, 'Dear Hiring Team,

With 5 years of frontend development experience and a keen eye for design, I am excited to apply for the Frontend Developer role at HireFlow. I have successfully delivered numerous projects using React, Angular, and Vue.js.

I am passionate about creating pixel-perfect, accessible, and performant web applications. My recent project involved building a dashboard application that improved user engagement by 60%.

I look forward to the opportunity to discuss how I can contribute to your team.

Regards,
Priya Jayasinghe', '/uploads/resumes/priya_resume.pdf', 'under_review', '2025-09-04 16:20:00'),

-- Applications for HR Business Partner (job_post_id: 4)
(4, 8, 'Dear HR Team,

I am excited to apply for the HR Business Partner position at HireFlow. With 6 years of progressive HR experience, including 3 years in business partnering roles, I have developed strong skills in strategic HR planning and organizational development.

At my current company, I successfully led talent acquisition initiatives that reduced time-to-hire by 35% and implemented performance management systems that improved employee satisfaction scores.

I am passionate about creating people-centric solutions and would love to contribute to HireFlow''s growth.

Best regards,
Kamal Fernando', '/uploads/resumes/kamal_resume.pdf', 'interviewed', '2025-09-05 10:00:00'),

-- More applications for various positions
(3, 4, 'Dear Hiring Manager,

I am interested in the DevOps Engineer position. While my primary background is in software development, I have gained significant experience with cloud platforms and CI/CD pipelines in my current role.

I have successfully implemented Docker containerization for our applications and set up automated deployment pipelines using GitHub Actions. I am eager to transition into a dedicated DevOps role and expand my infrastructure skills.

Thank you for your consideration.

Sincerely,
Athsara Manitha', '/uploads/resumes/athsara_devops_resume.pdf', 'applied', '2025-09-06 13:30:00'),

(5, 5, 'Hello,

I am writing to apply for the Talent Acquisition Specialist position. With 4 years of experience in recruitment and a passion for connecting talented individuals with great opportunities, I am excited about this role.

In my current position, I have successfully filled over 200 positions across various departments and skill levels. I have experience with technical recruitment and have built strong relationships with universities and professional networks.

I would love to bring my recruitment expertise to HireFlow.

Best,
Chamali Perera', '/uploads/resumes/chamali_hr_resume.pdf', 'under_review', '2025-09-07 08:45:00'),

(7, 6, 'Dear Marketing Team,

I am excited to apply for the Digital Marketing Manager position. With 5 years of experience in digital marketing and a proven track record of successful campaigns, I am confident I can help drive HireFlow''s marketing objectives.

I have managed marketing budgets exceeding $500K and have experience across all digital channels. My recent campaign for a SaaS product achieved a 300% increase in qualified leads within 6 months.

Looking forward to discussing how I can contribute to your marketing goals.

Regards,
Nuwan Silva', '/uploads/resumes/nuwan_marketing_resume.pdf', 'applied', '2025-09-01 15:15:00'),

(9, 7, 'Dear QA Team,

I am applying for the QA Engineer position with great enthusiasm. As a detail-oriented professional with 3 years of testing experience, I have developed strong skills in both manual and automated testing.

I have experience with Selenium, API testing, and have worked in Agile environments. My systematic approach to testing has helped identify critical bugs before production releases, saving significant costs and maintaining product quality.

I am excited about the opportunity to ensure HireFlow''s products meet the highest quality standards.

Best regards,
Priya Jayasinghe', '/uploads/resumes/priya_qa_resume.pdf', 'shortlisted', '2025-09-02 12:00:00'),

(10, 8, 'Hello,

I am a recent Computer Science graduate excited to apply for the Junior Web Developer position. During my studies, I completed several web development projects using HTML, CSS, JavaScript, and PHP.

My final year project was a task management web application built with PHP and MySQL, which received the best project award. I am eager to start my career and learn from experienced developers at HireFlow.

Thank you for considering my application.

Sincerely,
Kamal Fernando', '/uploads/resumes/kamal_junior_resume.pdf', 'applied', '2025-09-03 09:30:00');

-- ====================================================================
-- 4. INTERVIEWS - SCHEDULED INTERVIEWS
-- ====================================================================
INSERT INTO interviews (application_id, interviewer_id, interview_date, interview_type, location, status, notes) VALUES

-- Interview for Chamali's Senior Software Engineer application
(2, 3, '2025-09-10 14:00:00', 'technical', 'Conference Room A', 'scheduled', 'Technical interview focusing on PHP, JavaScript, and system design. Please prepare coding challenges.'),

-- Interview for Kamal's HR Business Partner application  
(5, 2, '2025-09-12 10:30:00', 'behavioral', 'HR Office', 'scheduled', 'Behavioral interview to assess HR competencies and cultural fit.'),

-- Interview for Priya's QA Engineer application
(9, 3, '2025-09-15 15:30:00', 'technical', 'Online - Google Meet', 'scheduled', 'Technical assessment covering testing methodologies and automation tools.'),

-- Completed interview
(5, 2, '2025-09-08 11:00:00', 'initial', 'HR Office', 'completed', 'Initial screening completed. Candidate shows strong HR background and communication skills. Recommend proceeding to final interview.'),

-- Panel interview
(2, 1, '2025-09-14 16:00:00', 'panel', 'Main Conference Room', 'scheduled', 'Panel interview with technical team leads and department head.');

-- ====================================================================
-- 5. NOTIFICATIONS - SYSTEM NOTIFICATIONS
-- ====================================================================
INSERT INTO notifications (user_id, title, message, type, is_read) VALUES

-- Notifications for applicants
(4, 'Application Received', 'Your application for Senior Software Engineer has been received and is under review.', 'application', false),
(4, 'Application Status Update', 'Your application for DevOps Engineer is currently under review by our technical team.', 'application', false),
(5, 'Interview Scheduled', 'Congratulations! An interview has been scheduled for your Senior Software Engineer application on September 10, 2025.', 'interview', false),
(5, 'Application Received', 'Your application for Talent Acquisition Specialist has been received.', 'application', true),
(8, 'Interview Completed', 'Thank you for attending the interview for HR Business Partner position. We will contact you with next steps soon.', 'interview', true),
(8, 'Application Received', 'Your application for Junior Web Developer has been received.', 'application', false),

-- Notifications for HR and recruitment staff
(2, 'New Application', 'New application received for Senior Software Engineer position from Athsara Manitha.', 'application', true),
(2, 'Interview Reminder', 'Interview scheduled tomorrow at 10:30 AM for HR Business Partner position.', 'interview', false),
(2, 'Application Deadline', 'Application deadline for Talent Acquisition Specialist position is approaching (September 25, 2025).', 'deadline', false),
(3, 'Technical Interview', 'Technical interview scheduled for September 10, 2025 for Senior Software Engineer candidate.', 'interview', false),
(3, 'QA Assessment', 'QA Engineer candidate assessment scheduled for September 15, 2025.', 'interview', false),

-- System notifications
(1, 'System Maintenance', 'Scheduled system maintenance on September 20, 2025 from 2:00 AM to 4:00 AM.', 'system', true),
(1, 'Security Update', 'Security patches have been applied to the system. All user sessions will be refreshed.', 'system', true),
(2, 'Monthly Report', 'Monthly recruitment report for August 2025 is ready for review.', 'report', false);

-- ====================================================================
-- 6. ACCESS LOGS - SAMPLE ACTIVITY LOGS
-- ====================================================================
INSERT INTO access_logs (user_id, action, page_accessed, ip_address, user_agent, timestamp) VALUES

-- System Admin activities
(1, 'login', '/signin', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-09-07 08:00:00'),
(1, 'view_page', '/systemadmin/dashboard', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-09-07 08:01:15'),
(1, 'view_page', '/systemadmin/usermanage', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-09-07 08:05:30'),
(1, 'view_page', '/systemadmin/accesslogs', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-09-07 08:10:45'),

-- HR Admin activities
(2, 'login', '/signin', '192.168.1.101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', '2025-09-07 09:30:00'),
(2, 'view_page', '/hradmin/dashboard', '192.168.1.101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', '2025-09-07 09:31:20'),
(2, 'create_job', '/hradmin/job-posts/create', '192.168.1.101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', '2025-09-07 09:45:10'),
(2, 'view_applications', '/hradmin/applications', '192.168.1.101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', '2025-09-07 10:15:30'),

-- Recruitment Manager activities
(3, 'login', '/signin', '192.168.1.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:91.0) Gecko/20100101 Firefox/91.0', '2025-09-07 10:00:00'),
(3, 'view_page', '/recruitment/dashboard', '192.168.1.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:91.0) Gecko/20100101 Firefox/91.0', '2025-09-07 10:02:15'),
(3, 'review_application', '/recruitment/applications/review', '192.168.1.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:91.0) Gecko/20100101 Firefox/91.0', '2025-09-07 10:30:45'),
(3, 'schedule_interview', '/recruitment/interviews/schedule', '192.168.1.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:91.0) Gecko/20100101 Firefox/91.0', '2025-09-07 11:00:20'),

-- Applicant activities
(4, 'login', '/signin', '192.168.1.103', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15', '2025-09-07 14:30:00'),
(4, 'view_page', '/applicant/dashboard', '192.168.1.103', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15', '2025-09-07 14:31:10'),
(4, 'browse_jobs', '/applicant/jobs/browse', '192.168.1.103', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15', '2025-09-07 14:35:20'),
(4, 'apply_job', '/applicant/jobs/apply', '192.168.1.103', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15', '2025-09-07 14:50:30'),

-- Additional applicant activities
(5, 'login', '/signin', '192.168.1.104', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', '2025-09-06 16:20:00'),
(5, 'view_page', '/applicant/dashboard', '192.168.1.104', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', '2025-09-06 16:21:15'),
(5, 'update_profile', '/applicant/profile/edit', '192.168.1.104', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', '2025-09-06 16:45:30'),

(6, 'register', '/signup', '192.168.1.105', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-09-05 19:30:00'),
(6, 'login', '/signin', '192.168.1.105', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-09-05 19:32:10'),
(6, 'browse_jobs', '/applicant/jobs/browse', '192.168.1.105', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-09-05 19:40:20');

-- ====================================================================
-- 7. SYSTEM SETTINGS - CONFIGURATION DATA
-- ====================================================================
INSERT INTO system_settings (setting_key, setting_value, description) VALUES
('company_name', 'HireFlow Technologies', 'Company name displayed throughout the system'),
('company_email', 'info@hireflow.com', 'Primary company email address'),
('company_phone', '+94-11-2345678', 'Company contact phone number'),
('company_address', '123 Business District, Colombo 03, Sri Lanka', 'Company physical address'),
('application_deadline_default', '30', 'Default application deadline in days'),
('max_file_upload_size', '10', 'Maximum file upload size in MB'),
('email_notifications_enabled', 'true', 'Enable/disable email notifications'),
('system_maintenance_mode', 'false', 'System maintenance mode status'),
('password_min_length', '8', 'Minimum password length requirement'),
('session_timeout', '3600', 'User session timeout in seconds'),
('recruitment_workflow_enabled', 'true', 'Enable advanced recruitment workflow features'),
('analytics_enabled', 'true', 'Enable system analytics and reporting');

-- ====================================================================
-- SUMMARY
-- ====================================================================
-- This script has inserted the following dummy data:
-- 
-- • 8 Departments (IT, HR, Finance, Marketing, Operations, Support, R&D, QA)
-- • 11 Job Posts across all departments with realistic descriptions
-- • 10 Job Applications with detailed cover letters
-- • 5 Interview records (scheduled and completed)
-- • 17 Notifications for various users and activities
-- • 17 Access Log entries showing user activities
-- • 12 System Settings for application configuration
--
-- Total Records Added: ~70+ records across all tables
-- 
-- All data includes the default users:
-- System Admin: admin@hireflow.com / Password@1
-- HR Admin: hr@hireflow.com / Password@1  
-- Recruitment Manager: recruiter@hireflow.com / Password@1
-- Applicant: athsara@hireflow.com / Password@1
-- Additional applicants: chamali.perera@gmail.com, nuwan.silva@gmail.com, 
--                       priya.j@gmail.com, kamal.fernando@gmail.com
-- ====================================================================
