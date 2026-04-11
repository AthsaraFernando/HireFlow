<?php $this->view('components/header') ?>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">Recruitment Manager</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/dashboard" class="nav-link active">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/applicationforms" class="nav-link">
                        <span class="nav-text">Application Forms</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/applications" class="nav-link">
                        <span class="nav-text">Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/shortlist-candidates" class="nav-link">
                        <span class="nav-text">Shortlist</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/interview-schedule" class="nav-link">
                        <span class="nav-text">Interviews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/candidate-evaluation" class="nav-link">
                        <span class="nav-text">Evaluations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/reports" class="nav-link">
                        <span class="nav-text">Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/notifications" class="nav-link">
                        <span class="nav-text">Notifications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/profile" class="nav-link">
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
        <header class="top-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <
                </button>
                <h1 class="page-title">Recruitment Dashboard</h1>
            </div>

            <div class="header-right">
                <div class="header-notifications">
                    <button class="notification-btn"></button>
                </div>

                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">Recruitment Manager</span>
                    </div>
                    <div class="user-avatar">
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="main-container">
    <!-- Header Section -->
    <div class="header-section">
        <h1 class="page-title">Recruitment Dashboard</h1>
        <p class="page-description">Overview of your recruitment activities and pending tasks</p>
        <div class="quick-actions">
            <a href="<?= ROOT ?>/recruitment/applications" class="btn btn-primary">
                <i class="icon-applications"></i>Review Applications
            </a>
            <a href="<?= ROOT ?>/recruitment/interview-schedule" class="btn btn-outline">
                <i class="icon-calendar"></i>Schedule Interview
            </a>
            <a href="<?= ROOT ?>/recruitment/shortlist-candidates" class="btn btn-secondary">
                <i class="icon-users"></i>Manage Shortlist
            </a>
        </div>
    </div>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach($errors as $error): ?>
                <p><?php echo $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Dashboard Metrics -->
    <div class="metrics-overview">
        <div class="metric-card primary">
            <div class="metric-icon">📋</div>
            <div class="metric-info">
                <div class="metric-value"><?= $metrics['assigned_jobs'] ?></div>
                <div class="metric-label">Assigned Jobs</div>
            </div>
            <a href="<?= ROOT ?>/recruitment/assigned-jobs" class="metric-action">View All</a>
        </div>

        <div class="metric-card warning">
            <div class="metric-icon">📄</div>
            <div class="metric-info">
                <div class="metric-value"><?= $metrics['pending_applications'] ?></div>
                <div class="metric-label">Pending Reviews</div>
            </div>
            <a href="<?= ROOT ?>/recruitment/applications" class="metric-action">Review</a>
        </div>

        <div class="metric-card success">
            <div class="metric-icon">🎯</div>
            <div class="metric-info">
                <div class="metric-value"><?= $metrics['shortlisted_candidates'] ?></div>
                <div class="metric-label">Shortlisted</div>
            </div>
            <a href="<?= ROOT ?>/recruitment/shortlist-candidates" class="metric-action">Manage</a>
        </div>

        <div class="metric-card info">
            <div class="metric-icon">📅</div>
            <div class="metric-info">
                <div class="metric-value"><?= $metrics['scheduled_interviews'] ?></div>
                <div class="metric-label">Interviews Scheduled</div>
            </div>
            <a href="<?= ROOT ?>/recruitment/interview-schedule" class="metric-action">View</a>
        </div>

        <div class="metric-card danger">
            <div class="metric-icon">⏰</div>
            <div class="metric-info">
                <div class="metric-value"><?= $metrics['pending_feedback'] ?></div>
                <div class="metric-label">Pending Feedback</div>
            </div>
            <a href="<?= ROOT ?>/recruitment/interview-feedback" class="metric-action">Submit</a>
        </div>

        <div class="metric-card secondary">
            <div class="metric-icon">✅</div>
            <div class="metric-info">
                <div class="metric-value"><?= $metrics['candidates_evaluated'] ?></div>
                <div class="metric-label">Evaluated</div>
            </div>
            <a href="<?= ROOT ?>/recruitment/candidate-evaluation" class="metric-action">View</a>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="dashboard-content">
        <!-- Left Column -->
        <div class="content-column">
            <!-- Assigned Jobs Summary -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">My Assigned Jobs</h3>
                    <a href="<?= ROOT ?>/recruitment/assigned-jobs" class="view-all-link">View All</a>
                </div>
                <div class="jobs-list">
                    <?php foreach($assigned_jobs as $job): ?>
                    <div class="job-item">
                        <div class="job-info">
                            <h4 class="job-title"><?= htmlspecialchars($job['title']) ?></h4>
                            <span class="job-department"><?= htmlspecialchars($job['department']) ?></span>
                        </div>
                        <div class="job-stats">
                            <span class="stat-item">
                                <strong><?= $job['applications_count'] ?></strong> Applications
                            </span>
                            <span class="stat-item pending">
                                <strong><?= $job['pending_reviews'] ?></strong> Pending
                            </span>
                        </div>
                        <div class="job-actions">
                            <a href="<?= ROOT ?>/recruitment/applications?job=<?= $job['id'] ?>" class="btn btn-sm btn-primary">Review</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">Recent Activities</h3>
                    <a href="<?= ROOT ?>/recruitment/notifications" class="view-all-link">View All</a>
                </div>
                <div class="activities-list">
                    <?php foreach($recent_activities as $activity): ?>
                    <div class="activity-item <?= $activity['priority'] ?>">
                        <div class="activity-icon">
                            <?php 
                            switch($activity['type']) {
                                case 'application_review': echo '📋'; break;
                                case 'interview_scheduled': echo '📅'; break;
                                case 'candidate_shortlisted': echo '⭐'; break;
                                default: echo '🔔'; break;
                            }
                            ?>
                        </div>
                        <div class="activity-content">
                            <p class="activity-description"><?= htmlspecialchars($activity['description']) ?></p>
                            <span class="activity-time"><?= $activity['time'] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="content-column">
            <!-- Upcoming Interviews -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">Upcoming Interviews</h3>
                    <a href="<?= ROOT ?>/recruitment/interview-schedule" class="view-all-link">Manage All</a>
                </div>
                <div class="interviews-list">
                    <?php foreach($upcoming_interviews as $interview): ?>
                    <div class="interview-card">
                        <div class="interview-time">
                            <div class="date"><?= date('M j', strtotime($interview['scheduled_time'])) ?></div>
                            <div class="time"><?= date('g:i A', strtotime($interview['scheduled_time'])) ?></div>
                        </div>
                        <div class="interview-details">
                            <h3><?= htmlspecialchars($interview['candidate_name']) ?></h3>
                            <p><?= htmlspecialchars($interview['position']) ?></p>
                            <div class="interview-meta">
                                <span class="interview-type"><?= $interview['type'] ?></span>
                                <span class="duration">45 min</span>
                            </div>
                        </div>
                        <div class="interview-actions">
                            <span class="interview-status <?= strtolower($interview['status']) ?>"><?= ucfirst($interview['status']) ?></span>
                            <a href="<?= ROOT ?>/recruitment/conduct-interview/1" class="btn btn-sm btn-primary">Join</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="quick-actions-grid">
                    <a href="<?= ROOT ?>/recruitment/applications" class="quick-action-item">
                        <div class="action-icon">📋</div>
                        <div class="action-label">Review Applications</div>
                        <div class="action-count"><?= $metrics['pending_applications'] ?> pending</div>
                    </a>
                    <a href="<?= ROOT ?>/recruitment/shortlist-candidates" class="quick-action-item">
                        <div class="action-icon">⭐</div>
                        <div class="action-label">Manage Shortlist</div>
                        <div class="action-count"><?= $metrics['shortlisted_candidates'] ?> candidates</div>
                    </a>
                    <a href="<?= ROOT ?>/recruitment/interview-feedback" class="quick-action-item">
                        <div class="action-icon">💬</div>
                        <div class="action-label">Submit Feedback</div>
                        <div class="action-count"><?= $metrics['pending_feedback'] ?> pending</div>
                    </a>
                    <a href="<?= ROOT ?>/recruitment/reports" class="quick-action-item">
                        <div class="action-icon">📊</div>
                        <div class="action-label">View Reports</div>
                        <div class="action-count">Analytics</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

<script>
// Sidebar toggle functionality
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('collapsed');
    document.querySelector('.main-content').classList.toggle('expanded');
});

document.querySelector('.sidebar-toggle').addEventListener('click', function (e) {
    if (e.target.textContent.trim() === ">") {
        e.target.textContent = "<";
    } else {
        e.target.textContent = ">";
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPath)) {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        }
    });
});
</script>

        </div>
    </div>

<?php $this->view('components/footer') ?>
