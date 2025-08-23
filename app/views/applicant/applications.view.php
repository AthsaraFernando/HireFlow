<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/applications.style.css">
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
                <h1 class="page-title">My Applications</h1>
                <p class="page-subtitle">Track the status of your job applications</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name">John Doe</span>
                    <div class="user-avatar">JD</div>
                </div>
            </div>
        </header>

        <div class="applications-content">
            <!-- Filter and Search Section -->
            <div class="filter-section">
                <div class="filter-container">
                    <div class="search-box">
                        <input type="text" placeholder="Search applications..." class="search-input">
                        <button class="search-btn">🔍</button>
                    </div>
                    <div class="filter-options">
                        <select class="filter-select">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="shortlisted">Shortlisted</option>
                            <option value="rejected">Rejected</option>
                            <option value="interview-scheduled">Interview Scheduled</option>
                            <option value="under-review">Under Review</option>
                        </select>
                        <select class="filter-select">
                            <option value="">Sort by</option>
                            <option value="date-desc">Latest First</option>
                            <option value="date-asc">Oldest First</option>
                            <option value="company">Company Name</option>
                            <option value="status">Status</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Applications Summary -->
            <div class="summary-section">
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-icon">📊</div>
                        <div class="summary-info">
                            <h3><?= count($applications) ?></h3>
                            <p>Total Applications</p>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-icon">⏳</div>
                        <div class="summary-info">
                            <h3><?= count(array_filter($applications, function($app) { return $app['status'] === 'Pending'; })) ?></h3>
                            <p>Pending Review</p>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-icon">✅</div>
                        <div class="summary-info">
                            <h3><?= count(array_filter($applications, function($app) { return $app['status'] === 'Shortlisted'; })) ?></h3>
                            <p>Shortlisted</p>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-icon">🎤</div>
                        <div class="summary-info">
                            <h3><?= count(array_filter($applications, function($app) { return $app['status'] === 'Interview Scheduled'; })) ?></h3>
                            <p>Interviews</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications List -->
            <div class="applications-list">
                <?php if (!empty($applications)): ?>
                    <?php foreach ($applications as $application): ?>
                        <div class="application-card">
                            <div class="application-header">
                                <div class="application-title-section">
                                    <h3 class="job-title"><?= $application['job_title'] ?></h3>
                                    <p class="company-name"><?= $application['company'] ?></p>
                                    <p class="application-id">ID: <?= $application['application_id'] ?></p>
                                </div>
                                <div class="application-status-section">
                                    <span class="status-badge <?= $application['status_color'] ?>">
                                        <?= $application['status'] ?>
                                    </span>
                                </div>
                            </div>

                            <div class="application-details">
                                <div class="detail-row">
                                    <div class="detail-item">
                                        <span class="detail-label">📅 Applied Date:</span>
                                        <span class="detail-value"><?= date('M d, Y', strtotime($application['applied_date'])) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">🔄 Last Updated:</span>
                                        <span class="detail-value"><?= date('M d, Y', strtotime($application['last_updated'])) ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="application-actions">
                                <div class="action-buttons">
                                    <?php if ($application['status'] === 'Pending' || $application['status'] === 'Under Review'): ?>
                                        <a href="<?= ROOT ?>/applicant/applications/withdraw?id=<?= $application['id'] ?>" 
                                           class="btn btn-outline btn-danger" 
                                           onclick="return confirm('Are you sure you want to withdraw this application?')">
                                            Withdraw Application
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($application['status'] === 'Interview Scheduled'): ?>
                                        <a href="<?= ROOT ?>/applicant/interviews" class="btn btn-primary">
                                            View Interview Details
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($application['status'] === 'Shortlisted'): ?>
                                        <span class="status-info">🎉 Congratulations! You've been shortlisted.</span>
                                    <?php endif; ?>
                                    
                                    <?php if ($application['status'] === 'Rejected'): ?>
                                        <a href="<?= ROOT ?>/applicant/interviews/feedback" class="btn btn-outline">
                                            View Feedback
                                        </a>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="application-timeline">
                                    <div class="timeline-item completed">
                                        <div class="timeline-marker"></div>
                                        <span>Application Submitted</span>
                                    </div>
                                    
                                    <?php if ($application['status'] !== 'Pending'): ?>
                                        <div class="timeline-item completed">
                                            <div class="timeline-marker"></div>
                                            <span>Under Review</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($application['status'] === 'Shortlisted' || $application['status'] === 'Interview Scheduled'): ?>
                                        <div class="timeline-item completed">
                                            <div class="timeline-marker"></div>
                                            <span>Shortlisted</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($application['status'] === 'Interview Scheduled'): ?>
                                        <div class="timeline-item current">
                                            <div class="timeline-marker"></div>
                                            <span>Interview Scheduled</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($application['status'] === 'Rejected'): ?>
                                        <div class="timeline-item rejected">
                                            <div class="timeline-marker"></div>
                                            <span>Application Rejected</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">📄</div>
                        <h3>No Applications Yet</h3>
                        <p>You haven't applied for any jobs yet. Start exploring opportunities!</p>
                        <a href="<?= ROOT ?>/applicant/jobs" class="btn btn-primary">Browse Jobs</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="page-btn" disabled>← Previous</button>
                <span class="page-info">Page 1 of 1</span>
                <button class="page-btn" disabled>Next →</button>
            </div>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/applicant/applications.js"></script>
</body>

</html>
