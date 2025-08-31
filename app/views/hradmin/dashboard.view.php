<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">HR Dashboard</h1>
        <p class="page-description">Overview of recruitment activities and key metrics</p>
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
                <i class="icon-plus"></i>Create Job Post
            </a>
            <a href="<?= ROOT ?>/hradmin/applications" class="btn btn-secondary">
                <i class="icon-eye"></i>Review Applications
            </a>
            <a href="<?= ROOT ?>/hradmin/interview-schedule" class="btn btn-secondary">
                <i class="icon-calendar"></i>Schedule Interview
            </a>
            <a href="<?= ROOT ?>/hradmin/reports" class="btn btn-secondary">
                <i class="icon-chart"></i>View Reports
            </a>
        </div>
    </div>

    <!-- Dashboard Content Grid -->
    <div class="dashboard-grid">
        <!-- Recent Applications -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Recent Applications</h3>
                <a href="<?= ROOT ?>/hradmin/applications" class="view-all-link">View All</a>
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
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
    background: #f8f9fa;
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
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.stat-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.stat-label {
    color: #6c757d;
}

.stat-value {
    font-weight: 600;
    color: #2c3e50;
}

.empty-state {
    text-align: center;
    color: #6c757d;
    font-style: italic;
    padding: 2rem 0;
}

/* Icon styles */
.icon-calendar::before { content: '📅'; }
</style>

<?php $this->view('components/footer') ?>
