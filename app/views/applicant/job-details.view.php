<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/job-details.style.css">
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
                    <a href="<?= ROOT ?>/applicant/jobs" class="nav-link active">
                        <span class="nav-text">Browse Jobs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/applications" class="nav-link">
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
                    <a href="<?= ROOT ?>/applicant/jobs">Browse Jobs</a>
                    <span>›</span>
                    <span>Job Details</span>
                </div>
                <h1 class="page-title"><?= $job['title'] ?></h1>
                <p class="page-subtitle"><?= $job['company'] ?></p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name">John Doe</span>
                    <div class="user-avatar">JD</div>
                </div>
            </div>
        </header>

        <div class="job-details-content">
            <div class="job-details-grid">
                <!-- Main Job Information -->
                <div class="job-main-info">
                    <div class="job-overview-card">
                        <div class="job-header">
                            <div class="job-title-section">
                                <h2><?= $job['title'] ?></h2>
                                <p class="company"><?= $job['company'] ?></p>
                            </div>
                            <div class="apply-section">
                                <a href="<?= ROOT ?>/applicant/applications/apply?job_id=<?= $job['id'] ?>" class="btn btn-primary btn-large">
                                    Apply Now
                                </a>
                            </div>
                        </div>

                        <div class="job-quick-info">
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-label">📍 Location</span>
                                    <span class="info-value"><?= $job['location'] ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">💼 Job Type</span>
                                    <span class="info-value"><?= $job['type'] ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">💰 Salary</span>
                                    <span class="info-value"><?= $job['salary'] ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">🏢 Department</span>
                                    <span class="info-value"><?= $job['department'] ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">📈 Experience</span>
                                    <span class="info-value"><?= $job['experience_level'] ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">📅 Deadline</span>
                                    <span class="info-value deadline"><?= date('M d, Y', strtotime($job['deadline'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="content-card">
                        <h3>Job Description</h3>
                        <div class="content-body">
                            <p><?= $job['description'] ?></p>
                        </div>
                    </div>

                    <!-- Responsibilities -->
                    <div class="content-card">
                        <h3>Key Responsibilities</h3>
                        <div class="content-body">
                            <ul class="responsibilities-list">
                                <?php foreach ($job['responsibilities'] as $responsibility): ?>
                                    <li><?= $responsibility ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Requirements -->
                    <div class="content-card">
                        <h3>Requirements</h3>
                        <div class="content-body">
                            <ul class="requirements-list">
                                <?php foreach ($job['requirements'] as $requirement): ?>
                                    <li><?= $requirement ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div class="content-card">
                        <h3>Benefits & Perks</h3>
                        <div class="content-body">
                            <ul class="benefits-list">
                                <?php foreach ($job['benefits'] as $benefit): ?>
                                    <li><?= $benefit ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="job-sidebar">
                    <!-- Application Status -->
                    <div class="sidebar-card">
                        <h4>Application Status</h4>
                        <div class="application-status">
                            <div class="status-badge not-applied">
                                Not Applied
                            </div>
                            <p class="status-text">You haven't applied for this position yet.</p>
                        </div>
                    </div>

                    <!-- Company Information -->
                    <div class="sidebar-card">
                        <h4>About <?= $job['company'] ?></h4>
                        <div class="company-info">
                            <p>Tech Solutions Inc. is a leading technology company specializing in innovative software solutions for businesses worldwide. We pride ourselves on creating cutting-edge applications and fostering a collaborative work environment.</p>
                            <div class="company-stats">
                                <div class="stat">
                                    <span class="stat-number">500+</span>
                                    <span class="stat-label">Employees</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-number">2010</span>
                                    <span class="stat-label">Founded</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Similar Jobs -->
                    <div class="sidebar-card">
                        <h4>Similar Jobs</h4>
                        <div class="similar-jobs">
                            <div class="similar-job-item">
                                <h5>Frontend Developer</h5>
                                <p>Creative Minds Ltd.</p>
                                <span class="job-type">Full-time</span>
                            </div>
                            <div class="similar-job-item">
                                <h5>Full Stack Developer</h5>
                                <p>Innovation Hub</p>
                                <span class="job-type">Full-time</span>
                            </div>
                            <div class="similar-job-item">
                                <h5>Backend Developer</h5>
                                <p>Code Masters</p>
                                <span class="job-type">Contract</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="sidebar-card">
                        <h4>Quick Actions</h4>
                        <div class="quick-actions">
                            <a href="<?= ROOT ?>/applicant/applications/apply?job_id=<?= $job['id'] ?>" class="action-btn primary">
                                📝 Apply Now
                            </a>
                            <button class="action-btn secondary" onclick="shareJob()">
                                📤 Share Job
                            </button>
                            <button class="action-btn secondary" onclick="saveJob()">
                                ❤️ Save Job
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Action Bar -->
            <div class="bottom-action-bar">
                <div class="action-bar-content">
                    <div class="job-summary">
                        <h4><?= $job['title'] ?></h4>
                        <p><?= $job['company'] ?> • <?= $job['location'] ?></p>
                    </div>
                    <div class="action-buttons">
                        <a href="<?= ROOT ?>/applicant/jobs" class="btn btn-outline">← Back to Jobs</a>
                        <a href="<?= ROOT ?>/applicant/applications/apply?job_id=<?= $job['id'] ?>" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/applicant/job-details.js"></script>
</body>

</html>
