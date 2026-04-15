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
                <div class="hero-section">
                    <div class="hero-content">
                        <h1 class="hero-title">HR Reports & Analytics</h1>
                        <p class="hero-description">Get comprehensive insights into your recruitment performance with detailed analytics and custom reports.</p>
                        <div class="hero-stats">
                            <div class="hero-stat">
                                <span class="stat-number"><?= $total_hires ?? '45' ?></span>
                                <span class="stat-label">Total Hires</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number"><?= $avg_time_to_hire ?? '23' ?></span>
                                <span class="stat-label">Days to Hire</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number"><?= $success_rate ?? '76' ?>%</span>
                                <span class="stat-label">Success Rate</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero-actions">
                        <button class="btn btn-primary" onclick="exportReport()">
                            <i class="icon-download"></i>Export Report
                        </button>
                        <button class="btn btn-outline" onclick="scheduleReport()">
                            <i class="icon-calendar"></i>Schedule Report
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
                <div class="metric-value"><?= number_format($dashboard_metrics['total_applications'] ?? 0) ?></div>
                <div class="metric-change positive">
                    <span class="change-icon">•</span>
                    <span>Updated from database</span>
                </div>
            </div>
            
            <div class="metric-card success">
                <div class="metric-header">
                    <h4>Successful Hires</h4>
                </div>
                <div class="metric-value"><?= number_format($dashboard_metrics['successful_hires'] ?? 0) ?></div>
                <div class="metric-change positive">
                    <span class="change-icon">•</span>
                    <span>Updated from database</span>
                </div>
            </div>
            
            <div class="metric-card warning">
                <div class="metric-header">
                    <h4>Avg. Time to Hire</h4>
                </div>
                <div class="metric-value"><?= number_format($dashboard_metrics['avg_time_to_hire'] ?? 0) ?> days</div>
                <div class="metric-change negative">
                    <span class="change-icon">•</span>
                    <span>Updated from database</span>
                </div>
            </div>
            
            <div class="metric-card info">
                <div class="metric-header">
                    <h4>Cost per Hire</h4>
                </div>
                <div class="metric-value">$<?= number_format((float)($dashboard_metrics['cost_per_hire'] ?? 0), 0) ?></div>
                <div class="metric-change positive">
                    <span class="change-icon">•</span>
                    <span>Updated from database</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recruitment Funnel Summary -->
    <div class="data-section">
        <div class="section-header">
            <h3>Recruitment Funnel Status <span style="font-size: 0.85rem; color: #666; font-weight: normal;">(Last 90 Days)</span></h3>
            <button class="btn btn-outline btn-sm" onclick="exportData('funnel')">Export Data</button>
        </div>
        <div class="data-grid">
            <div class="data-summary-card stage-applications">
                <div class="stage-info">
                    <div class="stage-details">
                        <h4>Applications Received</h4>
                        <p class="stage-number"><?= number_format($funnel_stats['total_applications'] ?? 0) ?></p>
                        <p class="stage-percentage">100% of funnel</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Last 30 Days</span>
                    <span class="stat-change">Total Pipeline</span>
                </div>
            </div>

            <div class="data-summary-card stage-screening">
                <div class="stage-info">
                    <div class="stage-details">
                        <h4>In Screening</h4>
                        <p class="stage-number"><?= number_format($funnel_stats['screening_passed'] ?? 0) ?></p>
                        <p class="stage-percentage"><?= $conversion_rates['screening_rate'] ?? 0 ?>% pass rate</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Pass Through</span>
                    <span class="stat-value"><?= $funnel_stats['screening_passed'] ?? 0 ?> / <?= $funnel_stats['total_applications'] ?? 0 ?></span>
                </div>
            </div>

            <div class="data-summary-card stage-interviews">
                <div class="stage-info">
                    <div class="stage-details">
                        <h4>Interviews Scheduled</h4>
                        <p class="stage-number"><?= number_format($funnel_stats['interviews_scheduled'] ?? 0) ?></p>
                        <p class="stage-percentage"><?= round((($funnel_stats['interviews_scheduled'] ?? 0) / max(1, $funnel_stats['total_applications'] ?? 1)) * 100, 1) ?>% of applications</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Conversion</span>
                    <span class="stat-value"><?= $conversion_rates['interview_rate'] ?? 0 ?>% from screening</span>
                </div>
            </div>

            <div class="data-summary-card stage-offers">
                <div class="stage-info">
                    <div class="stage-details">
                        <h4>Offers Extended</h4>
                        <p class="stage-number"><?= number_format($funnel_stats['offers_extended'] ?? 0) ?></p>
                        <p class="stage-percentage"><?= round((($funnel_stats['offers_extended'] ?? 0) / max(1, $funnel_stats['total_applications'] ?? 1)) * 100, 1) ?>% of applications</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Offer Rate</span>
                    <span class="stat-value"><?= $conversion_rates['offer_rate'] ?? 0 ?>% from interviews</span>
                </div>
            </div>

            <div class="data-summary-card stage-hires">
                <div class="stage-info">
                    <div class="stage-details">
                        <h4>Successful Hires</h4>
                        <p class="stage-number"><?= number_format($funnel_stats['successful_hires'] ?? 0) ?></p>
                        <p class="stage-percentage"><?= round((($funnel_stats['successful_hires'] ?? 0) / max(1, $funnel_stats['total_applications'] ?? 1)) * 100, 1) ?>% overall success</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Acceptance</span>
                    <span class="stat-value"><?= $conversion_rates['hire_rate'] ?? 0 ?>% offer acceptance</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications Timeline Data -->
    <div class="data-section">
        <div class="section-header">
            <h3>Applications Over Time <span style="font-size: 0.85rem; color: #666; font-weight: normal;">(Last 12 Weeks)</span></h3>
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
                    <?php if (!empty($applications_timeline)): ?>
                        <?php 
                        $previousCount = null;
                        foreach ($applications_timeline as $index => $week): 
                            $change = 0;
                            $changeClass = '';
                            
                            if ($previousCount !== null && $previousCount > 0) {
                                $change = (($week['total_applications'] - $previousCount) / $previousCount) * 100;
                                $changeClass = $change >= 0 ? 'trend-up' : 'trend-down';
                            }
                        ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($week['period']) ?></strong><br><small><?= date('M d', strtotime($week['week_start'])) ?> - <?= date('M d', strtotime($week['week_end'])) ?></small></td>
                            <td><?= number_format($week['total_applications']) ?></td>
                            <td>
                                <?php if ($previousCount !== null): ?>
                                    <span class="<?= $changeClass ?>"><?= $change >= 0 ? '+' : '' ?><?= number_format($change, 1) ?>%</span>
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                            <td><?= number_format($week['screenings']) ?></td>
                            <td><?= number_format($week['interviews']) ?></td>
                            <td><?= number_format($week['offers']) ?></td>
                            <td><?= number_format($week['hires']) ?></td>
                        </tr>
                        <?php 
                            $previousCount = $week['total_applications'];
                        endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px;">
                                <p style="color: #6c757d;">No application data available for the selected period.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Department & Source Data Tables -->
    <div class="tables-grid">
        <!-- Department Hiring Breakdown -->
        <div class="table-card">
            <div class="table-header">
                <h4>Hiring by Department <span style="font-size: 0.8rem; color: #666; font-weight: normal;">(All Time)</span></h4>
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
                        <?php 
                        $total_apps = 0;
                        $total_hires_count = 0;
                        if (!empty($department_stats)):
                            foreach ($department_stats as $dept):
                                $total_apps += $dept['total_applications'];
                                $total_hires_count += $dept['hires'];
                            endforeach;
                        endif;
                        ?>
                        <?php if (!empty($department_stats)): ?>
                            <?php foreach ($department_stats as $dept): ?>
                                <?php 
                                $success_rate = $dept['total_applications'] > 0 ? ($dept['hires'] / $dept['total_applications']) * 100 : 0;
                                $percent_of_total = $total_apps > 0 ? ($dept['total_applications'] / $total_apps) * 100 : 0;
                                $rate_class = $success_rate >= 8 ? 'rate-excellent' : ($success_rate >= 5 ? 'rate-good' : 'rate-average');
                                ?>
                                <tr>
                                    <td>
                                        <div class="dept-name">
                                            <span class="dept-color engineering"></span>
                                            <?= htmlspecialchars($dept['department_name']) ?>
                                        </div>
                                    </td>
                                    <td><?= number_format($dept['total_applications']) ?></td>
                                    <td><?= number_format($dept['hires']) ?></td>
                                    <td><span class="<?= $rate_class ?>"><?= number_format($success_rate, 1) ?>%</span></td>
                                    <td><?= number_format($percent_of_total, 1) ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem;">No department data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong><?= number_format($total_apps) ?></strong></td>
                            <td><strong><?= number_format($total_hires_count) ?></strong></td>
                            <td><strong><?= $total_apps > 0 ? number_format(($total_hires_count / $total_apps) * 100, 1) : 0 ?>%</strong></td>
                            <td><strong>100%</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Application Sources -->
        <div class="table-card">
            <div class="table-header">
                <h4>Application Sources <span style="font-size: 0.8rem; color: #666; font-weight: normal;">(Sample Data - No Source Tracking)</span></h4>
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
                        <?php if (!empty($top_performing_jobs)): ?>
                            <?php foreach ($top_performing_jobs as $job): ?>
                                <?php
                                $conversion = (float)($job['conversion_rate'] ?? 0);
                                $rateClass = $conversion >= 30 ? 'rate-excellent' : ($conversion >= 20 ? 'rate-good' : 'rate-average');
                                $avgDays = $job['avg_days_to_hire'];
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($job['job_title']) ?></td>
                                    <td><?= number_format((int)$job['applications_count']) ?></td>
                                    <td><?= number_format((int)$job['interviews_count']) ?></td>
                                    <td><?= number_format((int)$job['hires_count']) ?></td>
                                    <td><span class="<?= $rateClass ?>"><?= number_format($conversion, 1) ?>%</span></td>
                                    <td><?= $avgDays !== null ? number_format((float)$avgDays, 0) . ' days' : 'N/A' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 2rem;">No job performance data available</td>
                            </tr>
                        <?php endif; ?>
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
                        <?php if (!empty($interviewer_performance)): ?>
                            <?php foreach ($interviewer_performance as $interviewer): ?>
                                <?php
                                $hireRate = (float)($interviewer['hire_rate'] ?? 0);
                                $hireRateClass = $hireRate >= 30 ? 'rate-excellent' : ($hireRate >= 20 ? 'rate-good' : 'rate-average');
                                $avgRating = $interviewer['avg_rating'] !== null ? number_format((float)$interviewer['avg_rating'], 1) . '/5' : 'N/A';
                                $feedbackScore = $interviewer['feedback_score'] !== null ? number_format((float)$interviewer['feedback_score'], 1) . '/5' : 'N/A';
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($interviewer['interviewer_name']) ?></td>
                                    <td><?= number_format((int)$interviewer['interviews_conducted']) ?></td>
                                    <td><?= $avgRating ?></td>
                                    <td><span class="<?= $hireRateClass ?>"><?= number_format($hireRate, 1) ?>%</span></td>
                                    <td><?= $feedbackScore ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem;">No interviewer performance data available</td>
                            </tr>
                        <?php endif; ?>
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

/* Modern HR Admin Design System */
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --background-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-content {
        background: var(--background-gradient);
        min-height: 100vh;
        padding: 2rem;
    }

    .hero-section {
        background: linear-gradient(135deg, #4c63d2 0%, #5a67d8 50%, #667eea 100%);
        color: white;
        padding: 3rem 2.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2.5rem;
        box-shadow: var(--card-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.1);
        border-radius: var(--border-radius);
        pointer-events: none;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: #ffffff;
        text-shadow: 0 4px 12px rgba(0,0,0,0.3);
        position: relative;
        z-index: 1;
    }

    .hero-description {
        font-size: 1.125rem;
        opacity: 1;
        margin-bottom: 1.5rem;
        color: rgba(255,255,255,0.95);
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }

    .hero-stats {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .stat-number {
        display: block;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .btn {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background: white;
        color: #667eea;
    }

    .btn-outline {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    /* Icons */
    .icon-download::before { content: '⬇'; }
    .icon-calendar::before { content: '📅'; }

    @media (max-width: 768px) {
        .hero-section { flex-direction: column; }
        .dashboard-content { padding: 1rem; }
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
