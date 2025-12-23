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
                    <a href="<?= ROOT ?>/hradmin/dashboard" class="nav-link">
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
                    <a href="<?= ROOT ?>/hradmin/interview-schedule" class="nav-link">
                        <span class="nav-text">Interviews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/reports" class="nav-link active">
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
                <h1 class="page-title">HR Reports & Analytics</h1>
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
    <div class="header-section">
        <h1 class="page-title">HR Reports & Analytics</h1>
        <p class="page-description">Comprehensive recruitment analytics and performance insights</p>
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="exportReport()">
                Export Report
            </button>
            <button class="btn btn-secondary" onclick="scheduleReport()">
                Schedule Report
            </button>
        </div>
    </div>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach($errors as $error): ?>
                <p><?php echo $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Report Filters -->
    <div class="filter-section">
        <div class="filter-header">
            <h3>Report Filters</h3>
            <button class="btn btn-outline btn-sm" onclick="resetFilters()">Reset</button>
        </div>
        <div class="filter-controls">
            <div class="filter-group">
                <label>Date Range</label>
                <select class="filter-select">
                    <option value="7d">Last 7 days</option>
                    <option value="30d" selected>Last 30 days</option>
                    <option value="90d">Last 90 days</option>
                    <option value="1y">Last year</option>
                    <option value="custom">Custom range</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Department</label>
                <select class="filter-select">
                    <option value="">All Departments</option>
                    <option value="engineering">Engineering</option>
                    <option value="design">Design</option>
                    <option value="marketing">Marketing</option>
                    <option value="sales">Sales</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Position Level</label>
                <select class="filter-select">
                    <option value="">All Levels</option>
                    <option value="entry">Entry Level</option>
                    <option value="mid">Mid Level</option>
                    <option value="senior">Senior Level</option>
                    <option value="lead">Lead/Executive</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Report Type</label>
                <select class="filter-select" onchange="changeReportType(this.value)">
                    <option value="overview">Overview</option>
                    <option value="recruitment">Recruitment Funnel</option>
                    <option value="performance">Performance Metrics</option>
                    <option value="diversity">Diversity & Inclusion</option>
                    <option value="cost">Cost Analysis</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Key Metrics Dashboard -->
    <div class="metrics-dashboard">
        <div class="metrics-grid">
            <div class="metric-card primary">
                <div class="metric-header">
                    <h4>Total Applications</h4>
                </div>
                <div class="metric-value">1,247</div>
                <div class="metric-change positive">
                    <span class="change-icon">↗</span>
                    <span>+12.5% vs last month</span>
                </div>
            </div>
            
            <div class="metric-card success">
                <div class="metric-header">
                    <h4>Successful Hires</h4>
                </div>
                <div class="metric-value">89</div>
                <div class="metric-change positive">
                    <span class="change-icon">↗</span>
                    <span>+8.2% vs last month</span>
                </div>
            </div>
            
            <div class="metric-card warning">
                <div class="metric-header">
                    <h4>Avg. Time to Hire</h4>
                </div>
                <div class="metric-value">23 days</div>
                <div class="metric-change negative">
                    <span class="change-icon">↘</span>
                    <span>+2 days vs last month</span>
                </div>
            </div>
            
            <div class="metric-card info">
                <div class="metric-header">
                    <h4>Cost per Hire</h4>
                </div>
                <div class="metric-value">$3,450</div>
                <div class="metric-change positive">
                    <span class="change-icon">↗</span>
                    <span>-5.2% vs last month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recruitment Funnel Summary -->
    <div class="data-section">
        <div class="section-header">
            <h3>Recruitment Funnel Status</h3>
            <button class="btn btn-outline btn-sm" onclick="exportData('funnel')">Export Data</button>
        </div>
        <div class="data-grid">
            <div class="data-summary-card stage-applications">
                <div class="stage-info">
                    <div class="stage-icon"></div>
                    <div class="stage-details">
                        <h4>Applications Received</h4>
                        <p class="stage-number">1,247</p>
                        <p class="stage-percentage">100% of funnel</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">This Period</span>
                    <span class="stat-change positive">+12.5%</span>
                </div>
            </div>

            <div class="data-summary-card stage-screening">
                <div class="stage-info">
                    <div class="stage-icon"></div>
                    <div class="stage-details">
                        <h4>In Screening</h4>
                        <p class="stage-number">562</p>
                        <p class="stage-percentage">45.1% pass rate</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Pass Through</span>
                    <span class="stat-value">562 / 1,247</span>
                </div>
            </div>

            <div class="data-summary-card stage-interviews">
                <div class="stage-info">
                    <div class="stage-icon"></div>
                    <div class="stage-details">
                        <h4>Interviews Scheduled</h4>
                        <p class="stage-number">312</p>
                        <p class="stage-percentage">25.0% of applications</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Conversion</span>
                    <span class="stat-value">55.5% from screening</span>
                </div>
            </div>

            <div class="data-summary-card stage-offers">
                <div class="stage-info">
                    <div class="stage-icon"></div>
                    <div class="stage-details">
                        <h4>Offers Extended</h4>
                        <p class="stage-number">187</p>
                        <p class="stage-percentage">15.0% of applications</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Offer Rate</span>
                    <span class="stat-value">59.9% from interviews</span>
                </div>
            </div>

            <div class="data-summary-card stage-hires">
                <div class="stage-info">
                    <div class="stage-icon"></div>
                    <div class="stage-details">
                        <h4>Successful Hires</h4>
                        <p class="stage-number">89</p>
                        <p class="stage-percentage">7.1% overall success</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Acceptance</span>
                    <span class="stat-value">47.6% offer acceptance</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications Timeline Data -->
    <div class="data-section">
        <div class="section-header">
            <h3>Applications Over Time</h3>
            <button class="btn btn-outline btn-sm" onclick="exportData('timeline')">Export Data</button>
        </div>
        <div class="table-container">
            <table class="data-table timeline-table">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Applications</th>
                        <th>Change</th>
                        <th>Screenings</th>
                        <th>Interviews</th>
                        <th>Offers</th>
                        <th>Hires</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Week 6</strong></td>
                        <td>72</td>
                        <td><span class="trend-down">-31.4%</span></td>
                        <td>32</td>
                        <td>18</td>
                        <td>11</td>
                        <td>5</td>
                    </tr>
                    <tr>
                        <td><strong>Week 5</strong></td>
                        <td>105</td>
                        <td><span class="trend-up">+50.0%</span></td>
                        <td>47</td>
                        <td>26</td>
                        <td>16</td>
                        <td>8</td>
                    </tr>
                    <tr>
                        <td><strong>Week 4</strong></td>
                        <td>78</td>
                        <td><span class="trend-down">-12.4%</span></td>
                        <td>35</td>
                        <td>19</td>
                        <td>12</td>
                        <td>6</td>
                    </tr>
                    <tr>
                        <td><strong>Week 3</strong></td>
                        <td>89</td>
                        <td><span class="trend-up">+30.9%</span></td>
                        <td>40</td>
                        <td>22</td>
                        <td>14</td>
                        <td>7</td>
                    </tr>
                    <tr>
                        <td><strong>Week 2</strong></td>
                        <td>68</td>
                        <td><span class="trend-up">+51.1%</span></td>
                        <td>31</td>
                        <td>17</td>
                        <td>10</td>
                        <td>5</td>
                    </tr>
                    <tr>
                        <td><strong>Week 1</strong></td>
                        <td>45</td>
                        <td><span class="trend-neutral">--</span></td>
                        <td>20</td>
                        <td>11</td>
                        <td>7</td>
                        <td>3</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Department & Source Data Tables -->
    <div class="tables-grid">
        <!-- Department Hiring Breakdown -->
        <div class="table-card">
            <div class="table-header">
                <h4>Hiring by Department</h4>
                <button class="btn btn-outline btn-sm" onclick="exportData('department')">Export</button>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Applications</th>
                            <th>Hires</th>
                            <th>Success Rate</th>
                            <th>% of Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="dept-name">
                                    <span class="dept-color engineering"></span>
                                    Engineering
                                </div>
                            </td>
                            <td>498</td>
                            <td>36</td>
                            <td><span class="rate-good">7.2%</span></td>
                            <td>40%</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="dept-name">
                                    <span class="dept-color design"></span>
                                    Design
                                </div>
                            </td>
                            <td>312</td>
                            <td>22</td>
                            <td><span class="rate-good">7.1%</span></td>
                            <td>25%</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="dept-name">
                                    <span class="dept-color marketing"></span>
                                    Marketing
                                </div>
                            </td>
                            <td>249</td>
                            <td>18</td>
                            <td><span class="rate-good">7.2%</span></td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="dept-name">
                                    <span class="dept-color sales"></span>
                                    Sales
                                </div>
                            </td>
                            <td>188</td>
                            <td>13</td>
                            <td><span class="rate-average">6.9%</span></td>
                            <td>15%</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong>1,247</strong></td>
                            <td><strong>89</strong></td>
                            <td><strong>7.1%</strong></td>
                            <td><strong>100%</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Application Sources -->
        <div class="table-card">
            <div class="table-header">
                <h4>Application Sources</h4>
                <button class="btn btn-outline btn-sm" onclick="exportData('sources')">Export</button>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Applications</th>
                            <th>Hires</th>
                            <th>Success Rate</th>
                            <th>% of Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Company Website</strong></td>
                            <td>425</td>
                            <td>32</td>
                            <td><span class="rate-good">7.5%</span></td>
                            <td>34.1%</td>
                        </tr>
                        <tr>
                            <td><strong>LinkedIn</strong></td>
                            <td>312</td>
                            <td>24</td>
                            <td><span class="rate-excellent">7.7%</span></td>
                            <td>25.0%</td>
                        </tr>
                        <tr>
                            <td><strong>Indeed</strong></td>
                            <td>187</td>
                            <td>13</td>
                            <td><span class="rate-average">7.0%</span></td>
                            <td>15.0%</td>
                        </tr>
                        <tr>
                            <td><strong>Referrals</strong></td>
                            <td>123</td>
                            <td>12</td>
                            <td><span class="rate-excellent">9.8%</span></td>
                            <td>9.9%</td>
                        </tr>
                        <tr>
                            <td><strong>Other Sources</strong></td>
                            <td>200</td>
                            <td>8</td>
                            <td><span class="rate-average">4.0%</span></td>
                            <td>16.0%</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong>1,247</strong></td>
                            <td><strong>89</strong></td>
                            <td><strong>7.1%</strong></td>
                            <td><strong>100%</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Detailed Tables -->
    <div class="tables-section">
        <!-- Top Performing Jobs -->
        <div class="table-card">
            <div class="table-header">
                <h4>Top Performing Job Posts</h4>
                <a href="<?= ROOT ?>/hradmin/jobposts" class="view-all-link">View All Jobs</a>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Applications</th>
                            <th>Interviews</th>
                            <th>Hires</th>
                            <th>Conversion Rate</th>
                            <th>Avg. Time to Hire</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Senior Software Developer</td>
                            <td>156</td>
                            <td>45</td>
                            <td>12</td>
                            <td><span class="rate-good">26.7%</span></td>
                            <td>18 days</td>
                        </tr>
                        <tr>
                            <td>UI/UX Designer</td>
                            <td>89</td>
                            <td>28</td>
                            <td>8</td>
                            <td><span class="rate-excellent">28.6%</span></td>
                            <td>21 days</td>
                        </tr>
                        <tr>
                            <td>Marketing Manager</td>
                            <td>67</td>
                            <td>18</td>
                            <td>5</td>
                            <td><span class="rate-good">27.8%</span></td>
                            <td>25 days</td>
                        </tr>
                        <tr>
                            <td>Project Manager</td>
                            <td>45</td>
                            <td>12</td>
                            <td>3</td>
                            <td><span class="rate-average">25.0%</span></td>
                            <td>30 days</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Interviewer Performance -->
        <div class="table-card">
            <div class="table-header">
                <h4>Interviewer Performance</h4>
                <button class="btn btn-outline btn-sm" onclick="viewInterviewerDetails()">View Details</button>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Interviewer</th>
                            <th>Interviews Conducted</th>
                            <th>Avg. Rating</th>
                            <th>Hire Rate</th>
                            <th>Feedback Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sarah Johnson</td>
                            <td>28</td>
                            <td>4.3/5</td>
                            <td><span class="rate-excellent">32%</span></td>
                            <td>4.7/5</td>
                        </tr>
                        <tr>
                            <td>Mike Wilson</td>
                            <td>22</td>
                            <td>4.1/5</td>
                            <td><span class="rate-good">28%</span></td>
                            <td>4.5/5</td>
                        </tr>
                        <tr>
                            <td>Emily Chen</td>
                            <td>19</td>
                            <td>4.2/5</td>
                            <td><span class="rate-good">26%</span></td>
                            <td>4.6/5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.filter-section {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.filter-header h3 {
    margin: 0;
    color: #2c3e50;
}

.filter-controls {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.875rem;
}

.filter-select {
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 0.875rem;
}

.metrics-dashboard {
    margin-bottom: 1.5rem;
}

.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.metric-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
}

.metric-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.metric-card.primary::before { background: #4e31aa; }
.metric-card.success::before { background: #28a745; }
.metric-card.warning::before { background: #ffc107; }
.metric-card.info::before { background: #17a2b8; }

.metric-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.metric-header h4 {
    margin: 0;
    color: #6c757d;
    font-size: 0.875rem;
    font-weight: 500;
}

.metric-icon {
    font-size: 1.25rem;
}

.metric-value {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.metric-change {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.metric-change.positive {
    color: #28a745;
}

.metric-change.negative {
    color: #dc3545;
}

.change-icon {
    font-weight: bold;
}

/* Data Section Styles */
.data-section {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f3f4;
}

.section-header h3 {
    margin: 0;
    color: #2c3e50;
    font-size: 1.25rem;
    font-weight: 700;
}

.data-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
}

.data-summary-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 1px solid #dee2e6;
    border-radius: 10px;
    padding: 1.25rem;
    transition: all 0.3s ease;
}

.data-summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.stage-info {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
}

.stage-icon {
    font-size: 2rem;
    line-height: 1;
}

.stage-details h4 {
    margin: 0 0 0.5rem;
    color: #495057;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stage-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0.25rem 0;
    line-height: 1;
}

.stage-percentage {
    font-size: 0.875rem;
    color: #6c757d;
    margin: 0.25rem 0 0;
}

.stage-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 0.75rem;
    border-top: 1px solid #dee2e6;
}

.stat-label {
    font-size: 0.8125rem;
    color: #6c757d;
    font-weight: 500;
}

.stat-value {
    font-size: 0.8125rem;
    color: #495057;
    font-weight: 600;
}

.stat-change {
    font-size: 0.8125rem;
    font-weight: 600;
}

.stat-change.positive {
    color: #28a745;
}

/* Timeline Table */
.timeline-table tbody tr {
    transition: background-color 0.2s ease;
}

.timeline-table tbody tr:hover {
    background-color: #f8f9fa;
}

.trend-up {
    color: #28a745;
    font-weight: 600;
}

.trend-down {
    color: #dc3545;
    font-weight: 600;
}

.trend-neutral {
    color: #6c757d;
}

/* Tables Grid */
.tables-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

/* Department Colors */
.dept-name {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
}

.dept-color {
    width: 12px;
    height: 12px;
    border-radius: 3px;
    display: inline-block;
}

.dept-color.engineering { background: #4e31aa; }
.dept-color.design { background: #7b1fa2; }
.dept-color.marketing { background: #388e3c; }
.dept-color.sales { background: #f57c00; }

.tables-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.table-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f3f4;
}

.table-header h4 {
    margin: 0;
    color: #2c3e50;
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

.rate-excellent { color: #28a745; font-weight: 600; }
.rate-good { color: #17a2b8; font-weight: 600; }
.rate-average { color: #ffc107; font-weight: 600; }
.rate-poor { color: #dc3545; font-weight: 600; }

/* Additional Table Styles */
.data-table tfoot {
    font-weight: 700;
    background-color: #f8f9fa;
    border-top: 2px solid #dee2e6;
}

.data-table tfoot td {
    padding: 1rem;
}

/* Responsive design */
@media (max-width: 768px) {
    .filter-controls {
        grid-template-columns: 1fr;
    }
    
    .metrics-grid {
        grid-template-columns: 1fr;
    }
    
    .data-grid {
        grid-template-columns: 1fr;
    }
    
    .tables-grid {
        grid-template-columns: 1fr;
    }
    
    .tables-section {
        grid-template-columns: 1fr;
    }
    
    .data-summary-card {
        padding: 1rem;
    }
    
    .stage-icon {
        font-size: 1.5rem;
    }
    
    .stage-number {
        font-size: 1.5rem;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .data-table {
        font-size: 0.875rem;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
</style>

<script>
function exportReport() {
    alert('Exporting current report as PDF...');
    // Implement export functionality
}

function scheduleReport() {
    alert('Opening report scheduling dialog...');
    // Implement report scheduling
}

function resetFilters() {
    document.querySelectorAll('.filter-select').forEach(select => {
        select.selectedIndex = 0;
    });
    generateReport();
}

function changeReportType(type) {
    alert(`Switching to ${type} report view...`);
    // Implement report type switching
}

function exportData(dataType) {
    alert(`Exporting ${dataType} data as CSV...`);
    // Implement data export functionality
}

function viewInterviewerDetails() {
    alert('Opening detailed interviewer performance...');
    // Implement detailed view
}

function generateReport() {
    alert('Regenerating report with current filters...');
    // Implement report generation
}

// Auto-refresh data every 5 minutes
setInterval(() => {
    console.log('Refreshing report data...');
    // Implement data refresh
}, 300000);

// Animate data cards on load
document.addEventListener('DOMContentLoaded', function() {
    // Animate summary cards
    document.querySelectorAll('.data-summary-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

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
});
</script>

        </div>
    </div>

<?php $this->view('components/footer') ?>
