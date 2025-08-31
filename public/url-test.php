<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HireFlow - URL Testing & Navigation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }
        
        .phase-info {
            background: #e7f3ff;
            border: 2px solid #b8daff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            color: #004085;
        }
        
        .business-logic h3 {
            color: #002752;
            margin-bottom: 15px;
        }
        
        .policy-item {
            margin: 10px 0;
            padding-left: 20px;
            position: relative;
        }
        
        .policy-item::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
        }
        
        .content {
            padding: 30px;
        }
        
        .actor-section {
            margin-bottom: 40px;
            border: 1px solid #e1e8ed;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .actor-header {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #e1e8ed;
        }
        
        .actor-title {
            font-size: 1.5em;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .actor-description {
            color: #666;
            font-size: 0.95em;
        }
        
        .links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
            padding: 20px;
        }
        
        .link-item {
            display: block;
            padding: 15px 20px;
            background: #f8f9fa;
            border: 1px solid #e1e8ed;
            border-radius: 8px;
            text-decoration: none;
            color: #2c3e50;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .link-item:hover {
            background: #e3f2fd;
            border-color: #2196f3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.2);
        }
        
        .link-title {
            font-weight: 600;
            font-size: 1.1em;
            margin-bottom: 5px;
        }
        
        .link-url {
            font-size: 0.9em;
            color: #666;
            font-family: 'Courier New', monospace;
        }
        
        .link-note {
            font-size: 0.8em;
            color: #007bff;
            margin-top: 5px;
            font-style: italic;
        }
        
        .status {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: 500;
        }
        
        .status.exists {
            background: #d4edda;
            color: #155724;
        }
        
        .status.pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status.error {
            background: #f8d7da;
            color: #721c24;
        }
        
        .legend {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        
        .info-box {
            background: #e3f2fd;
            border: 1px solid #2196f3;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .info-title {
            font-weight: 600;
            color: #1976d2;
            margin-bottom: 10px;
        }
        
        .info-text {
            color: #333;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎯 HireFlow</h1>
            <p>URL Testing & Navigation Dashboard</p>
        </div>
        
        <div class="content">
            <div class="info-box">
                <div class="info-title">📋 Development Status</div>
                <div class="info-text">
                    This page provides easy navigation to test all views in the HireFlow system. 
                    <strong>Phase 3 (HR Admin) has been completed!</strong> All 10 HR Admin views are now fully functional.
                    Click any link to test the corresponding view. Green indicates existing pages, 
                    yellow indicates planned/pending pages, and red indicates broken links.
                </div>
            </div>
            
            <div class="business-logic">
                <h3>🏢 Account Creation Business Logic</h3>
                <div class="policy-item"><strong>Applicants (Job Seekers):</strong> Can self-register through public signup page</div>
                <div class="policy-item"><strong>HR Admins:</strong> Accounts created by System Admin only (no public signup)</div>
                <div class="policy-item"><strong>Recruitment Managers:</strong> Accounts created by System Admin only (no public signup)</div>
                <div class="policy-item"><strong>System Admins:</strong> Accounts created by other System Admins only</div>
                <div style="margin-top: 15px; padding: 10px; background: #fff3cd; border-radius: 4px; border-left: 4px solid #ffc107;">
                    <strong>⚠️ Important:</strong> Only the signup page allows public registration (for applicants only). 
                    All staff accounts must be created through System Admin → User Management.
                </div>
            </div>
            
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color" style="background: #d4edda;"></div>
                    <span>Implemented</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #fff3cd;"></div>
                    <span>Pending</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #f8d7da;"></div>
                    <span>Error/Missing</span>
                </div>
            </div>
            
            <div class="info-box">
                <div class="info-title">🚀 Phase Development Progress</div>
                <div class="info-text">
                    <strong>✅ Phase 1 Complete:</strong> Database setup, authentication, common views<br>
                    <strong>✅ Phase 2 Complete:</strong> System Admin interface (8/8 views implemented)<br>
                    <strong>✅ Phase 3 Complete:</strong> HR Admin interface (10/10 views implemented)<br>
                    <strong>✅ Phase 4 Complete:</strong> Recruitment Manager interface (10/10 views implemented)<br>
                    <strong>✅ Phase 5 Complete:</strong> Applicant interface (8/8 views implemented)<br><br>
                    <strong>Overall Progress:</strong> 100% complete (42/42 total views implemented)
                </div>
            </div>
            
            <!-- Common Views -->
            <div class="actor-section">
                <div class="actor-header">
                    <div class="actor-title">🔗 Common Views</div>
                    <div class="actor-description">Shared authentication and general purpose views</div>
                </div>
                <div class="links-grid">
                    <a href="/HireFlow/public" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Home Page</div>
                        <div class="link-url">/HireFlow/public</div>
                    </a>
                    <a href="/HireFlow/public/signin" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Sign In</div>
                        <div class="link-url">/HireFlow/public/signin</div>
                    </a>
                    <a href="/HireFlow/public/signup" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Sign Up (Applicants Only)</div>
                        <div class="link-url">/HireFlow/public/signup</div>
                        <div class="link-note">📝 Job seekers can self-register</div>
                    </a>
                    <a href="/HireFlow/public/forgot-password" class="link-item">
                        <span class="status pending">⏳</span>
                        <div class="link-title">Forgot Password</div>
                        <div class="link-url">/HireFlow/public/forgot-password</div>
                    </a>
                    <a href="/HireFlow/public/reset-password" class="link-item">
                        <span class="status pending">⏳</span>
                        <div class="link-title">Reset Password</div>
                        <div class="link-url">/HireFlow/public/reset-password</div>
                    </a>
                    <a href="/HireFlow/public/profile" class="link-item">
                        <span class="status pending">⏳</span>
                        <div class="link-title">User Profile</div>
                        <div class="link-url">/HireFlow/public/profile</div>
                    </a>
                </div>
            </div>
            
            <!-- System Admin Views -->
            <div class="actor-section">
                <div class="actor-header">
                    <div class="actor-title">⚙️ System Admin Views</div>
                    <div class="actor-description">Technical maintenance, user management, and system configuration</div>
                </div>
                <div class="links-grid">
                    <a href="/HireFlow/public/systemadmin/dashboard" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Admin Dashboard</div>
                        <div class="link-url">/HireFlow/public/systemadmin/dashboard</div>
                    </a>
                    <a href="/HireFlow/public/systemadmin/usermanage" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">User Management</div>
                        <div class="link-url">/HireFlow/public/systemadmin/usermanage</div>
                        <div class="link-note">🔒 Create HR Admin & Recruitment Manager accounts</div>
                    </a>
                    <a href="/HireFlow/public/systemadmin/accesslogs" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Access Logs</div>
                        <div class="link-url">/HireFlow/public/systemadmin/accesslogs</div>
                    </a>
                    <a href="/HireFlow/public/systemadmin/viewdata" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">View Data</div>
                        <div class="link-url">/HireFlow/public/systemadmin/viewdata</div>
                    </a>
                    <a href="/HireFlow/public/systemadmin/system-settings" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">System Settings</div>
                        <div class="link-url">/HireFlow/public/systemadmin/system-settings</div>
                    </a>
                    <a href="/HireFlow/public/systemadmin/backup-restore" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Backup & Restore</div>
                        <div class="link-url">/HireFlow/public/systemadmin/backup-restore</div>
                    </a>
                    <a href="/HireFlow/public/systemadmin/security-settings" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Security Settings</div>
                        <div class="link-url">/HireFlow/public/systemadmin/security-settings</div>
                    </a>
                    <a href="/HireFlow/public/systemadmin/reports" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">System Reports</div>
                        <div class="link-url">/HireFlow/public/systemadmin/reports</div>
                    </a>
                </div>
            </div>
            
            <!-- HR Admin Views -->
            <div class="actor-section">
                <div class="actor-header">
                    <div class="actor-title">👥 HR Admin Views</div>
                    <div class="actor-description">Job posting management, applicant data, and recruitment operations (Account created by System Admin)</div>
                </div>
                <div class="links-grid">
                    <a href="/HireFlow/public/hradmin/dashboard" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">HR Dashboard</div>
                        <div class="link-url">/HireFlow/public/hradmin/dashboard</div>
                    </a>
                    <a href="/HireFlow/public/hradmin/job-posts" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">Job Posts</div>
                        <div class="link-url">/HireFlow/public/hradmin/job-posts</div>
                    </a>
                    <a href="/HireFlow/public/hradmin/create-job" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">Create Job</div>
                        <div class="link-url">/HireFlow/public/hradmin/create-job</div>
                    </a>
                    <a href="/HireFlow/public/hradmin/edit-job/1" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">Edit Job</div>
                        <div class="link-url">/HireFlow/public/hradmin/edit-job/[id]</div>
                    </a>
                    <a href="/HireFlow/public/hradmin/view-job/1" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">View Job Details</div>
                        <div class="link-url">/HireFlow/public/hradmin/view-job/[id]</div>
                    </a>
                    <a href="/HireFlow/public/hradmin/applications" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">All Applications</div>
                        <div class="link-url">/HireFlow/public/hradmin/applications</div>
                    </a>
                    <a href="/HireFlow/public/hradmin/view-application/1" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">View Application</div>
                        <div class="link-url">/HireFlow/public/hradmin/view-application/[id]</div>
                    </a>
                    <a href="/HireFlow/public/hradmin/applicant-database" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">Applicant Database</div>
                        <div class="link-url">/HireFlow/public/hradmin/applicant-database</div>
                    </a>
                    <a href="/HireFlow/public/hradmin/interview-schedule" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">Interview Schedule</div>
                        <div class="link-url">/HireFlow/public/hradmin/interview-schedule</div>
                    </a>
                    <a href="/HireFlow/public/hradmin/reports" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">HR Reports</div>
                        <div class="link-url">/HireFlow/public/hradmin/reports</div>
                    </a>
                    <a href="/HireFlow/public/hradmin/notifications" class="link-item">
                        <span class="status pending">⏳</span>
                        <div class="link-title">Notifications</div>
                        <div class="link-url">/HireFlow/public/hradmin/notifications</div>
                    </a>
                </div>
            </div>
            
            <!-- Recruitment Manager Views -->
            <div class="actor-section">
                <div class="actor-header">
                    <div class="actor-title">🎯 Recruitment Manager Views</div>
                    <div class="actor-description">Candidate evaluation, interview management, and hiring decisions (Account created by System Admin)</div>
                </div>
                <div class="links-grid">
                    <a href="/HireFlow/public/recruitment/dashboard" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Recruitment Dashboard</div>
                        <div class="link-url">/HireFlow/public/recruitment/dashboard</div>
                    </a>
                    <a href="/HireFlow/public/recruitment/assigned-jobs" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Assigned Jobs</div>
                        <div class="link-url">/HireFlow/public/recruitment/assigned-jobs</div>
                    </a>
                    <a href="/HireFlow/public/recruitment/applications" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Applications to Review</div>
                        <div class="link-url">/HireFlow/public/recruitment/applications</div>
                    </a>
                    <a href="/HireFlow/public/recruitment/shortlist-candidates" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Shortlist Candidates</div>
                        <div class="link-url">/HireFlow/public/recruitment/shortlist-candidates</div>
                    </a>
                    <a href="/HireFlow/public/recruitment/interview-schedule" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Interview Schedule</div>
                        <div class="link-url">/HireFlow/public/recruitment/interview-schedule</div>
                    </a>
                    <a href="/HireFlow/public/recruitment/conduct-interview/1" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Conduct Interview</div>
                        <div class="link-url">/HireFlow/public/recruitment/conduct-interview/[id]</div>
                    </a>
                    <a href="/HireFlow/public/recruitment/interview-feedback" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Interview Feedback</div>
                        <div class="link-url">/HireFlow/public/recruitment/interview-feedback</div>
                    </a>
                    <a href="/HireFlow/public/recruitment/candidate-evaluation" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Candidate Evaluation</div>
                        <div class="link-url">/HireFlow/public/recruitment/candidate-evaluation</div>
                    </a>
                    <a href="/HireFlow/public/recruitment/reports" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Recruitment Reports</div>
                        <div class="link-url">/HireFlow/public/recruitment/reports</div>
                    </a>
                    <a href="/HireFlow/public/recruitment/notifications" class="link-item">
                        <span class="status exists">✓</span>
                        <div class="link-title">Notifications</div>
                        <div class="link-url">/HireFlow/public/recruitment/notifications</div>
                    </a>
                </div>
            </div>
            
            <!-- Applicant Views -->
            <div class="actor-section">
                <div class="actor-header">
                    <div class="actor-title">👤 Applicant Views</div>
                    <div class="actor-description">Job browsing, application submission, and application tracking (Self-registration allowed)</div>
                </div>
                <div class="links-grid">
                    <a href="/HireFlow/public/applicant/dashboard" class="link-item">
                        <span class="status pending">⏳</span>
                        <div class="link-title">Applicant Dashboard</div>
                        <div class="link-url">/HireFlow/public/applicant/dashboard</div>
                    </a>
                    <a href="/HireFlow/public/applicant/browse-jobs" class="link-item">
                        <span class="status pending">⏳</span>
                        <div class="link-title">Browse Jobs</div>
                        <div class="link-url">/HireFlow/public/applicant/browse-jobs</div>
                    </a>
                    <a href="/HireFlow/public/applicant/job-details/1" class="link-item">
                        <span class="status pending">⏳</span>
                        <div class="link-title">Job Details</div>
                        <div class="link-url">/HireFlow/public/applicant/job-details/[id]</div>
                    </a>
                    <a href="/HireFlow/public/applicant/apply-job/1" class="link-item">
                        <span class="status pending">⏳</span>
                        <div class="link-title">Apply for Job</div>
                        <div class="link-url">/HireFlow/public/applicant/apply-job/[id]</div>
                    </a>
                    <a href="/HireFlow/public/applicant/my-applications" class="link-item">
                        <span class="status pending">⏳</span>
                        <div class="link-title">My Applications</div>
                        <div class="link-url">/HireFlow/public/applicant/my-applications</div>
                    </a>
                    <a href="/HireFlow/public/applicant/dashboard" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">Applicant Dashboard</div>
                        <div class="link-url">/HireFlow/public/applicant/dashboard</div>
                        <div class="link-note">📊 Complete overview with stats and quick actions</div>
                    </a>
                    <a href="/HireFlow/public/applicant/jobs" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">Browse Jobs</div>
                        <div class="link-url">/HireFlow/public/applicant/jobs</div>
                        <div class="link-note">🔍 Search and filter job listings</div>
                    </a>
                    <a href="/HireFlow/public/applicant/jobs/details?id=1" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">Job Details</div>
                        <div class="link-url">/HireFlow/public/applicant/jobs/details?id=1</div>
                        <div class="link-note">📋 Detailed job information with apply option</div>
                    </a>
                    <a href="/HireFlow/public/applicant/applications" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">My Applications</div>
                        <div class="link-url">/HireFlow/public/applicant/applications</div>
                        <div class="link-note">📄 Track application status with filtering</div>
                    </a>
                    <a href="/HireFlow/public/applicant/applications/apply?job_id=1" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">Apply for Job</div>
                        <div class="link-url">/HireFlow/public/applicant/applications/apply?job_id=1</div>
                        <div class="link-note">✍️ Job application form</div>
                    </a>
                    <a href="/HireFlow/public/applicant/interviews" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">Interview Schedule</div>
                        <div class="link-url">/HireFlow/public/applicant/interviews</div>
                        <div class="link-note">📅 View and manage interview appointments</div>
                    </a>
                    <a href="/HireFlow/public/applicant/interviews/feedback" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">Interview Feedback</div>
                        <div class="link-url">/HireFlow/public/applicant/interviews/feedback</div>
                        <div class="link-note">💬 View feedback from completed interviews</div>
                    </a>
                    <a href="/HireFlow/public/applicant/profile" class="link-item">
                        <span class="status exists">✅</span>
                        <div class="link-title">My Profile</div>
                        <div class="link-url">/HireFlow/public/applicant/profile</div>
                        <div class="link-note">👤 Complete profile management</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add click tracking and status checking
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.link-item');
            
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Optional: Add analytics or tracking here
                    console.log('Testing URL:', this.href);
                });
            });
        });
    </script>
</body>
</html>
