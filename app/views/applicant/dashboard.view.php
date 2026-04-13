<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/dashboard.style.css">
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
                    <a href="<?= ROOT ?>/applicant/dashboard" class="nav-link active">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/jobs" class="nav-link">
                        <span class="nav-text">Browse Jobs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/applications" class="nav-link">
                        <span class="nav-text">My Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/savedJobs" class="nav-link">
                        <span class="nav-text">Saved Jobs</span>
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
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Welcome back, <?= $user['name'] ?>! Here's your application overview</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name"><?= $user['name'] ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'], 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon total">📊</div>
                    <div class="stat-info">
                        <h3><?= $user['applications_count'] ?></h3>
                        <p>Total Applications</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon shortlisted">✅</div>
                    <div class="stat-info">
                        <h3><?= $user['shortlisted_count'] ?></h3>
                        <p>Shortlisted</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon pending">⏳</div>
                    <div class="stat-info">
                        <h3><?= $user['pending_count'] ?></h3>
                        <p>Pending Review</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon interviews">🎤</div>
                    <div class="stat-info">
                        <h3><?= $user['interviews_count'] ?></h3>
                        <p>Upcoming Interviews</p>
                    </div>
                </div>
            </div>

            <div class="content-grid">
                <!-- Recent Applications -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Recent Applications</h2>
                        <a href="<?= ROOT ?>/applicant/applications" class="view-all-btn">View All</a>
                    </div>
                    <div class="card-content">
                        <?php if (!empty($recent_applications)): ?>
                            <div class="applications-list">
                                <?php foreach ($recent_applications as $application): ?>
                                    <div class="application-item">
                                        <div class="application-info">
                                            <h4><?= $application['job_title'] ?></h4>
                                            <p class="company"><?= $application['company'] ?></p>
                                            <p class="date">Applied: <?= date('M d, Y', strtotime($application['applied_date'])) ?></p>
                                        </div>
                                        <div class="application-status">
                                            <span class="status-badge <?= strtolower(str_replace(' ', '-', $application['status'])) ?>">
                                                <?= ucfirst($application['status']) ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <p>No applications yet. <a href="<?= ROOT ?>/applicant/jobs">Browse jobs</a> to get started!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Upcoming Interviews -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Upcoming Interviews</h2>
                        <a href="<?= ROOT ?>/applicant/interviews" class="view-all-btn">View All</a>
                    </div>
                    <div class="card-content">
                        <?php if (!empty($upcoming_interviews)): ?>
                            <div class="interviews-list">
                                <?php foreach ($upcoming_interviews as $interview): ?>
                                    <div class="interview-item">
                                        <div class="interview-info">
                                            <h4><?= $interview['job_title'] ?></h4>
                                            <p class="company"><?= $interview['company'] ?></p>
                                            <p class="datetime">
                                                📅 <?= date('M d, Y', strtotime($interview['date'])) ?> 
                                                at <?= $interview['time'] ?>
                                            </p>
                                            <p class="type">Type: <?= $interview['type'] ?></p>
                                        </div>
                                        <div class="interview-actions">
                                            <a href="<?= ROOT ?>/applicant/interviews" class="btn btn-primary">View Details</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <p>No upcoming interviews.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Quick Actions</h2>
                    </div>
                    <div class="card-content">
                        <div class="quick-actions">
                            <a href="<?= ROOT ?>/applicant/jobs" class="action-btn">
                                <div class="action-icon">🔍</div>
                                <span>Browse Jobs</span>
                            </a>
                            <a href="<?= ROOT ?>/applicant/profile" class="action-btn">
                                <div class="action-icon">👤</div>
                                <span>Update Profile</span>
                            </a>
                            <a href="<?= ROOT ?>/applicant/applications" class="action-btn">
                                <div class="action-icon">📄</div>
                                <span>My Applications</span>
                            </a>
                            <a href="<?= ROOT ?>/applicant/interviews" class="action-btn">
                                <div class="action-icon">📅</div>
                                <span>Interview Schedule</span>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/applicant/dashboard.js"></script>
</body>

</html>
