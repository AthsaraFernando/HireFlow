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
                                <span class="stat-number" id="hero-total-hires"><?= (int)($total_hires ?? 0) ?></span>
                                <span class="stat-label">Total Hires</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number" id="hero-avg-time"><?= (int)($avg_time_to_hire ?? 0) ?></span>
                                <span class="stat-label">Days to Hire</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number" id="hero-success-rate"><?= (float)($success_rate ?? 0) ?>%</span>
                                <span class="stat-label">Success Rate</span>
                            </div>
                        </div>
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
                <div class="metric-value" id="metric-total-applications"><?= number_format($dashboard_metrics['total_applications'] ?? 0) ?></div>
                <div class="metric-change positive">
                    <span class="change-icon">•</span>
                    <span>Updated from database</span>
                </div>
            </div>
            
            <div class="metric-card success">
                <div class="metric-header">
                    <h4>Successful Hires</h4>
                </div>
                <div class="metric-value" id="metric-successful-hires"><?= number_format($dashboard_metrics['successful_hires'] ?? 0) ?></div>
                <div class="metric-change positive">
                    <span class="change-icon">•</span>
                    <span>Updated from database</span>
                </div>
            </div>
            
            <div class="metric-card warning">
                <div class="metric-header">
                    <h4>Avg. Time to Hire</h4>
                </div>
                <div class="metric-value" id="metric-avg-time"><?= number_format($dashboard_metrics['avg_time_to_hire'] ?? 0) ?> days</div>
                <div class="metric-change negative">
                    <span class="change-icon">•</span>
                    <span>Updated from database</span>
                </div>
            </div>
            
            <div class="metric-card info">
                <div class="metric-header">
                    <h4>Cost per Hire</h4>
                </div>
                <div class="metric-value" id="metric-cost-per-hire">$<?= number_format((float)($dashboard_metrics['cost_per_hire'] ?? 0), 0) ?></div>
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
                        <p class="stage-number" id="funnel-total-applications"><?= number_format($funnel_stats['total_applications'] ?? 0) ?></p>
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
                        <p class="stage-number" id="funnel-screening-pass"><?= number_format($funnel_stats['screening_passed'] ?? 0) ?></p>
                        <p class="stage-percentage" id="funnel-screening-rate"><?= $conversion_rates['screening_rate'] ?? 0 ?>% pass rate</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Pass Through</span>
                    <span class="stat-value" id="funnel-pass-through"><?= $funnel_stats['screening_passed'] ?? 0 ?> / <?= $funnel_stats['total_applications'] ?? 0 ?></span>
                </div>
            </div>

            <div class="data-summary-card stage-interviews">
                <div class="stage-info">
                    <div class="stage-details">
                        <h4>Interviews Scheduled</h4>
                        <p class="stage-number" id="funnel-interviews"><?= number_format($funnel_stats['interviews_scheduled'] ?? 0) ?></p>
                        <p class="stage-percentage" id="funnel-interviews-pct"><?= round((($funnel_stats['interviews_scheduled'] ?? 0) / max(1, $funnel_stats['total_applications'] ?? 1)) * 100, 1) ?>% of applications</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Conversion</span>
                    <span class="stat-value" id="funnel-interview-rate"><?= $conversion_rates['interview_rate'] ?? 0 ?>% from screening</span>
                </div>
            </div>

            <div class="data-summary-card stage-offers">
                <div class="stage-info">
                    <div class="stage-details">
                        <h4>Offers Extended</h4>
                        <p class="stage-number" id="funnel-offers"><?= number_format($funnel_stats['offers_extended'] ?? 0) ?></p>
                        <p class="stage-percentage" id="funnel-offers-pct"><?= round((($funnel_stats['offers_extended'] ?? 0) / max(1, $funnel_stats['total_applications'] ?? 1)) * 100, 1) ?>% of applications</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Offer Rate</span>
                    <span class="stat-value" id="funnel-offer-rate"><?= $conversion_rates['offer_rate'] ?? 0 ?>% from interviews</span>
                </div>
            </div>

            <div class="data-summary-card stage-hires">
                <div class="stage-info">
                    <div class="stage-details">
                        <h4>Successful Hires</h4>
                        <p class="stage-number" id="funnel-hires"><?= number_format($funnel_stats['successful_hires'] ?? 0) ?></p>
                        <p class="stage-percentage" id="funnel-hires-pct"><?= round((($funnel_stats['successful_hires'] ?? 0) / max(1, $funnel_stats['total_applications'] ?? 1)) * 100, 1) ?>% overall success</p>
                    </div>
                </div>
                <div class="stage-stats">
                    <span class="stat-label">Acceptance</span>
                    <span class="stat-value" id="funnel-hire-rate"><?= $conversion_rates['hire_rate'] ?? 0 ?>% offer acceptance</span>
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
                <tbody id="timeline-table-body">
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
                    <tbody id="department-table-body">
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
                            <td><strong id="department-total-applications"><?= number_format($total_apps) ?></strong></td>
                            <td><strong id="department-total-hires"><?= number_format($total_hires_count) ?></strong></td>
                            <td><strong id="department-total-rate"><?= $total_apps > 0 ? number_format(($total_hires_count / $total_apps) * 100, 1) : 0 ?>%</strong></td>
                            <td><strong>100%</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Application Sources -->
        <div class="table-card">
            <div class="table-header">
                <h4>Application Sources <span style="font-size: 0.8rem; color: #666; font-weight: normal;">(Live from tracked application records)</span></h4>
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
                    <tbody id="sources-table-body">
                        <?php if (!empty($application_sources)): ?>
                            <?php foreach ($application_sources as $source): ?>
                                <?php
                                $sourceRate = (float)($source['success_rate'] ?? 0);
                                $sourceRateClass = $sourceRate >= 8 ? 'rate-excellent' : ($sourceRate >= 5 ? 'rate-good' : 'rate-average');
                                ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($source['source']) ?></strong></td>
                                    <td><?= number_format((int)($source['applications'] ?? 0)) ?></td>
                                    <td><?= number_format((int)($source['hires'] ?? 0)) ?></td>
                                    <td><span class="<?= $sourceRateClass ?>"><?= number_format($sourceRate, 1) ?>%</span></td>
                                    <td><?= number_format((float)($source['percent_total'] ?? 0), 1) ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem;">No source data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <?php
                        $sourcesTotalApplications = 0;
                        $sourcesTotalHires = 0;
                        if (!empty($application_sources)) {
                            foreach ($application_sources as $source) {
                                $sourcesTotalApplications += (int)($source['applications'] ?? 0);
                                $sourcesTotalHires += (int)($source['hires'] ?? 0);
                            }
                        }
                        $sourcesTotalRate = $sourcesTotalApplications > 0
                            ? number_format(($sourcesTotalHires / $sourcesTotalApplications) * 100, 1)
                            : number_format(0, 1);
                        ?>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong id="sources-total-applications"><?= number_format($sourcesTotalApplications) ?></strong></td>
                            <td><strong id="sources-total-hires"><?= number_format($sourcesTotalHires) ?></strong></td>
                            <td><strong id="sources-total-rate"><?= $sourcesTotalRate ?>%</strong></td>
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
                    <tbody id="top-jobs-table-body">
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
                    <tbody id="interviewer-table-body">
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
    border-radius: 18px;
    padding: 2rem;
    margin-bottom: 1.1rem;
    color: #fff;
    box-shadow: 0 14px 28px rgba(86, 76, 207, 0.22);
}

.hero-title {
    margin: 0 0 0.5rem;
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
}

.hero-description {
    margin: 0;
    color: rgba(255, 255, 255, 0.92);
}

.hero-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 0.9rem;
    margin-top: 1rem;
}

.hero-stat {
    background: rgba(255, 255, 255, 0.16);
    border: 1px solid rgba(255, 255, 255, 0.26);
    border-radius: 12px;
    padding: 0.7rem 1rem;
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
    font-size: 0.8rem;
    margin-top: 0.3rem;
    color: rgba(255, 255, 255, 0.92);
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

.btn {
    border-radius: 10px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.64rem 1rem;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.25s ease;
}

.btn-sm {
    padding: 0.45rem 0.72rem;
    font-size: 0.8rem;
}

.btn-outline {
    background: #edf1ff;
    color: #4052b5;
    border: 1px solid #dbe3ff;
}

.btn-outline:hover {
    background: #e5ebff;
}

.filter-section,
.metrics-dashboard,
.data-section,
.table-card {
    background: #fff;
    border: 1px solid var(--card-border);
    border-radius: 14px;
    box-shadow: var(--card-shadow);
}

.filter-section,
.data-section,
.table-card {
    padding: 1.15rem;
    margin-bottom: 1rem;
}

.metrics-dashboard {
    padding: 1rem;
    margin-bottom: 1rem;
}

.filter-header,
.section-header,
.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
}

.filter-header,
.section-header,
.table-header {
    border-bottom: 1px solid #ececf5;
    padding-bottom: 0.75rem;
    margin-bottom: 0.9rem;
}

.filter-header h3,
.section-header h3,
.table-header h4 {
    margin: 0;
    color: #3d3e8e;
}

.filter-controls {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.8rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.45rem;
}

.filter-group label {
    font-weight: 600;
    color: #4d5470;
    font-size: 0.84rem;
}

.filter-select {
    padding: 0.62rem 0.7rem;
    border: 1px solid #d8def2;
    border-radius: 8px;
    font-size: 0.86rem;
    color: var(--text-primary);
    background: #fafbff;
}

.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 0.8rem;
}

.metric-card {
    background: #fff;
    border: 1px solid #ebeef8;
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 4px 14px rgba(86, 76, 207, 0.06);
    position: relative;
    overflow: hidden;
}

.metric-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
}

.metric-card.primary::before { background: #5848cb; }
.metric-card.success::before { background: #1f8d56; }
.metric-card.warning::before { background: #b96a11; }
.metric-card.info::before { background: #2879c6; }

.metric-header h4 {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.84rem;
    font-weight: 600;
}

.metric-value {
    font-size: 1.9rem;
    font-weight: 800;
    color: #3d3e8e;
    margin: 0.3rem 0 0.5rem;
}

.metric-change {
    display: inline-flex;
    align-items: center;
    gap: 0.28rem;
    padding: 0.18rem 0.5rem;
    border-radius: 999px;
    font-size: 0.77rem;
    font-weight: 600;
}

.metric-change.positive {
    background: #e9f8ef;
    color: #1f8d56;
}

.metric-change.negative {
    background: #fff4e5;
    color: #b96a11;
}

.data-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 0.8rem;
}

.data-summary-card {
    background: #fafbff;
    border: 1px solid #eceff9;
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.25s ease;
}

.data-summary-card:hover,
.table-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--hover-shadow);
}

.stage-details h4 {
    margin: 0 0 0.45rem;
    color: #515870;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.stage-number {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0.2rem 0;
    line-height: 1;
}

.stage-percentage {
    margin: 0.18rem 0 0;
    color: var(--text-secondary);
    font-size: 0.82rem;
}

.stage-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.5rem;
    border-top: 1px solid #edf0f8;
    padding-top: 0.55rem;
    margin-top: 0.6rem;
}

.stat-label,
.stat-value,
.stat-change {
    font-size: 0.78rem;
}

.stat-label {
    color: #687087;
    font-weight: 600;
}

.stat-value,
.stat-change {
    color: #3f4560;
    font-weight: 700;
}

.timeline-table tbody tr,
.data-table tbody tr {
    transition: background-color 0.2s ease;
}

.timeline-table tbody tr:hover,
.data-table tbody tr:hover {
    background-color: #f8f9ff;
}

.trend-up {
    color: #1f8d56;
    font-weight: 700;
}

.trend-down {
    color: #b63858;
    font-weight: 700;
}

.tables-grid,
.tables-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(440px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.table-container {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead th {
    text-align: left;
    background: #f7f8ff;
    color: #4e5395;
    padding: 0.68rem;
    border-bottom: 1px solid #ececf5;
    font-size: 0.82rem;
}

.data-table tbody td,
.data-table tfoot td {
    padding: 0.68rem;
    border-bottom: 1px solid #f0f2f9;
    color: var(--text-primary);
    font-size: 0.84rem;
}

.data-table tfoot {
    background: #f9faff;
    font-weight: 700;
}

.dept-name {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    font-weight: 700;
}

.dept-color {
    width: 10px;
    height: 10px;
    border-radius: 999px;
    display: inline-block;
}

.dept-color.engineering { background: #5848cb; }
.dept-color.design { background: #7b4ccf; }
.dept-color.marketing { background: #1f8d56; }
.dept-color.sales { background: #b96a11; }

.rate-excellent { color: #1f8d56; font-weight: 700; }
.rate-good { color: #2879c6; font-weight: 700; }
.rate-average { color: #b96a11; font-weight: 700; }
.rate-poor { color: #b63858; font-weight: 700; }

@media (max-width: 768px) {
    .dashboard-content {
        padding: 1rem;
    }

    .hero-section {
        padding: 1.25rem;
    }

    .hero-title {
        font-size: 1.6rem;
    }

    .filter-controls,
    .metrics-grid,
    .data-grid,
    .tables-grid,
    .tables-section {
        grid-template-columns: 1fr;
    }

    .section-header,
    .table-header {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<script>
function exportReport() {
    alert('Exporting current report as PDF...');
}

function scheduleReport() {
    alert('Opening report scheduling dialog...');
}

function resetFilters() {
    document.querySelectorAll('.filter-select').forEach(select => {
        select.selectedIndex = 0;
    });
    generateReport();
}

function changeReportType(type) {
    alert(`Switching to ${type} report view...`);
}

function exportData(dataType) {
    alert(`Exporting ${dataType} data as CSV...`);
}

function viewInterviewerDetails() {
    alert('Opening detailed interviewer performance...');
}

function generateReport() {
    alert('Regenerating report with current filters...');
}

document.addEventListener('DOMContentLoaded', function() {
    const rootUrl = '<?= ROOT ?>';

    document.querySelectorAll('.data-summary-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

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

    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPath)) {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        }
    });

    const setText = (id, value) => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value;
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

    const formatNumber = (value) => Number(value || 0).toLocaleString();

    const formatDateRange = (start, end) => {
        const format = (dateValue) => {
            const date = new Date(dateValue);
            if (Number.isNaN(date.getTime())) {
                return '';
            }
            return date.toLocaleDateString(undefined, { month: 'short', day: '2-digit' });
        };

        return `${format(start)} - ${format(end)}`.trim();
    };

    const getRateClass = (value) => {
        const rate = Number(value || 0);
        if (rate >= 30) {
            return 'rate-excellent';
        }
        if (rate >= 20) {
            return 'rate-good';
        }
        return 'rate-average';
    };

    const renderTimeline = (rows) => {
        const body = document.getElementById('timeline-table-body');
        if (!body) {
            return;
        }

        if (!Array.isArray(rows) || rows.length === 0) {
            body.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px;"><p style="color:#6c757d;">No application data available for the selected period.</p></td></tr>';
            return;
        }

        let previousCount = null;
        body.innerHTML = rows.map((week) => {
            const current = Number(week.total_applications || 0);
            let changeHtml = '<span>-</span>';
            if (previousCount !== null && previousCount > 0) {
                const change = ((current - previousCount) / previousCount) * 100;
                const changeClass = change >= 0 ? 'trend-up' : 'trend-down';
                changeHtml = `<span class="${changeClass}">${change >= 0 ? '+' : ''}${change.toFixed(1)}%</span>`;
            }
            previousCount = current;

            return `
                <tr>
                    <td><strong>${escapeHtml(week.period || '')}</strong><br><small>${escapeHtml(formatDateRange(week.week_start, week.week_end))}</small></td>
                    <td>${formatNumber(week.total_applications)}</td>
                    <td>${changeHtml}</td>
                    <td>${formatNumber(week.screenings)}</td>
                    <td>${formatNumber(week.interviews)}</td>
                    <td>${formatNumber(week.offers)}</td>
                    <td>${formatNumber(week.hires)}</td>
                </tr>
            `;
        }).join('');
    };

    const renderDepartmentStats = (rows) => {
        const body = document.getElementById('department-table-body');
        if (!body) {
            return;
        }

        let totalApplications = 0;
        let totalHires = 0;

        if (!Array.isArray(rows) || rows.length === 0) {
            body.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:2rem;">No department data available</td></tr>';
            setText('department-total-applications', '0');
            setText('department-total-hires', '0');
            setText('department-total-rate', '0.0%');
            return;
        }

        const allApplications = rows.reduce((sum, dept) => sum + Number(dept.total_applications || 0), 0);

        body.innerHTML = rows.map((dept) => {
            const applications = Number(dept.total_applications || 0);
            const hires = Number(dept.hires || 0);
            totalApplications += applications;
            totalHires += hires;
            const successRate = applications > 0 ? (hires / applications) * 100 : 0;
            const rateClass = successRate >= 8 ? 'rate-excellent' : (successRate >= 5 ? 'rate-good' : 'rate-average');
            const percentTotal = allApplications > 0 ? (applications / allApplications) * 100 : 0;

            return `
                <tr>
                    <td><div class="dept-name"><span class="dept-color engineering"></span>${escapeHtml(dept.department_name || '')}</div></td>
                    <td>${formatNumber(applications)}</td>
                    <td>${formatNumber(hires)}</td>
                    <td><span class="${rateClass}">${successRate.toFixed(1)}%</span></td>
                    <td>${percentTotal.toFixed(1)}%</td>
                </tr>
            `;
        }).join('');

        const overallRate = totalApplications > 0 ? ((totalHires / totalApplications) * 100).toFixed(1) : '0.0';
        setText('department-total-applications', formatNumber(totalApplications));
        setText('department-total-hires', formatNumber(totalHires));
        setText('department-total-rate', `${overallRate}%`);
    };

    const renderSourceStats = (rows) => {
        const body = document.getElementById('sources-table-body');
        if (!body) {
            return;
        }

        let totalApplications = 0;
        let totalHires = 0;

        if (!Array.isArray(rows) || rows.length === 0) {
            body.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:2rem;">No source data available</td></tr>';
            setText('sources-total-applications', '0');
            setText('sources-total-hires', '0');
            setText('sources-total-rate', '0.0%');
            return;
        }

        body.innerHTML = rows.map((source) => {
            const applications = Number(source.applications || 0);
            const hires = Number(source.hires || 0);
            const rate = Number(source.success_rate || 0);
            totalApplications += applications;
            totalHires += hires;
            const rateClass = rate >= 8 ? 'rate-excellent' : (rate >= 5 ? 'rate-good' : 'rate-average');

            return `
                <tr>
                    <td><strong>${escapeHtml(source.source || '')}</strong></td>
                    <td>${formatNumber(applications)}</td>
                    <td>${formatNumber(hires)}</td>
                    <td><span class="${rateClass}">${rate.toFixed(1)}%</span></td>
                    <td>${Number(source.percent_total || 0).toFixed(1)}%</td>
                </tr>
            `;
        }).join('');

        const totalRate = totalApplications > 0 ? ((totalHires / totalApplications) * 100).toFixed(1) : '0.0';
        setText('sources-total-applications', formatNumber(totalApplications));
        setText('sources-total-hires', formatNumber(totalHires));
        setText('sources-total-rate', `${totalRate}%`);
    };

    const renderTopJobs = (rows) => {
        const body = document.getElementById('top-jobs-table-body');
        if (!body) {
            return;
        }

        if (!Array.isArray(rows) || rows.length === 0) {
            body.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:2rem;">No job performance data available</td></tr>';
            return;
        }

        body.innerHTML = rows.map((job) => {
            const conversion = Number(job.conversion_rate || 0);
            const rateClass = getRateClass(conversion);
            const avgDays = job.avg_days_to_hire === null ? 'N/A' : `${Number(job.avg_days_to_hire).toFixed(0)} days`;

            return `
                <tr>
                    <td>${escapeHtml(job.job_title || '')}</td>
                    <td>${formatNumber(job.applications_count)}</td>
                    <td>${formatNumber(job.interviews_count)}</td>
                    <td>${formatNumber(job.hires_count)}</td>
                    <td><span class="${rateClass}">${conversion.toFixed(1)}%</span></td>
                    <td>${avgDays}</td>
                </tr>
            `;
        }).join('');
    };

    const renderInterviewerPerformance = (rows) => {
        const body = document.getElementById('interviewer-table-body');
        if (!body) {
            return;
        }

        if (!Array.isArray(rows) || rows.length === 0) {
            body.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:2rem;">No interviewer performance data available</td></tr>';
            return;
        }

        body.innerHTML = rows.map((interviewer) => {
            const hireRate = Number(interviewer.hire_rate || 0);
            const rateClass = getRateClass(hireRate);
            const avgRating = interviewer.avg_rating === null ? 'N/A' : `${Number(interviewer.avg_rating).toFixed(1)}/5`;
            const feedbackScore = interviewer.feedback_score === null ? 'N/A' : `${Number(interviewer.feedback_score).toFixed(1)}/5`;

            return `
                <tr>
                    <td>${escapeHtml(interviewer.interviewer_name || '')}</td>
                    <td>${formatNumber(interviewer.interviews_conducted)}</td>
                    <td>${avgRating}</td>
                    <td><span class="${rateClass}">${hireRate.toFixed(1)}%</span></td>
                    <td>${feedbackScore}</td>
                </tr>
            `;
        }).join('');
    };

    const applyReportData = (data) => {
        const funnel = data.funnel_stats || {};
        const conversion = data.conversion_rates || {};
        const metrics = data.dashboard_metrics || {};

        setText('hero-total-hires', Number(data.total_hires || 0));
        setText('hero-avg-time', Number(data.avg_time_to_hire || 0));
        setText('hero-success-rate', `${Number(data.success_rate || 0).toFixed(1)}%`);

        setText('metric-total-applications', formatNumber(metrics.total_applications));
        setText('metric-successful-hires', formatNumber(metrics.successful_hires));
        setText('metric-avg-time', `${formatNumber(metrics.avg_time_to_hire)} days`);
        setText('metric-cost-per-hire', `$${formatNumber(Math.round(Number(metrics.cost_per_hire || 0)))}`);

        const totalApplications = Number(funnel.total_applications || 0);
        const screening = Number(funnel.screening_passed || 0);
        const interviews = Number(funnel.interviews_scheduled || 0);
        const offers = Number(funnel.offers_extended || 0);
        const hires = Number(funnel.successful_hires || 0);

        setText('funnel-total-applications', formatNumber(totalApplications));
        setText('funnel-screening-pass', formatNumber(screening));
        setText('funnel-screening-rate', `${Number(conversion.screening_rate || 0).toFixed(1)}% pass rate`);
        setText('funnel-pass-through', `${screening} / ${totalApplications}`);
        setText('funnel-interviews', formatNumber(interviews));
        setText('funnel-interviews-pct', `${totalApplications > 0 ? ((interviews / totalApplications) * 100).toFixed(1) : '0.0'}% of applications`);
        setText('funnel-interview-rate', `${Number(conversion.interview_rate || 0).toFixed(1)}% from screening`);
        setText('funnel-offers', formatNumber(offers));
        setText('funnel-offers-pct', `${totalApplications > 0 ? ((offers / totalApplications) * 100).toFixed(1) : '0.0'}% of applications`);
        setText('funnel-offer-rate', `${Number(conversion.offer_rate || 0).toFixed(1)}% from interviews`);
        setText('funnel-hires', formatNumber(hires));
        setText('funnel-hires-pct', `${totalApplications > 0 ? ((hires / totalApplications) * 100).toFixed(1) : '0.0'}% overall success`);
        setText('funnel-hire-rate', `${Number(conversion.hire_rate || 0).toFixed(1)}% offer acceptance`);

        renderTimeline(data.applications_timeline || []);
        renderDepartmentStats(data.department_stats || []);
        renderSourceStats(data.application_sources || []);
        renderTopJobs(data.top_performing_jobs || []);
        renderInterviewerPerformance(data.interviewer_performance || []);
    };

    const refreshReportData = async () => {
        try {
            const response = await fetch(`${rootUrl}/hradmin/reports/liveData`, {
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

            applyReportData(payload.data);
        } catch (error) {
        }
    };

    refreshReportData();
    setInterval(refreshReportData, 30000);
});
</script>

        </div>
    </div>

<?php $this->view('components/footer') ?>
