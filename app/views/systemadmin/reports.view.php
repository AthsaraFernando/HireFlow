<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Reports</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/table.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/alert.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/dashboard.style.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/system-admin.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">

    <style>
        .reports-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .reports-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 10px;
            margin-top: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.3em;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .stat-card:hover::before {
            transform: translateX(0);
        }

        .stat-value {
            font-size: 2em;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9em;
            opacity: 0.9;
            color: white;
            padding: 10px;
        }

        .chart-container {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            position: relative;
            height: 300px;
        }

        .chart-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #666;
            font-style: italic;
        }

        .report-filters {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .reports-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .reports-table th,
        .reports-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        .reports-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        .log-level {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: 500;
        }

        .level-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .level-warning {
            background: #fff3cd;
            color: #856404;
        }

        .level-error {
            background: #f8d7da;
            color: #721c24;
        }

        .export-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .progress-bar {
            width: 100%;
            height: 20px;
            background: #ecf0f1;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #3498db, #2ecc71);
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .action-button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: white;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            text-decoration: none;
            color: #2c3e50;
            transition: all 0.3s ease;
        }

        .action-button:hover {
            border-color: #3498db;
            background: #f8f9fa;
        }

        .parent-chart-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 25px;
        }

        .profile_picture {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.3);
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
    
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/dashboard" class="nav-link">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/usermanage" class="nav-link">
                        <span class="nav-text">Manage Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/reports" class="nav-link active">
                        <span class="nav-text">Reports & Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/accesslogs" class="nav-link">
                        <span class="nav-text">Access Logs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/backuprestore" class="nav-link">
                        <span class="nav-text">Backup & Restore</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/announcements" class="nav-link">
                        <span class="nav-text">Announcements</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/profile" class="nav-link">
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
                    < </button>
                        <h1 class="page-title">System Reports</h1>
            </div>

            <div class="header-right">
             

                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">System Administrator</span>
                    </div>
                    <?php
                    $defaultProfileImage = 'default-avatar.jpg';
                    $profileImage = $defaultProfileImage;

                    if (!empty($_SESSION['USER']['profile_picture'])) {
                        $basePath = dirname(dirname(dirname(__DIR__)));
                        $profileImageFile = $basePath . '/public/assets/images/profiles/' . $_SESSION['USER']['profile_picture'];

                        if (file_exists($profileImageFile)) {
                            $profileImage = $_SESSION['USER']['profile_picture'];
                        }
                    }
                    ?>
                    <img src="<?= ROOT ?>/assets/images/profiles/<?= $profileImage ?>" alt="" class="profile_picture">
                   
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="reports-container" style="padding: 30px; margin: 0; max-width: none;">
                <div class="page-header">
                    
                </div>

                <!-- Report Filters -->
                <div style="display: none;" class="reports-section">
                    <h2 class="section-title">Report Filters</h2>
                    <div class="report-filters">
                        <div class="filter-grid">
                            <div class="form-group">
                                <label for="date_range" class="form-label">Date Range</label>
                                <select id="date_range" class="form-input">
                                    <option value="today">Today</option>
                                    <option value="week" selected>Last 7 Days</option>
                                    <option value="month">Last 30 Days</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="report_type" class="form-label">Report Type</label>
                                <select id="report_type" class="form-input">
                                    <option value="overview" selected>System Overview</option>
                                    <option value="users">User Activity</option>
                                    <option value="errors">Error Logs</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="export_format" class="form-label">Export Format</label>
                                <select id="export_format" class="form-input">
                                    <option value="pdf">PDF Report</option>
                                    <option value="excel">Excel Spreadsheet</option>
                                    <option value="csv">CSV Data</option>
                                    <option value="json">JSON Data</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <button class="btn btn-primary" onclick="generateReport()">Generate Report</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Overview -->
                <div class="reports-section">
                    <h2 class="section-title">System Overview</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-value"><?= number_format($data['system_stats']['total_users']) ?></div>
                            <div class="stat-label">Total Users</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= $data['system_stats']['total_jobs'] ?></div>
                            <div class="stat-label">Job Postings</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= number_format($data['system_stats']['total_applications']) ?>
                            </div>
                            <div class="stat-label">Applications</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= $data['system_stats']['database_size'] ?></div>
                            <div class="stat-label">Database Size</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= $data['system_stats']['total_interviews'] ?></div>
                            <div class="stat-label">Total Interviews</div>
                        </div>
                    </div>
                </div>

                <div class="parent-chart-container">
                    <!-- User Activity Chart -->
                    <div class="reports-section">
                        <h2 class="section-title"> User Activity Trends</h2>
                        <div class="export-buttons">
                            <button class="btn btn-outline-secondary" onclick="downloadData('user_activity')">
                                Download Data
                            </button>
                            <form method="POST" id="filterForm" action="<?= ROOT ?>/systemadmin/reports"
                                class="filter-form">
                                <div class="filter-group">
                                    <!-- <label>Filter by Duration</label> -->
                                    <select name="duration" class="filter-select" id="actionFilter">
                                        <!-- <select name="duration" onchange="this.form.submit()"></select> -->
                                        <option value="10">Last 10 days</option>
                                        <option value="20" selected>Last 20 days</option>
                                        <option value="30">Last 30 days</option>
                                        <option value="60">Last 60 days</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <canvas id="myChart" width="400" height="200"></canvas>
                            </div>
                        </div>

                    </div>

                    <div class="reports-section">
                        <h2 class="section-title">Department Job Posting Overview</h2>
                        <div class="export-buttons">

                            <button class="btn btn-outline-secondary" onclick="downloadData('job_posting_overview')">
                                Download Data
                            </button>
                        </div>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <canvas id="myChart2" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>


                    <!-- Interview Progress -->
                    <div class="reports-section">
                        <h2 class="section-title">Interviewing Progress</h2>
                        <div class="export-buttons">
                            <button class="btn btn-outline-secondary" onclick="downloadData('interviewing_progress')">
                                Download Data
                            </button>
                            <form method="POST" id="filterForm" action="<?= ROOT ?>/systemadmin/reports"
                                class="filter-form">
                                <div class="filter-group">
                                    <!-- <label>Filter by Duration</label> -->
                                    <select name="duration" class="filter-select" id="actionFilter1">
                                        <!-- <select name="duration" onchange="this.form.submit()"></select> -->
                                        <option value="10">Last 10 days</option>
                                        <option value="20" selected>Last 20 days</option>
                                        <option value="30">Last 30 days</option>
                                        <option value="60">Last 60 days</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <canvas id="myChart3" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="reports-section">
                        <h2 class="section-title">User Status Overview</h2>
                        <div class="export-buttons">

                            <button class="btn btn-outline-secondary" onclick="downloadData('user_status')">
                                Download Data
                            </button>
                        </div>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <canvas id="myChart4" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="reports-section">
                        <h2 class="section-title">Job Demand Stats</h2>
                        <div class="export-buttons">

                            <button class="btn btn-outline-secondary" onclick="downloadData('job_demand')">
                                Download Data
                            </button>
                        </div>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <canvas id="myChart5" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="reports-section">
                        <h2 class="section-title">Application Stage Summary</h2>
                        <div class="export-buttons">

                            <button class="btn btn-outline-secondary"
                                onclick="downloadData('application_status_counts')">
                                Download Data
                            </button>
                        </div>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <canvas id="myChart6" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="reports-section">
                        <h2 class="section-title">Report</h2>
                        <div class="export-buttons">

                            <button class="btn btn-outline-secondary" onclick="downloadData('')">
                                Download Data
                            </button>
                        </div>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <canvas id="myChart7" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="text-center mt-4">
                    <a href="<?= ROOT ?>/systemadmin/dashboard" class="btn btn-outline-secondary">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>

            <?php $this->view('components/footer') ?>

            <script src="<?= ROOT ?>/assets/js/main.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                function generateReport() {
                    const dateRange = document.getElementById('date_range').value;
                    const reportType = document.getElementById('report_type').value;
                    const exportFormat = document.getElementById('export_format').value;
                }

                const whiteBackgroundPlugin = {
                    id: 'custom_canvas_background_color',
                    beforeDraw: (chart) => {
                        const ctx = chart.ctx;
                        ctx.save();
                        ctx.globalCompositeOperation = 'destination-over';
                        ctx.fillStyle = '#f8f9fa';
                        ctx.fillRect(0, 0, chart.width, chart.height);
                        ctx.restore();
                    }
                };
                Chart.register(whiteBackgroundPlugin);
                Chart.defaults.devicePixelRatio = 3;

                let userChart1;
                let userChart2;
                let userChart3;
                let userChart4;
                let userChart5;
                let userChart6;

                function filterStatsByDays(data, days) {
                    const now = new Date();
                    return data.filter(row => {
                        const date = new Date(row.log_date || row.scheduled_date);
                        const diffDays = (now - date) / (1000 * 60 * 60 * 24);
                        return diffDays <= days;
                    });
                }
                const userActivityStats = <?= json_encode($data['user_activity']); ?>;
                function userActivityChart(days = 20) {
                    // console.log(stats);
                    const filteredStats = filterStatsByDays(userActivityStats, days);
                    const labels = filteredStats.map(row => row.log_date);
                    const logins = filteredStats.map(row => row.logins);
                    const registrations = filteredStats.map(row => row.registrations);
                    const applications = filteredStats.map(row => row.applications_submitted);

                    const ctx = document.getElementById('myChart').getContext('2d');

                    // destroy previous chart (VERY IMPORTANT)
                    if (userChart1) {
                        userChart1.destroy();
                    }

                    userChart1 = new Chart(ctx, {   
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                { label: 'Logins', data: logins, borderWidth: 2 },
                                { label: 'Registrations', data: registrations, borderWidth: 2 },
                                { label: 'Applications Submitted', data: applications, borderWidth: 2 }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 }
                                }
                            }
                        }
                    });
                }
                const select = document.getElementById('actionFilter');
                userActivityChart(parseInt(select.value));
                select.addEventListener('change', function () {
                    const days = parseInt(this.value);
                    userActivityChart(days);
                });
                // userActivityChart();

                function jobPostStatChart() {
                    const stats = <?= json_encode($data['jobpost_stats']); ?>;
                    const labels = stats.map(row => row.department_name);
                    const count = stats.map(row => row.job_count);

                    const ctx = document.getElementById('myChart2').getContext('2d');

                    userChart2 = new Chart(ctx, {   // store in global variable
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                { label: 'Number of jobs', data: count, borderWidth: 2 },
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 }
                                }
                            }
                        }
                    });
                }
                jobPostStatChart()


                const interviewingStats = <?= json_encode($data['interview_stats']); ?>;
                function interviewStatChart(days = 20) {
                    const filteredStats = filterStatsByDays(interviewingStats, days);
                    const labels = filteredStats.map(row => row.scheduled_date);
                    const scheduledCount = filteredStats.map(row => row.scheduledCount);


                    const ctx = document.getElementById('myChart3').getContext('2d');

                    if (userChart3) {
                        userChart3.destroy();
                    }

                    userChart3 = new Chart(ctx, {   
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                { label: 'Scheduled', data: scheduledCount, borderWidth: 2 },
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    // ticks: { precision: 0 }
                                    min: 0,
                                    max: 10

                                }
                            }
                        }
                    });
                }
                const select1 = document.getElementById('actionFilter1');
                interviewStatChart(parseInt(select1.value));
                select1.addEventListener('change', function () {
                    const days = parseInt(this.value);
                    interviewStatChart(days);
                });
                // interviewStatChart()

                function userStatusChart() {
                    const stats = <?= json_encode($data['user_status']); ?>;
                    const labels = stats.map(row => row.status);
                    const statusCount = stats.map(row => row.statusCount);


                    const ctx = document.getElementById('myChart4').getContext('2d');

                    userChart4 = new Chart(ctx, {   
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [
                                { label: 'Counts', data: statusCount, borderWidth: 2 },
                            ]
                        },
                        options: {
                            responsive: true,
                        }
                    });
                }
                userStatusChart();

                function jobDemandChart() {

                    const stats = <?= json_encode($data['job_demand']); ?>;
                    const labels = stats.map(row => row.title);
                    const applicationCount = stats.map(row => row.applicationCount);


                    const ctx = document.getElementById('myChart5').getContext('2d');

                    userChart5 = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                { label: 'Applications', data: applicationCount, borderWidth: 2 },
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 }
                                }
                            }
                        }
                    });
                }
                jobDemandChart();

                function applicationStageCountChart() {
                    const stats = <?= json_encode($data['application_status_counts']); ?>;
                    const labels = stats.map(row => row.status);
                    const counts = stats.map(row => row.counts);

                    const ctx = document.getElementById('myChart6').getContext('2d');
                    userChart6 = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                { label: 'Application Count', data: counts, borderWidth: 2 },
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 }
                                }
                            }
                        }
                    });

                }
                applicationStageCountChart();




                function exportChart(chartType) {
                    showToast(`Exporting ${chartType} chart...`, 'info');
                    
                }

                function downloadData(dataType) {
                    // showToast(`Downloading ${dataType} data...`, 'info');
                    const select = document.getElementById('actionFilter');
                    const select1 = document.getElementById('actionFilter1');
                    const now = new Date();
                    const formattedDate =
                        now.getFullYear() +
                        String(now.getMonth() + 1).padStart(2, '0') +
                        String(now.getDate()).padStart(2, '0') + '_' +
                        String(now.getHours()).padStart(2, '0') +
                        String(now.getMinutes()).padStart(2, '0') +
                        String(now.getSeconds()).padStart(2, '0');

                    if (!userChart1 || !userChart2 || !userChart3) return;
                    switch (dataType) {
                        case 'user_activity':
                            const url1 = userChart1.toBase64Image();
                            const a1 = document.createElement('a');
                            a1.href = url1;
                            a1.download = `user_activity_${select.value}d_${formattedDate}.png`;
                            a1.click();
                            break;
                        case 'job_posting_overview':
                            const url2 = userChart2.toBase64Image();
                            const a2 = document.createElement('a');
                            a2.href = url2;
                            a2.download = `job_posting_overview_${formattedDate}.png`;
                            a2.click();
                            break;
                        case 'interviewing_progress':
                            const url3 = userChart3.toBase64Image();
                            const a3 = document.createElement('a');
                            a3.href = url3;
                            a3.download = `interviewing_progress_${select1.value}d_${formattedDate}.png`;
                            a3.click();
                            break;
                        case 'user_status':
                            const url4 = userChart4.toBase64Image();
                            const a4 = document.createElement('a');
                            a4.href = url4;
                            a4.download = `user_status_${formattedDate}.png`;
                            a4.click();
                            break;
                        case 'job_demand':
                            const url5 = userChart5.toBase64Image();
                            const a5 = document.createElement('a');
                            a5.href = url5;
                            a5.download = `job_demand_${formattedDate}.png`;
                            a5.click();
                            break;
                        case 'application_status_counts':
                            const url6 = userChart6.toBase64Image();
                            const a6 = document.createElement('a');
                            a6.href = url6;
                            a6.download = `application_status_counts_${formattedDate}.png`;
                            a6.click();
                            break;
                        default:
                            console.log('Unknown data type:', dataType);
                    }

                   
                }

                function showToast(message, type) {
                    const toast = document.createElement('div');
                    toast.className = `alert alert-${type}`;
                    toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
                min-width: 300px;
                animation: slideIn 0.3s ease;
            `;
                    toast.textContent = message;

                    document.body.appendChild(toast);

                    setTimeout(() => {
                        toast.style.animation = 'slideOut 0.3s ease';
                        setTimeout(() => toast.remove(), 300);
                    }, 3000);
                }

                // Auto-refresh data every 30 seconds
                setInterval(() => {
                    console.log('Refreshing report data...');
                }, 30000);

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

                // document.getElementById('actionFilter').addEventListener('change', function () {
                //     document.getElementById('filterForm').submit();
                // })
            </script>

        </div>
    </div>
</body>

</html>