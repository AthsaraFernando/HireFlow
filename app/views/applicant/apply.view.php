<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/apply.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">Applicant Portal</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/dashboard" class="nav-link">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/jobs" class="nav-link">
                        <span class="nav-text">Browse Jobs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/applications" class="nav-link active">
                        <span class="nav-text">My Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/interviews" class="nav-link">
                        <span class="nav-text">Interview Schedule</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/interviews/feedback" class="nav-link">
                        <span class="nav-text">Interview Feedback</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/profile" class="nav-link">
                        <span class="nav-text">My Profile</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= ROOT ?>/signout" class="logout-btn">
                <span>Logout</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <header class="header">
            <div class="header-left">
                <div class="breadcrumb">
                    <a href="<?= ROOT ?>/applicant/jobs" class="breadcrumb-link">Browse Jobs</a>
                    <span class="breadcrumb-separator">›</span>
                    <span class="breadcrumb-current">Apply for Job</span>
                </div>
                <h1 class="page-title">Apply for <?= $job['title'] ?></h1>
                <p class="page-subtitle"><?= $job['company'] ?> • <?= $job['location'] ?></p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name">John Smith</span>
                    <div class="user-avatar">JS</div>
                </div>
            </div>
        </header>

        <div class="apply-content">
            <div class="apply-main">
                <!-- Application Form -->
                <div class="form-card">
                    <h3>Application Details</h3>
                    <form id="applicationForm" class="application-form">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Cover Letter *</label>
                                <textarea class="form-input" rows="6" placeholder="Write a compelling cover letter explaining why you're perfect for this role..." required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Expected Salary</label>
                                <input type="text" class="form-input" placeholder="e.g., $80,000 - $100,000">
                            </div>
                            
                            <div class="form-group">
                                <label>Availability</label>
                                <select class="form-input" required>
                                    <option value="">Select availability</option>
                                    <option value="immediate">Immediate</option>
                                    <option value="2-weeks">2 weeks notice</option>
                                    <option value="1-month">1 month notice</option>
                                    <option value="negotiable">Negotiable</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Resume *</label>
                                <div class="file-upload">
                                    <input type="file" id="resume" accept=".pdf,.doc,.docx" required>
                                    <label for="resume" class="file-upload-label">
                                        <span class="upload-icon">📄</span>
                                        <span>Choose Resume (PDF, DOC, DOCX)</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Portfolio/Additional Documents</label>
                                <div class="file-upload">
                                    <input type="file" id="portfolio" multiple>
                                    <label for="portfolio" class="file-upload-label">
                                        <span class="upload-icon">📁</span>
                                        <span>Choose Files (Optional)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <a href="<?= ROOT ?>/applicant/jobs/details?id=<?= $job['id'] ?>" class="btn btn-outline">Back to Job</a>
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="apply-sidebar">
                <!-- Job Info Card -->
                <div class="sidebar-card">
                    <h4>Job Summary</h4>
                    <div class="job-summary">
                        <div class="company-logo"><?= strtoupper(substr($job['company'], 0, 2)) ?></div>
                        <div class="job-info">
                            <h5><?= $job['title'] ?></h5>
                            <p><?= $job['company'] ?></p>
                            <p>📍 <?= $job['location'] ?></p>
                            <p>💰 <?= $job['salary'] ?></p>
                        </div>
                    </div>
                </div>

                <!-- Application Tips -->
                <div class="sidebar-card">
                    <h4>Application Tips</h4>
                    <div class="tips-list">
                        <div class="tip-item">
                            <span class="tip-icon">✅</span>
                            <span>Tailor your cover letter to the specific role</span>
                        </div>
                        <div class="tip-item">
                            <span class="tip-icon">✅</span>
                            <span>Highlight relevant experience and skills</span>
                        </div>
                        <div class="tip-item">
                            <span class="tip-icon">✅</span>
                            <span>Keep your resume updated and error-free</span>
                        </div>
                        <div class="tip-item">
                            <span class="tip-icon">✅</span>
                            <span>Be honest about your availability</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('applicationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Application submitted successfully! (Demo mode)');
            window.location.href = '<?= ROOT ?>/applicant/applications';
        });
        
        // File upload feedback
        document.getElementById('resume').addEventListener('change', function() {
            const label = this.nextElementSibling.querySelector('span:last-child');
            if (this.files.length > 0) {
                label.textContent = this.files[0].name;
            }
        });
        
        document.getElementById('portfolio').addEventListener('change', function() {
            const label = this.nextElementSibling.querySelector('span:last-child');
            if (this.files.length > 0) {
                label.textContent = `${this.files.length} file(s) selected`;
            }
        });
    </script>
</body>

</html>
