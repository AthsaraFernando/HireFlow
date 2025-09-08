<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/dashboard.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
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
                    <a href="<?= ROOT ?>/systemadmin/dashboard" class="nav-link active">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/usermanage" class="nav-link">
                        <span class="nav-text">Manage Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/reports" class="nav-link">
                        <span class="nav-text">Reports & Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/accesslogs" class="nav-link">
                        <span class="nav-text">Access Logs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/profile" class="nav-link">
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
                        <h1 class="page-title">Dashboard</h1>
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
            <?php if (!($is_system_admin ?? false)): ?>
                <div class="alert alert-info mb-4">
                    <h4>👁️ Viewing as <?= htmlspecialchars($user_role_name ?? 'Unknown Role') ?></h4>
                    <p>You are viewing the System Admin dashboard with limited permissions. Some features may be restricted or hidden based on your role.</p>
                </div>
            <?php endif; ?>
            <div class="stats-grid">
                <div class="stat-card stat-primary">
                    <div class="stat-icon">
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?= $stats['total_users'] ?? 0 ?></h3>
                        <p class="stat-label">Total Users</p>
                    </div>
                </div>

                <div class="stat-card stat-success">
                    <div class="stat-icon">
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?= $stats['active_users'] ?? 0 ?></h3>
                        <p class="stat-label">Active Users</p>
                    </div>
                </div>

                <div class="stat-card stat-warning">
                    <div class="stat-icon">
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?= $stats['recent_registrations'] ?? 0 ?></h3>
                        <p class="stat-label">New This Week</p>
                    </div>
                </div>

                <div class="stat-card stat-info">
                    <div class="stat-icon">
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?= $stats['pending_applications'] ?? 0 ?></h3>
                        <p class="stat-label">Pending Applications</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-sections">
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Quick Actions</h2>
                    </div>
                    <div class="quick-actions">
                        <a href="<?= ROOT ?>/systemadmin/users" class="action-card">
                            <div class="action-icon">
                            </div>
                            <div class="action-content">
                                <h3>Add New User</h3>
                                <p>Create HR Admin or Recruitment Manager accounts</p>
                            </div>
                        </a>

                        <a href="<?= ROOT ?>/systemadmin/reports" class="action-card">
                            <div class="action-icon">
                            </div>
                            <div class="action-content">
                                <h3>View Reports</h3>
                                <p>Analyze system performance and user activity</p>
                            </div>
                        </a>

                        <a href="<?= ROOT ?>/systemadmin/logs" class="action-card">
                            <div class="action-icon">
                            </div>
                            <div class="action-content">
                                <h3>Security Logs</h3>
                                <p>Monitor system access and security events</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Recent Activities</h2>
                        <a href="<?= ROOT ?>/systemadmin/logs" class="section-link">View All</a>
                    </div>
                    <div class="activity-list">

                        <?php if (!empty($roles)): ?>
                            <?php foreach ($roles as $role): ?>
                                <div class="activity-item">
                                    <div class="activity-icon"></div>
                                    <div class="activity-content">
                                        <p class="activity-text"><?= htmlspecialchars($role['id']) ?>
                                            (<?= htmlspecialchars($role['role_name']) ?>)</p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state">
                                <p>No recent activities to display</p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- System Status -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">System Status</h2>
                    </div>
                    <div class="status-grid">
                        <div class="status-item status-online">
                            <div class="status-indicator"></div>
                            <div class="status-content">
                                <h4>Database</h4>
                                <p>Online</p>
                            </div>
                        </div>

                        <div class="status-item status-online">
                            <div class="status-indicator"></div>
                            <div class="status-content">
                                <h4>Email Service</h4>
                                <p>Operational</p>
                            </div>
                        </div>

                        <div class="status-item status-online">
                            <div class="status-indicator"></div>
                            <div class="status-content">
                                <h4>File Storage</h4>
                                <p>Available</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>

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
</body>

</html>