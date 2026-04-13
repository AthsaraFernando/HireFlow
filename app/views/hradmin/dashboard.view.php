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
                                <span class="stat-number"><?= $active_jobs ?? '18' ?></span>
                                <span class="stat-label">Active Jobs</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number"><?= $total_applications ?? '156' ?></span>
                                <span class="stat-label">Applications</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number"><?= $scheduled_interviews ?? '12' ?></span>
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
            <div class="metric-value"><?= $total_jobs ?? 42 ?></div>
            <div class="metric-label">Total Job Posts</div>
            <div class="metric-change positive">+3 this month</div>
        </div>
        <div class="metric-card">
            <div class="metric-value"><?= $active_jobs ?? 18 ?></div>
            <div class="metric-label">Active Positions</div>
            <div class="metric-change positive">+2 this week</div>
        </div>
        <div class="metric-card">
            <div class="metric-value"><?= $total_applications ?? 156 ?></div>
            <div class="metric-label">Total Applications</div>
            <div class="metric-change positive">+12 today</div>
        </div>
        <div class="metric-card">
            <div class="metric-value"><?= $scheduled_interviews ?? 12 ?></div>
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
            <a href="<?= ROOT ?>/hradmin/interview-schedule" class="btn btn-secondary">
                Schedule Interview
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
            <div class="card-content">
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
            <div class="card-content">
                <div class="job-item">
                    <div class="job-info">
                        <div class="job-title">Senior Software Developer</div>
                        <div class="job-meta">Engineering • 23 applications</div>
                    </div>
                    <div class="job-status active">Active</div>
                </div>
                <div class="job-item">
                    <div class="job-info">
                        <div class="job-title">UI/UX Designer</div>
                        <div class="job-meta">Design • 18 applications</div>
                    </div>
                    <div class="job-status active">Active</div>
                </div>
                <div class="job-item">
                    <div class="job-info">
                        <div class="job-title">Marketing Manager</div>
                        <div class="job-meta">Marketing • 12 applications</div>
                    </div>
                    <div class="job-status active">Active</div>
                </div>
            </div>
        </div>

        <!-- Interview Schedule -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Upcoming Interviews</h3>
                <a href="<?= ROOT ?>/hradmin/interviewschedule" class="view-all-link">View Schedule</a>
            </div>
            <div class="card-content">
                <div class="interview-item">
                    <div class="interview-time">
                        <div class="time">10:00 AM</div>
                        <div class="date">Jan 20</div>
                    </div>
                    <div class="interview-info">
                        <div class="candidate">John Smith</div>
                        <div class="position">Senior Software Developer</div>
                    </div>
                </div>
                <div class="interview-item">
                    <div class="interview-time">
                        <div class="time">2:00 PM</div>
                        <div class="date">Jan 21</div>
                    </div>
                    <div class="interview-info">
                        <div class="candidate">Sarah Johnson</div>
                        <div class="position">UI/UX Designer</div>
                    </div>
                </div>
                <div class="interview-item">
                    <div class="interview-time">
                        <div class="time">11:00 AM</div>
                        <div class="date">Jan 22</div>
                    </div>
                    <div class="interview-info">
                        <div class="candidate">Mike Wilson</div>
                        <div class="position">Project Manager</div>
                    </div>
                </div>
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
                    <span class="stat-value">12</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Pending Reviews</span>
                    <span class="stat-value">34</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Interviews This Week</span>
                    <span class="stat-value">8</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Offers Extended</span>
                    <span class="stat-value">5</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Avg. Time to Hire</span>
                    <span class="stat-value">23 days</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.dashboard-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 
        0 1px 3px rgba(0, 0, 0, 0.1),
        0 1px 2px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: 
        0 4px 6px rgba(0, 0, 0, 0.1),
        0 2px 4px rgba(0, 0, 0, 0.06);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(180deg, #f8f9fa 0%, #f1f3f4 100%);
}

.card-header h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.card-content {
    padding: 1.5rem;
    background: white;
}

.card-header h3 {
    margin: 0;
    color: #2c3e50;
    font-size: 1.1rem;
}

.view-all-link {
    color: #4e31aa;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.view-all-link:hover {
    text-decoration: underline;
}

.card-content {
    padding: 1.5rem;
}

.recent-item, .job-item, .interview-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.recent-item:last-child, .job-item:last-child, .interview-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.item-title, .job-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.item-subtitle, .job-meta {
    font-size: 0.875rem;
    color: #6c757d;
}

.item-time {
    font-size: 0.875rem;
    color: #6c757d;
}

.job-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.job-status.active {
    background: #d4edda;
    color: #155724;
}

.interview-item {
    align-items: flex-start;
}

.interview-time {
    text-align: center;
    min-width: 80px;
}

.interview-time .time {
    font-weight: 600;
    color: #2c3e50;
}

.interview-time .date {
    font-size: 0.875rem;
    color: #6c757d;
}

.candidate {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.position {
    font-size: 0.875rem;
    color: #6c757d;
}

.stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: rgba(255, 255, 255, 0.8);
    margin-bottom: 0.5rem;
    border-radius: 8px;
}

.stat-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.stat-label {
    color: #162335ff;
    font-weight: 600;
    font-size: 0.95rem;
}

.stat-value {
    font-weight: 700;
    color: #6c757d;
    font-size: 1.1rem;
}

.empty-state {
    text-align: center;
    color: #6c757d;
    font-style: italic;
    padding: 2rem 0;
}

    /* Global Variables */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --background-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
        --card-hover-shadow: 0 20px 40px rgba(0,0,0,0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Enhanced Layout with Generous Spacing */
    .dashboard-content {
        background: var(--background-gradient);
        min-height: 100vh;
        padding: 3rem;
    }

    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Hero Section with Fixed Alignment */
    .hero-section {
        background: linear-gradient(135deg, 
            rgba(76, 99, 210, 0.95) 0%, 
            rgba(90, 103, 216, 0.95) 50%, 
            rgba(102, 126, 234, 0.95) 100%),
            linear-gradient(45deg, 
            rgba(37, 60, 161, 0.9) 0%, 
            rgba(76, 99, 210, 0.9) 100%);
        color: white;
        padding: 4rem 3rem;
        border-radius: var(--border-radius);
        margin-bottom: 3rem;
        box-shadow: var(--card-shadow), 0 10px 30px rgba(76, 99, 210, 0.4);
        position: relative;
        overflow: hidden;
        display: block;
    }

    .hero-content {
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
        z-index: 10;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 
            0 2px 4px rgba(0,0,0,0.4),
            0 4px 8px rgba(0,0,0,0.3);
        color: #ffffff;
        line-height: 1.2;
        letter-spacing: -0.01em;
    }

    .hero-description {
        font-size: 1.2rem;
        opacity: 1;
        margin-bottom: 2rem;
        line-height: 1.6;
        color: rgba(255,255,255,0.98);
        text-shadow: 
            0 1px 3px rgba(0,0,0,0.4),
            0 2px 6px rgba(0,0,0,0.3);
        font-weight: 400;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-stats {
        display: flex;
        gap: 4rem;
        flex-wrap: wrap;
        position: relative;
        z-index: 10;
    }

    .hero-stat {
        text-align: center;
        min-width: 120px;
        position: relative;
        z-index: 10;
    }

    .stat-number {
        display: block;
        font-size: 3rem;
        font-weight: 700;
        line-height: 1;
        color: #ffffff;
        text-shadow: 
            0 2px 4px rgba(0,0,0,0.4),
            0 4px 8px rgba(0,0,0,0.3);
        margin-bottom: 1rem;
    }

    .stat-label {
        font-size: 1rem;
        opacity: 0.95;
        display: block;
        color: Black;
        text-shadow: 
            0 1px 3px rgba(0,0,0,0.4),
            0 2px 6px rgba(0,0,0,0.2);
        font-weight: 500;
        line-height: 1.4;
    }

    .hero-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        position: relative;
        z-index: 10;
        min-width: 200px;
    }

    /* Breadcrumb */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1rem;
        opacity: 0.9;
    }

    .breadcrumb-link {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        transition: var(--transition);
    }

    .breadcrumb-link:hover {
        color: white;
    }

    .breadcrumb-separator {
        opacity: 0.6;
    }

    .breadcrumb-current {
        color: white;
        font-weight: 600;
    }

    /* Enhanced Buttons with 3D Lighting */
    .btn {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
        border: 1px solid;
        cursor: pointer;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 1px 0 rgba(255, 255, 255, 0.2) inset,
            0 1px 3px rgba(0, 0, 0, 0.1),
            0 0 0 1px rgba(0, 0, 0, 0.05);
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
        color: #4c63d2;
        border-color: rgba(255, 255, 255, 0.8);
        border-top-color: #ffffff;
        border-bottom-color: #e2e8f0;
        font-weight: 700;
        text-shadow: none;
        box-shadow: 
            0 1px 0 #ffffff inset,
            0 2px 4px rgba(0, 0, 0, 0.1),
            0 8px 16px rgba(255, 255, 255, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(180deg, #ffffff 0%, #f0f0f0 100%);
        transform: translateY(-1px);
        box-shadow: 
            0 1px 0 #ffffff inset,
            0 4px 8px rgba(0, 0, 0, 0.15),
            0 12px 24px rgba(255, 255, 255, 0.3);
        color: #3a54b8;
    }

    .btn-primary:active {
        transform: translateY(0);
        box-shadow: 
            0 1px 0 #ffffff inset,
            0 1px 2px rgba(0, 0, 0, 0.1) inset,
            0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-outline {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        font-weight: 600;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }

    .btn-outline:hover {
        background: rgba(255,255,255,0.2);
        border-color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255,255,255,0.2);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(255,255,255,0.4);
        color: #3c4fd8;
        background: #f7fafc;
    }

    .btn-outline {
        background: rgba(255,255,255,0.15);
        color: white;
        border: 2px solid rgba(255,255,255,0.4);
        backdrop-filter: blur(10px);
        font-weight: 600;
    }

    .btn-outline:hover {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.6);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255,255,255,0.2);
    }

    .btn-secondary {
        background: rgba(255,255,255,0.95);
        color: #667eea;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .btn-secondary:hover {
        background: white;
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.15);
    }

    /* Enhanced Cards with Generous Spacing */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 3rem;
        margin-bottom: 4rem;
    }

    .metric-card {
        background: linear-gradient(180deg, #ffffff 0%, #fdfdfd 100%);
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: 
            0 1px 3px rgba(0, 0, 0, 0.1),
            0 4px 6px rgba(0, 0, 0, 0.05);
        transition: var(--transition);
        position: relative;
        overflow: visible;
        border: 1px solid #e2e8f0;
        border-top: 1px solid #f7fafc;
        border-bottom: 2px solid #d1d5db;
        text-align: center;
        min-height: 180px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .metric-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #4c63d2;
        margin-bottom: 0.5rem;
        line-height: 1;
        text-shadow: none;
    }

    .metric-label {
        font-size: 1rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.75rem;
        line-height: 1.3;
        text-align: center;
    }

    .metric-change {
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        display: inline-block;
        line-height: 1.2;
    }

    .metric-change.positive {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    .metric-change.neutral {
        background: linear-gradient(135deg, #a0aec0, #718096);
        color: white;
    }

    /* Dashboard Cards */
    .dashboard-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: var(--transition);
        margin-bottom: 2rem;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    .card-header {
        padding: 2rem 2rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }

    .view-all-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .view-all-link:hover {
        color: #5a67d8;
        text-decoration: underline;
    }

    .card-content {
        padding: 1.5rem 2rem 2rem;
    }

    /* Form Styling */
    .form-group {
        margin-bottom: 2rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 1rem;
        transition: var(--transition);
        background: white;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    /* Icons */
    .icon-plus::before { content: '✚'; }
    .icon-applications::before { content: '📋'; }
    .icon-arrow-left::before { content: '←'; }
    .icon-save::before { content: '💾'; }
    .icon-edit::before { content: '✏️'; }
    .icon-delete::before { content: '🗑️'; }
    .icon-view::before { content: '👁️'; }
    .icon-calendar::before { content: '📅'; }

    /* Alerts */
    .alert {
        padding: 1.5rem 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        font-weight: 500;
    }

    .alert-error {
        background: linear-gradient(135deg, #feb2b2, #f56565);
        color: white;
        box-shadow: 0 8px 25px rgba(245, 101, 101, 0.3);
    }

    .alert-success {
        background: linear-gradient(135deg, #9ae6b4, #48bb78);
        color: white;
        box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-section {
            flex-direction: column;
            text-align: center;
            padding: 2rem 1.5rem;
        }

        .hero-title {
            font-size: 2.25rem;
        }

        .hero-stats {
            justify-content: center;
        }

        .card-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-content {
            padding: 1rem;
        }
    }

/* Original dashboard-specific styles */
.icon-calendar::before { content: '📅'; }
</style>

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
