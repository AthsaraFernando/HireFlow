<?php
// Sample report data - in real implementation this would come from database queries
$system_stats = [
    'total_users' => 127,
    'active_sessions' => 15,
    'total_jobs' => 45,
    'total_applications' => 234,
    'server_uptime' => '15 days, 6 hours',
    'database_size' => '45.2 MB',
    'storage_used' => '2.1 GB',
    'avg_response_time' => '245ms'
];

$user_activity = [
    ['date' => '2025-08-31', 'logins' => 24, 'registrations' => 3, 'applications' => 18],
    ['date' => '2025-08-30', 'logins' => 31, 'registrations' => 5, 'applications' => 22],
    ['date' => '2025-08-29', 'logins' => 28, 'registrations' => 2, 'applications' => 15],
    ['date' => '2025-08-28', 'logins' => 35, 'registrations' => 7, 'applications' => 28],
    ['date' => '2025-08-27', 'logins' => 29, 'registrations' => 4, 'applications' => 19]
];

$error_logs = [
    ['time' => '2025-08-31 14:30:15', 'level' => 'WARNING', 'message' => 'High memory usage detected (85%)', 'source' => 'System Monitor'],
    ['time' => '2025-08-31 12:45:22', 'level' => 'ERROR', 'message' => 'Failed to send email notification to user@example.com', 'source' => 'Email Service'],
    ['time' => '2025-08-31 10:15:08', 'level' => 'INFO', 'message' => 'Database backup completed successfully', 'source' => 'Backup Service'],
    ['time' => '2025-08-31 09:30:45', 'level' => 'WARNING', 'message' => 'Slow query detected: SELECT * FROM applications (2.3s)', 'source' => 'Database']
];

$popular_pages = [
    ['page' => '/applicant/browse-jobs', 'views' => 1245, 'unique_visitors' => 892],
    ['page' => '/applicant/dashboard', 'views' => 987, 'unique_visitors' => 654],
    ['page' => '/signin', 'views' => 756, 'unique_visitors' => 523],
    ['page' => '/hradmin/applications', 'views' => 432, 'unique_visitors' => 78],
    ['page' => '/applicant/job-details', 'views' => 398, 'unique_visitors' => 289]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Reports - HireFlow Admin</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/table.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/alert.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/dashboard.style.css">
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
            margin-bottom: 25px;
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
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">System Admin</p>
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
                <div class="header-notifications">
                    <button class="notification-btn"></button>
                </div>

                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">System Administrator</span>
                    </div>
                    <div class="user-avatar">
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="reports-container" style="padding: 30px; margin: 0; max-width: none;">
                <div class="page-header">
                    <h1>📊 System Reports</h1>
                    <p style="padding:20px;">Comprehensive system analytics and monitoring reports</p>
                </div>

                <!-- Report Filters -->
                <div class="reports-section">
                    <h2 class="section-title">🔍 Report Filters</h2>
                    <div class="report-filters">
                        <div class="filter-grid">
                            <div class="form-group">
                                <label for="date_range" class="form-label">Date Range</label>
                                <select id="date_range" class="form-input">
                                    <option value="today">Today</option>
                                    <option value="week" selected>Last 7 Days</option>
                                    <option value="month">Last 30 Days</option>
                                    <option value="quarter">Last 3 Months</option>
                                    <option value="year">Last Year</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="report_type" class="form-label">Report Type</label>
                                <select id="report_type" class="form-input">
                                    <option value="overview" selected>System Overview</option>
                                    <option value="users">User Activity</option>
                                    <option value="performance">Performance</option>
                                    <option value="security">Security</option>
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
                    <h2 class="section-title">📈 System Overview</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-value"><?= number_format($system_stats['total_users']) ?></div>
                            <div class="stat-label">Total Users</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= $system_stats['active_sessions'] ?></div>
                            <div class="stat-label">Active Sessions</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= $system_stats['total_jobs'] ?></div>
                            <div class="stat-label">Job Postings</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= number_format($system_stats['total_applications']) ?></div>
                            <div class="stat-label">Applications</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= $system_stats['server_uptime'] ?></div>
                            <div class="stat-label">Server Uptime</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= $system_stats['database_size'] ?></div>
                            <div class="stat-label">Database Size</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= $system_stats['storage_used'] ?></div>
                            <div class="stat-label">Storage Used</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?= $system_stats['avg_response_time'] ?></div>
                            <div class="stat-label">Avg Response Time</div>
                        </div>
                    </div>
                </div>

                <!-- User Activity Chart -->
                <!-- <div class="reports-section">
                    <h2 class="section-title">👥 User Activity Trends</h2>
                    <div class="export-buttons">
                        <button class="btn btn-outline-primary" onclick="exportChart('user_activity')">
                            📊 Export Chart
                        </button>
                        <button class="btn btn-outline-secondary" onclick="downloadData('user_activity')">
                            📄 Download Data
                        </button>
                    </div>
                    <div class="chart-container">
                        <div class="chart-placeholder">
                            📈 Interactive chart would be rendered here<br>
                            <small>Integration with Chart.js or similar library for production</small>
                        </div>
                    </div>

                    <table class="reports-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Logins</th>
                                <th>New Registrations</th>
                                <th>Applications Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user_activity as $activity): ?>
                                <tr>
                                    <td><?= date('M d, Y', strtotime($activity['date'])) ?></td>
                                    <td><?= $activity['logins'] ?></td>
                                    <td><?= $activity['registrations'] ?></td>
                                    <td><?= $activity['applications'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div> -->

                <!-- System Performance -->
                <!-- <div class="reports-section">
                    <h2 class="section-title">⚡ System Performance</h2>
                    <div class="form-grid">
                        <div>
                            <h4>Server Resources</h4>
                            <div>
                                <label>CPU Usage</label>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 45%;"></div>
                                </div>
                                <small>45% (Normal)</small>
                            </div>

                            <div>
                                <label>Memory Usage</label>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 68%;"></div>
                                </div>
                                <small>68% (Moderate)</small>
                            </div>

                            <div>
                                <label>Disk Usage</label>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 32%;"></div>
                                </div>
                                <small>32% (Low)</small>
                            </div>
                        </div>

                        <div>
                            <h4>Database Performance</h4>
                            <div>
                                <label>Query Performance</label>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 85%;"></div>
                                </div>
                                <small>Avg: 245ms (Good)</small>
                            </div>

                            <div>
                                <label>Connection Pool</label>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 24%;"></div>
                                </div>
                                <small>6/25 connections used</small>
                            </div>

                            <div>
                                <label>Cache Hit Rate</label>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 92%;"></div>
                                </div>
                                <small>92% (Excellent)</small>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Error Logs -->
                <!-- <div class="reports-section">
                    <h2 class="section-title">🚨 Recent System Events</h2>
                    <table class="reports-table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Level</th>
                                <th>Message</th>
                                <th>Source</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($error_logs as $log): ?>
                                <tr>
                                    <td><?= date('M d, H:i:s', strtotime($log['time'])) ?></td>
                                    <td>
                                        <span class="log-level level-<?= strtolower($log['level']) ?>">
                                            <?= $log['level'] ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($log['message']) ?></td>
                                    <td><?= htmlspecialchars($log['source']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div> -->

                <!-- Popular Pages -->
                <!-- <div class="reports-section">
                    <h2 class="section-title">🔗 Popular Pages</h2>
                    <table class="reports-table">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th>Total Views</th>
                                <th>Unique Visitors</th>
                                <th>Conversion Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($popular_pages as $page): ?>
                                <tr>
                                    <td><code><?= htmlspecialchars($page['page']) ?></code></td>
                                    <td><?= number_format($page['views']) ?></td>
                                    <td><?= number_format($page['unique_visitors']) ?></td>
                                    <td><?= round(($page['unique_visitors'] / $page['views']) * 100, 1) ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div> -->

                <!-- Quick Actions -->
                <div class="reports-section">
                    <h2 class="section-title">⚡ Quick Actions</h2>
                    <div class="quick-actions">
                        <a href="#" class="action-button" onclick="scheduleReport()">
                            📅 Schedule Automated Reports
                        </a>
                        <a href="#" class="action-button" onclick="clearCache()">
                            🗑️ Clear System Cache
                        </a>
                        <a href="#" class="action-button" onclick="optimizeDatabase()">
                            🔧 Optimize Database
                        </a>
                        <a href="#" class="action-button" onclick="exportAllData()">
                            📦 Export All System Data
                        </a>
                        <a href="<?= ROOT ?>/systemadmin/accesslogs" class="action-button">
                            📋 View Detailed Logs
                        </a>
                        <a href="#" class="action-button" onclick="systemHealthCheck()">
                            🩺 Run Health Check
                        </a>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="<?= ROOT ?>/systemadmin/dashboard" class="btn btn-outline-secondary">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>

            <?php  // include '../views/components/footer.view.php'; 
            $this->view('components/footer')

                ?>

            <script src="<?= ROOT ?>/assets/js/main.js"></script>
            <script>
                function generateReport() {
                    const dateRange = document.getElementById('date_range').value;
                    const reportType = document.getElementById('report_type').value;
                    const exportFormat = document.getElementById('export_format').value;

                    showToast(`Generating ${reportType} report for ${dateRange} in ${exportFormat} format...`, 'info');

                    // Simulate report generation
                    setTimeout(() => {
                        showToast('Report generated successfully! Check your downloads.', 'success');
                    }, 3000);
                }

                function exportChart(chartType) {
                    showToast(`Exporting ${chartType} chart...`, 'info');
                    // In real implementation, this would export chart as image
                }

                function downloadData(dataType) {
                    showToast(`Downloading ${dataType} data...`, 'info');
                    // In real implementation, this would download CSV/JSON data
                }

                function scheduleReport() {
                    showToast('Report scheduling feature coming soon', 'info');
                    // In real implementation, this would open a scheduling modal
                }

                function clearCache() {
                    if (confirm('Clear all system cache? This may temporarily slow down the system.')) {
                        showToast('System cache cleared successfully', 'success');
                        // In real implementation, this would clear cache
                    }
                }

                function optimizeDatabase() {
                    if (confirm('Optimize database tables? This may take a few minutes.')) {
                        showToast('Database optimization started...', 'info');
                        // In real implementation, this would optimize database
                        setTimeout(() => {
                            showToast('Database optimization completed', 'success');
                        }, 5000);
                    }
                }

                function exportAllData() {
                    if (confirm('Export all system data? This may take several minutes.')) {
                        showToast('Data export started. You will receive an email when complete.', 'info');
                        // In real implementation, this would start background export
                    }
                }

                function systemHealthCheck() {
                    showToast('Running system health check...', 'info');
                    // In real implementation, this would run comprehensive health check
                    setTimeout(() => {
                        showToast('System health check completed. All systems operational.', 'success');
                    }, 3000);
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
                    // In real implementation, this would fetch fresh data
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
            </script>

        </div>
    </div>
</body>

</html>