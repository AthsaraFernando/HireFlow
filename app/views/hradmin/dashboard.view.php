<?php $this->view('components/header') ?>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">HR Admin</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/dashboard" class="nav-link active">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/create-job" class="nav-link">
                        <span class="nav-text">Create Job</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/job-posts" class="nav-link">
                        <span class="nav-text">Job Posts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/applicant-database" class="nav-link">
                        <span class="nav-text">Applicants & Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/departments" class="nav-link">
                        <span class="nav-text">Departments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/categories" class="nav-link">
                        <span class="nav-text">Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/reports" class="nav-link">
                        <span class="nav-text">Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/profile" class="nav-link">
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
                <h1 class="page-title">HR Dashboard</h1>
            </div>

            <div class="header-right">
                <a href="<?= ROOT ?>/announcements" class="btn btn-secondary">Announcements</a>
                <div class="header-notifications">
                    <button class="notification-btn"></button>
                </div>

                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">HR Administrator</span>
                    </div>
                    <div class="user-avatar">
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="main-container">
                <div class="hero-section">
                    <div class="hero-content">
                        <h1 class="hero-title">Welcome to HireFlow Dashboard</h1>
                        <p class="hero-description">Manage your recruitment process efficiently with our comprehensive HR tools</p>
                        <div class="hero-stats">
                            <div class="hero-stat">
                                <span class="stat-number" id="hero-active-jobs"><?= (int)($active_jobs ?? 0) ?></span>
                                <span class="stat-label">Active Jobs</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number" id="hero-total-applications"><?= (int)($total_applications ?? 0) ?></span>
                                <span class="stat-label">Applications</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number" id="hero-scheduled-interviews"><?= (int)($scheduled_interviews ?? 0) ?></span>
                                <span class="stat-label">Interviews</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero-actions">
                        <a href="<?= ROOT ?>/hradmin/create-job" class="btn btn-primary">
                            <i class="icon-plus"></i>Create New Job
                        </a>
                        <a href="<?= ROOT ?>/hradmin/applicant-database?tab=applications" class="btn btn-outline">
                            <i class="icon-applications"></i>Review Applications
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

                <?php if(!empty($success)): ?>
                    <div class="alert alert-success">
                        <p><?php echo $success ?></p>
                    </div>
                <?php endif; ?>

    <!-- Key Metrics Cards -->
    <div class="card-grid">
        <div class="metric-card">
            <div class="metric-value" id="metric-total-jobs"><?= (int)($total_jobs ?? 0) ?></div>
            <div class="metric-label">Total Job Posts</div>
            <div class="metric-change positive">Live from database</div>
        </div>
        <div class="metric-card">
            <div class="metric-value" id="metric-active-jobs"><?= (int)($active_jobs ?? 0) ?></div>
            <div class="metric-label">Active Positions</div>
            <div class="metric-change positive">Live from database</div>
        </div>
        <div class="metric-card">
            <div class="metric-value" id="metric-total-applications"><?= (int)($total_applications ?? 0) ?></div>
            <div class="metric-label">Total Applications</div>
            <div class="metric-change positive">Live from database</div>
        </div>
        <div class="metric-card">
            <div class="metric-value" id="metric-scheduled-interviews"><?= (int)($scheduled_interviews ?? 0) ?></div>
            <div class="metric-label">Scheduled Interviews</div>
            <div class="metric-change neutral">This week</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="action-section">
        <div class="action-buttons">
            <a href="<?= ROOT ?>/hradmin/create-job" class="btn btn-primary">
                Create Job Post
            </a>
            <a href="<?= ROOT ?>/hradmin/applicant-database?tab=applications" class="btn btn-secondary">
                Review Applications
            </a>
            <a href="<?= ROOT ?>/hradmin/reports" class="btn btn-secondary">
                View Reports
            </a>
        </div>
    </div>

    <!-- Dashboard Content Grid -->
    <div class="dashboard-grid">
        <!-- Recent Applications -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Recent Applications</h3>
                <a href="<?= ROOT ?>/hradmin/applicant-database?tab=applications" class="view-all-link">View All</a>
            </div>
            <div class="card-content" id="recent-applications-list">
                <?php if(isset($recent_applications) && !empty($recent_applications)): ?>
                    <?php foreach($recent_applications as $application): ?>
                        <div class="recent-item">
                            <div class="item-info">
                                <div class="item-title"><?= htmlspecialchars($application['name']) ?></div>
                                <div class="item-subtitle"><?= htmlspecialchars($application['position']) ?></div>
                            </div>
                            <div class="item-time"><?= htmlspecialchars($application['time']) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">No recent applications</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Active Job Posts -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Active Job Posts</h3>
                <a href="<?= ROOT ?>/hradmin/job-posts" class="view-all-link">Manage All</a>
            </div>
            <div class="card-content" id="active-job-posts-list">
                <?php if(isset($active_job_posts) && !empty($active_job_posts)): ?>
                    <?php foreach($active_job_posts as $job): ?>
                        <div class="job-item">
                            <div class="job-info">
                                <div class="job-title"><?= htmlspecialchars($job['title'] ?? '') ?></div>
                                <div class="job-meta"><?= htmlspecialchars($job['department'] ?? 'General') ?> • <?= (int)($job['applications_count'] ?? 0) ?> applications</div>
                            </div>
                            <div class="job-status active"><?= htmlspecialchars($job['status'] ?? 'Open') ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">No active job posts</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Quick Statistics</h3>
            </div>
            <div class="card-content">
                <div class="stat-row">
                    <span class="stat-label">Applications Today</span>
                    <span class="stat-value" id="quick-applications-today"><?= (int)($quick_stats['applications_today'] ?? 0) ?></span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Pending Reviews</span>
                    <span class="stat-value" id="quick-pending-reviews"><?= (int)($quick_stats['pending_reviews'] ?? 0) ?></span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Interviews This Week</span>
                    <span class="stat-value" id="quick-interviews-week"><?= (int)($quick_stats['interviews_this_week'] ?? 0) ?></span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Offers Extended</span>
                    <span class="stat-value" id="quick-offers-extended"><?= (int)($quick_stats['offers_extended'] ?? 0) ?></span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Avg. Time to Hire</span>
                    <span class="stat-value" id="quick-avg-time-to-hire"><?= (int)($quick_stats['avg_time_to_hire_days'] ?? 0) ?> days</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --background-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    --card-border: #e7e9f3;
    --card-shadow: 0 8px 24px rgba(86, 76, 207, 0.08);
    --hover-shadow: 0 14px 28px rgba(86, 76, 207, 0.14);
    --text-primary: #2f3552;
    --text-secondary: #6d7485;
}

.dashboard-content {
    background: var(--background-gradient);
    min-height: 100vh;
    padding: 1.5rem;
}

.main-container {
    max-width: 1400px;
    margin: 0 auto;
}

.hero-section {
    background: var(--primary-gradient);
    color: #fff;
    border-radius: 18px;
    padding: 2rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 14px 28px rgba(86, 76, 207, 0.22);
}

.hero-content {
    margin-bottom: 1.3rem;
}

.hero-title {
    margin: 0 0 0.55rem;
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
}

.hero-description {
    margin: 0;
    max-width: 760px;
    color: rgba(255, 255, 255, 0.92);
}

.hero-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1rem;
}

.hero-stat {
    background: rgba(255, 255, 255, 0.16);
    border: 1px solid rgba(255, 255, 255, 0.26);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    min-width: 130px;
}

.hero-stat .stat-number {
    display: block;
    font-size: 1.7rem;
    line-height: 1;
    font-weight: 800;
    color: #fff;
}

.hero-stat .stat-label {
    display: block;
    font-size: 0.82rem;
    margin-top: 0.3rem;
    color: rgba(255, 255, 255, 0.9);
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.7rem;
}

.btn {
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.68rem 1.05rem;
    border: none;
    transition: all 0.25s ease;
}

.btn-primary {
    background: #fff;
    color: #5a4ccf;
}

.btn-primary:hover {
    background: #f5f2ff;
    transform: translateY(-1px);
}

.btn-outline {
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.4);
}

.btn-outline:hover {
    background: rgba(255, 255, 255, 0.23);
}

.btn-secondary {
    background: #edf1ff;
    color: #4052b5;
}

.btn-secondary:hover {
    background: #e5ebff;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.metric-card {
    background: #fff;
    border: 1px solid var(--card-border);
    border-radius: 14px;
    padding: 1.15rem;
    box-shadow: var(--card-shadow);
}

.metric-value {
    font-size: 2rem;
    font-weight: 800;
    color: #3d3e8e;
    line-height: 1;
    margin-bottom: 0.35rem;
}

.metric-label {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.metric-change {
    display: inline-block;
    font-size: 0.78rem;
    padding: 0.2rem 0.55rem;
    border-radius: 999px;
    font-weight: 600;
}

.metric-change.positive {
    background: #e9f8ef;
    color: #1f8d56;
}

.metric-change.neutral {
    background: #eef1f7;
    color: #5a647a;
}

.action-section {
    margin-bottom: 1rem;
}

.action-section .action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 0.65rem;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
    gap: 1rem;
}

.dashboard-card {
    background: #fff;
    border: 1px solid var(--card-border);
    border-radius: 14px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    transition: all 0.25s ease;
}

.dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--hover-shadow);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.1rem;
    border-bottom: 1px solid #ececf5;
    background: linear-gradient(135deg, #fafaff 0%, #f4f5ff 100%);
}

.card-header h3 {
    margin: 0;
    color: #3d3e8e;
    font-size: 1.02rem;
}

.view-all-link {
    color: #5a4ccf;
    text-decoration: none;
    font-size: 0.83rem;
    font-weight: 600;
}

.view-all-link:hover {
    text-decoration: underline;
}

.card-content {
    padding: 1rem 1.1rem;
}

.recent-item, .job-item, .interview-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.65rem;
    padding: 0.68rem 0;
    border-bottom: 1px solid #f0f1f8;
}

.recent-item:last-child, .job-item:last-child, .interview-item:last-child {
    border-bottom: none;
}

.item-title, .job-title, .candidate {
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.2rem;
}

.item-subtitle, .job-meta, .item-time, .position, .interview-time .date {
    color: var(--text-secondary);
    font-size: 0.84rem;
}

.interview-item {
    align-items: flex-start;
}

.interview-time {
    min-width: 72px;
    text-align: center;
    background: #f6f7ff;
    border: 1px solid #e8e9f7;
    border-radius: 10px;
    padding: 0.35rem 0.45rem;
}

.interview-time .time {
    font-weight: 700;
    color: #4248a4;
    font-size: 0.86rem;
}

.job-status {
    background: #eafbf2;
    color: #1f8d56;
    border: 1px solid #c9efd9;
    border-radius: 999px;
    padding: 0.2rem 0.55rem;
    font-size: 0.72rem;
    font-weight: 700;
}

.stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
    padding: 0.72rem 0.82rem;
    border: 1px solid #edf0f8;
    border-radius: 10px;
    background: #fafbff;
    margin-bottom: 0.55rem;
}

.stat-row:last-child {
    margin-bottom: 0;
}

.stat-row .stat-label {
    color: #4d5470;
    font-weight: 600;
    font-size: 0.88rem;
}

.stat-row .stat-value {
    color: #3f43a1;
    font-weight: 800;
    font-size: 0.95rem;
}

.empty-state {
    text-align: center;
    color: #7f8698;
    padding: 1.2rem 0;
    font-style: italic;
}

.alert {
    border-radius: 10px;
    margin-bottom: 0.9rem;
    padding: 0.85rem 1rem;
}

.alert-error {
    background: #ffe9ee;
    color: #a03a57;
    border: 1px solid #ffd2dc;
}

.alert-success {
    background: #eafbf2;
    color: #1f8d56;
    border: 1px solid #c9efd9;
}

.icon-plus::before { content: '+'; font-weight: 700; }
.icon-applications::before { content: '•'; font-weight: 700; }

@media (max-width: 768px) {
    .dashboard-content {
        padding: 1rem;
    }

    .hero-section {
        padding: 1.3rem;
    }

    .hero-title {
        font-size: 1.5rem;
    }

    .card-grid,
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
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
    const rootUrl = '<?= ROOT ?>';

    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPath)) {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        }
    });

    const setText = (id, value) => {
        const node = document.getElementById(id);
        if (node) {
            node.textContent = value;
        }
    };

    const escapeHtml = (value) => {
        const text = String(value ?? '');
        return text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    };

    const formatDateLabel = (dateValue) => {
        if (!dateValue) {
            return '';
        }

        const date = new Date(dateValue);
        if (Number.isNaN(date.getTime())) {
            return '';
        }

        return date.toLocaleDateString(undefined, { month: 'short', day: '2-digit' });
    };

    const formatTimeLabel = (timeValue) => {
        if (!timeValue) {
            return '';
        }

        const date = new Date(`1970-01-01T${timeValue}`);
        if (Number.isNaN(date.getTime())) {
            return '';
        }

        return date.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
    };

    const renderRecentApplications = (items) => {
        const container = document.getElementById('recent-applications-list');
        if (!container) {
            return;
        }

        if (!Array.isArray(items) || items.length === 0) {
            container.innerHTML = '<div class="empty-state">No recent applications</div>';
            return;
        }

        container.innerHTML = items.map((application) => `
            <div class="recent-item">
                <div class="item-info">
                    <div class="item-title">${escapeHtml(application.name || '')}</div>
                    <div class="item-subtitle">${escapeHtml(application.position || '')}</div>
                </div>
                <div class="item-time">${escapeHtml(application.time || 'Just now')}</div>
            </div>
        `).join('');
    };

    const renderActiveJobs = (items) => {
        const container = document.getElementById('active-job-posts-list');
        if (!container) {
            return;
        }

        if (!Array.isArray(items) || items.length === 0) {
            container.innerHTML = '<div class="empty-state">No active job posts</div>';
            return;
        }

        container.innerHTML = items.map((job) => `
            <div class="job-item">
                <div class="job-info">
                    <div class="job-title">${escapeHtml(job.title || '')}</div>
                    <div class="job-meta">${escapeHtml(job.department || 'General')} • ${Number(job.applications_count || 0)} applications</div>
                </div>
                <div class="job-status active">${escapeHtml(job.status || 'Open')}</div>
            </div>
        `).join('');
    };

    const updateSummary = (summary) => {
        setText('hero-active-jobs', Number(summary.active_jobs || 0));
        setText('hero-total-applications', Number(summary.total_applications || 0));
        setText('hero-scheduled-interviews', Number(summary.scheduled_interviews || 0));

        setText('metric-total-jobs', Number(summary.total_jobs || 0));
        setText('metric-active-jobs', Number(summary.active_jobs || 0));
        setText('metric-total-applications', Number(summary.total_applications || 0));
        setText('metric-scheduled-interviews', Number(summary.scheduled_interviews || 0));
    };

    const updateQuickStats = (quickStats) => {
        setText('quick-applications-today', Number(quickStats.applications_today || 0));
        setText('quick-pending-reviews', Number(quickStats.pending_reviews || 0));
        setText('quick-interviews-week', Number(quickStats.interviews_this_week || 0));
        setText('quick-offers-extended', Number(quickStats.offers_extended || 0));
        setText('quick-avg-time-to-hire', `${Number(quickStats.avg_time_to_hire_days || 0)} days`);
    };

    const refreshDashboard = async () => {
        try {
            const response = await fetch(`${rootUrl}/hradmin/dashboard/liveData`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                cache: 'no-store'
            });

            if (!response.ok) {
                return;
            }

            const payload = await response.json();
            if (!payload || payload.success !== true || !payload.data) {
                return;
            }

            const data = payload.data;
            updateSummary(data.summary || {});
            updateQuickStats(data.quick_stats || {});
            renderRecentApplications(data.recent_applications || []);
            renderActiveJobs(data.active_job_posts || []);
        } catch (error) {
        }
    };

    refreshDashboard();
    setInterval(refreshDashboard, 30000);
});
</script>

        </div>
    </div>

<?php $this->view('components/footer') ?>
