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
                    <a href="<?= ROOT ?>/recruitment/reports" class="nav-link">
                        <span class="nav-text">Reports</span>
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
                <a href="<?= ROOT ?>/announcements" class="btn btn-secondary">Announcements</a>
                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">Recruitment Manager</span>
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
            <a href="<?= ROOT ?>/recruitment/interview-schedule" class="btn btn-primary">Create Interviews</a>
            <a href="<?= ROOT ?>/recruitment/reports" class="btn btn-outline">Create Report</a>
            <a href="<?= ROOT ?>/recruitment/applicationforms" class="btn btn-secondary">Create Application Form</a>
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
        <div class="metric-card warning">
            <div class="metric-info">
                <div class="metric-value"><?= $metrics['under_review_applications'] ?? 0 ?></div>
                <div class="metric-label">Applications Under Review</div>
            </div>
        </div>

        <div class="metric-card success">
            <div class="metric-info">
                <div class="metric-value"><?= $metrics['shortlisted_applications'] ?? 0 ?></div>
                <div class="metric-label">Shortlisted Applications</div>
            </div>
        </div>

        <div class="metric-card info">
            <div class="metric-info">
                <div class="metric-value"><?= $metrics['interview_scheduled_applications'] ?? 0 ?></div>
                <div class="metric-label">Interview Scheduled</div>
            </div>
        </div>

    </div>

    <!-- Main Content Layout -->
    <div class="dashboard-content">
        <div class="content-column">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">Upcoming Interviews</h3>
                    <a href="<?= ROOT ?>/recruitment/interview-schedule" class="view-all-link">Manage All</a>
                </div>
                <div class="interviews-list">
                    <?php if(!empty($upcoming_interviews)): ?>
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
                                    <span class="interview-type"><?= htmlspecialchars($interview['type']) ?></span>
                                </div>
                            </div>
                            <div class="interview-actions">
                                <span class="interview-status <?= strtolower($interview['status']) ?>"><?= ucfirst($interview['status']) ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty-state">No upcoming interviews.</p>
                    <?php endif; ?>
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
