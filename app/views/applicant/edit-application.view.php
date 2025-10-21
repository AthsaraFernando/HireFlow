<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application - HireFlow</title>
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
                    <a href="<?= ROOT ?>/applicant/applications" class="breadcrumb-link">My Applications</a>
                    <span class="breadcrumb-separator">›</span>
                    <span class="breadcrumb-current">Edit Application</span>
                </div>
                <h1 class="page-title">Edit Application for <?= $application['job_title'] ?></h1>
                <p class="page-subtitle"><?= $application['company'] ?> • <?= $application['location'] ?></p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name"><?= $user['name'] ?? 'User' ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="apply-content">
            <div class="apply-main">
                <!-- Application Edit Form -->
                <div class="form-card">
                    <h3>Update Application Details</h3>
                    
                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-error">
                            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form id="editApplicationForm" class="application-form" method="POST" action="<?= ROOT ?>/applicant/editApplication/<?= $application['id'] ?>" enctype="multipart/form-data">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Cover Letter *</label>
                                <textarea name="cover_letter" class="form-input" rows="6" placeholder="Write a compelling cover letter explaining why you're perfect for this role..." required><?= htmlspecialchars($application['cover_letter']) ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Current Resume</label>
                                <div style="margin-bottom: 10px;">
                                    <a href="<?= ROOT . $application['resume_path'] ?>" target="_blank" class="btn btn-outline" style="display: inline-block;">
                                        📄 View Current Resume
                                    </a>
                                </div>
                                <label>Upload New Resume (Optional - PDF only)</label>
                                <div class="file-upload">
                                    <input type="file" name="resume" id="resume" accept=".pdf">
                                    <label for="resume" class="file-upload-label">
                                        <span class="upload-icon">📄</span>
                                        <span id="resumeLabel">Choose New Resume (PDF only, max 5MB)</span>
                                    </label>
                                </div>
                                <small style="display: block; margin-top: 5px; color: #666;">Leave empty to keep current resume. Only PDF files are accepted.</small>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <a href="<?= ROOT ?>/applicant/applications" class="btn btn-outline">Cancel</a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Update Application</button>
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
                        <div class="company-logo"><?= strtoupper(substr($application['company'], 0, 2)) ?></div>
                        <div class="job-info">
                            <h5><?= $application['job_title'] ?></h5>
                            <p><?= $application['company'] ?></p>
                            <p>📍 <?= $application['location'] ?></p>
                            <p>💰 <?= $application['salary'] ?></p>
                        </div>
                    </div>
                </div>

                <!-- Update Tips -->
                <div class="sidebar-card">
                    <h4>Update Tips</h4>
                    <div class="tips-list">
                        <div class="tip-item">
                            <span class="tip-icon">✅</span>
                            <span>Review and improve your cover letter</span>
                        </div>
                        <div class="tip-item">
                            <span class="tip-icon">✅</span>
                            <span>Update resume only if you have significant changes</span>
                        </div>
                        <div class="tip-item">
                            <span class="tip-icon">✅</span>
                            <span>Ensure all information is accurate and up-to-date</span>
                        </div>
                        <div class="tip-item">
                            <span class="tip-icon">⚠️</span>
                            <span>You can only edit applications that haven't been shortlisted</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form validation
        document.getElementById('editApplicationForm').addEventListener('submit', function(e) {
            const resumeInput = document.getElementById('resume');
            const submitBtn = document.getElementById('submitBtn');
            
            // Validate file size and type if new resume is uploaded
            if (resumeInput.files.length > 0) {
                const fileSize = resumeInput.files[0].size;
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                
                if (fileSize > maxSize) {
                    e.preventDefault();
                    alert('Resume file size must be less than 5MB. Please choose a smaller file.');
                    return false;
                }
                
                // Validate PDF file type
                const fileName = resumeInput.files[0].name;
                if (!fileName.toLowerCase().endsWith('.pdf')) {
                    e.preventDefault();
                    alert('Only PDF files are allowed for resume upload.');
                    return false;
                }
            }
            
            // Disable submit button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.textContent = 'Updating...';
        });
        
        // File upload feedback
        document.getElementById('resume').addEventListener('change', function() {
            const label = document.getElementById('resumeLabel');
            if (this.files.length > 0) {
                const file = this.files[0];
                const fileSize = (file.size / (1024 * 1024)).toFixed(2); // Convert to MB
                label.textContent = `${file.name} (${fileSize} MB)`;
            } else {
                label.textContent = 'Choose New Resume (PDF only, max 5MB)';
            }
        });
    </script>
</body>

</html>
