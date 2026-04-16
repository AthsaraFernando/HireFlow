<?php $this->view('components/header', ['page_title' => $page_title ?? 'System Admin']) ?>

<style>
    .page-header {
        padding: 25px 25px 20px 25px;
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #4e31aa 0%, #3b2693 100%);
        color: white;
    }

    .page-header .page-title {
        margin: 0 0 8px 0;
        font-size: 2rem;
        font-weight: 700;
        color: white;
    }

    .page-header .page-description {
        margin: 0;
        font-size: 1.1rem;
        opacity: 0.9;
        color: rgba(255, 255, 255, 0.9);
    }

    .controls-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 25px;
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .controls-stats .metric-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .controls-stats .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .controls-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .controls-left {
        flex: 1;
        max-width: 500px;
    }

    .search-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input {
        flex: 1;
        padding: 12px 45px 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #4e31aa;
        box-shadow: 0 0 0 3px rgba(78, 49, 170, 0.1);
    }

    .search-btn {
        position: absolute;
        right: 5px;
        background: #4e31aa;
        border: none;
        border-radius: 6px;
        padding: 8px 12px;
        color: white;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .search-btn:hover {
        /* background: #3b2693; */
        color: white;
    }

    .controls-right {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .controls-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 20px;
        padding: 20px 25px;
        background: white;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 200px;
    }

    .filter-group label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        white-space: nowrap;
    }

    .filter-select,
    .filter-input {
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        background: white;
        min-width: 120px;
        transition: border-color 0.2s ease;
    }

    .filter-select:focus,
    .filter-input:focus {
        outline: none;
        border-color: #4e31aa;
    }

    .filter-separator {
        margin: 0 8px;
        color: #6b7280;
        font-weight: 500;
    }

    .filter-actions {
        margin-left: auto;
        display: flex;
        gap: 8px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
    }

    .btn-outline {
        background: transparent;
        border: 1px solid #d1d5db;
        color: #374151;

    }

    .btn-outline:hover {
        background: #f9fafb;
        border-color: #9ca3af;
        color: black;
    }

    .info-note {
        padding: 15px 25px;
        background: #f0f9ff;
        border-top: 1px solid #e5e7eb;
    }

    .info-note p {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #0369a1;
    }

    .page-controls .table-container {
        margin: 20px 25px 0 25px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .page-controls .table-container table {
        width: 100%;
    }

    .page-controls .pagination-container {
        margin: 20px 25px 25px 25px;
    }

    .dashboard-content {
        padding: 20px;
        width: 100%;
        max-width: none;
    }

    .dashboard-content .alert {
        margin-bottom: 20px;
        border-radius: 8px;
    }

    .page-controls {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: none;
        display: block;
    }



    .text-muted {
        color: #6b7280;
    }

    .icon-search::before {
        content: "🔍";
    }

    .icon-download::before {
        content: "📥";
    }

    .icon-refresh::before {
        content: "🔄";
    }

    .icon-trash::before {
        content: "🗑️";
    }



    @media (max-width: 768px) {
        .page-header {
            padding: 20px 20px 15px 20px;
        }

        .page-header .page-title {
            font-size: 1.5rem;
        }

        .page-header .page-description {
            font-size: 1rem;
        }

        .controls-stats {
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            padding: 20px;
        }

        .controls-header {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }

        .controls-left {
            max-width: none;
        }

        .controls-right {
            justify-content: center;
        }

        .controls-filters {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .filter-group {
            min-width: auto;
            flex-direction: column;
            align-items: stretch;
            gap: 5px;
        }

        .filter-actions {
            margin-left: 0;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .controls-stats {
            grid-template-columns: 1fr;
        }
    }

    .profile_picture {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.3);
        margin-left: 20px;
    }

    .user-agent {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .log-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .detail-item.full-width {
        grid-column: 1 / -1;
    }

    .detail-item label {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .detail-item span,
    .detail-item div {
        color: var(--text-primary);
        word-break: break-all;
    }

    .action-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .action-badge.login {
        background: #e3f2fd;
        color: #1976d2;
    }

    .action-badge.logout {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .action-badge.failed-login {
        background: #ffebee;
        color: #d32f2f;
    }

    .action-badge.data-access {
        background: #e8f5e8;
        color: #388e3c;
    }

    .action-badge.profile-update {
        background: #fff3e0;
        color: #f57c00;
    }

    .action-badge.admin-action {
        background: #fce4ec;
        color: #c2185b;
    }

    .filter-group {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-input,
    .filter-select {
        padding: 0.5rem;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        font-size: 0.875rem;
    }

    .search-section {
        margin: 1rem 0;
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .search-input {
        flex: 1;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 4px;
    }
</style>

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
                    <a href="<?= ROOT ?>/systemadmin/reports" class="nav-link">
                        <span class="nav-text">Reports & Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/accesslogs" class="nav-link active">
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
                        <h1 class="page-title">Access Logs</h1>
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
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <p><?php echo $success ?></p>
                </div>
            <?php endif; ?>

            <!-- Access Log Controls -->
            <div class="page-controls">
                <!-- Page Header -->
                <div class="page-header">

                </div>

                <!-- Statistics Cards -->
                <div class="controls-stats">
                    <div class="metric-card">
                        <div class="metric-value"><?= number_format($total_logs ?? 0) ?></div>
                        <div class="metric-label">Total Logs</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-value"><?= number_format($unique_users_today ?? 0) ?></div>
                        <div class="metric-label">Unique Users</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-value"><?= number_format($failed_logins_today ?? 0) ?></div>
                        <div class="metric-label">Failed Attempts</div>
                    </div>

                </div>

                <div class="controls-header">
                    <div class="controls-left">
                        <div class="search-container">
                            <input type="text" placeholder="Search by user, IP address, or action..."
                                class="search-input" id="logSearch">
                            <button class="search-btn" onclick="searchLogs()">
                                Search
                            </button>
                        </div>
                    </div>
                    <div class="controls-right">
                        <button class="btn btn-primary" onclick="exportLogs()">
                            Export Logs
                        </button>
                        <button class="btn btn-secondary" onclick="refreshLogs()">
                            Refresh
                        </button>
                    </div>
                </div>

                <div class="controls-filters">
                    <div class="filter-group">
                        <label>Date Range:</label>
                        <input type="date" id="startDate" class="filter-input">
                        <span class="filter-separator">to</span>
                        <input type="date" id="endDate" class="filter-input">
                    </div>
                    <div class="filter-group">
                        <label>Filter by User:</label>
                        <select class="filter-select" id="userFilter">
                            <option value="">All Users</option>
                            <option value="System Admin">System Admin</option>
                            <option value="HR Admin">HR Admin</option>
                            <option value="Recruitment Manager">Recruitment Manager</option>
                            <option value="Applicant">Applicant</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Filter by Action:</label>
                        <select class="filter-select" id="actionFilter">
                            <option value="">All Actions</option>
                            <option value="login">Login</option>
                            <option value="logout">Logout</option>
                            <option value="failed_login">Failed Login</option>
                            <option value="password_reset_request">Password Reset Request</option>
                            <option value="profile_update">Profile Update</option>
                            <option value="password_change">Password Reset</option>
                            <option value="registration">Registration</option>
                            <option value="user_updated">User Updated</option>
                            <option value="user_deleted">User Deleted</option>
                            <option value="user_status_changed">User Status Changed</option>
                            <option value="user_created">User Created</option>
                            <option value="application_submit">Application Submit</option>
                            <option value="db_backup_created">Database Backup</option>
                            <option value="db_restore">Database Restore</option>
                            <option value="db_backup_download">Database Backup Download</option>
                            <option value="db_backup_deleted">Database Backup Delete</option>
                            <option value="announcement_created">Announcement Create</option>
                            <option value="announcement_updated">Announcement Update</option>
                            <option value="announcement_deleted">Announcement Delete</option>
                            <option value="application_status_updated">Application Status Updated</option>
                            <option value="application_status_update_failed">Application Status Update Failed</option>
                            <option value="interview_scheduled">Interview Scheduled</option>
                            <option value="interview_rescheduled">Interview Rescheduled</option>
                            <option value="interview_deleted">Interview Deleted</option>
                            <option value="interview_feedback_submitted">Interview Feedback Submitted</option>
                            <option value="interview_feedback_updated">Interview Feedback Updated</option>
                            <option value="interview_feedback_deleted">Interview Feedback Deleted</option>
                            <option value="application_form_created">Application Form Created</option>
                            <option value="application_form_published">Application Form Published</option>
                            <option value="application_form_deleted">Application Form Deleted</option>
                            <option value="application_form_status_updated">Application Form Status Updated</option>
                            <option value="application_form_restored">Application Form Restored</option>
                            <option value="job_post_created">Job Post Created</option>
                            <option value="job_post_updated">Job Post Updated</option>
                            <option value="job_post_deleted">Job Post Deleted</option>
                            <option value="job_category_created">Job Category Created</option>
                            <option value="job_category_updated">Job Category Updated</option>
                            <option value="job_category_deleted">Job Category Deleted</option>
                            <option value="department_created">Department Created</option>
                            <option value="department_updated">Department Updated</option>
                            <option value="department_deleted">Department Deleted</option>
                            <option value="application_updated">Application Updated</option>
                            <option value="application_deleted">Application Deleted</option>
                            <option value="saved_job_added">Saved Job Added</option>
                            <option value="saved_job_note_updated">Saved Job Note Updated</option>
                            <option value="saved_job_removed">Saved Job Removed</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Filter by Flag:</label>
                        <select class="filter-select" id="flagFilter">
                            <option value="">All Flags</option>
                            <option value="unflagged">Unflagged</option>
                            <option value="flagged">Flagged</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button class="btn btn-sm btn-primary" onclick="applyFilters()">Apply Filters</button>
                        <button class="btn btn-sm btn-outline" onclick="clearFilters()">Clear Filters</button>
                    </div>
                </div>

                <!-- Access Logs Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>User Role</th>
                                <th>IP Address</th>
                                <th>Action</th>
                                <th>Details</th>
                                <th>User Agent</th>
                                <th>Flagged</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $roles = [
                                1 => 'System Admin',
                                2 => 'HR Admin',
                                3 => 'Recruitment Manager',
                                4 => 'Applicant'
                            ];
                            ?>
                            <?php if (!empty($logs)): ?>
                                <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td><?= $log['id'] ?></td>
                                        <td><?= $log['user_id'] ?></td>
                                        <td><?= $roles[$log['user_role']] ?? 'Unknown' ?></td>
                                        <td><?= $log['ip_address'] ?></td>
                                        <td><?= $log['action'] ?></td>
                                        <td><?= $log['details'] ?></td>
                                        <td><?= $log['user_agent'] ?></td>
                                        <td>
                                            <input data-log-id="<?= $log['id'] ?>" class="flagged-checkbox"
                                                style="width: 25px; height: 25px;" type="checkbox" <?= $log['flagged'] ? 'checked' : '' ?>>
                                        </td>
                                        <td><?= $log['created_at'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 2rem;">
                                        <p>No access logs found.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination-info">Showing 1-6 of 2,847 log entries</div>
                    <div class="pagination">
                        <button class="pagination-btn" disabled>Previous</button>
                        <button class="pagination-btn active">1</button>
                        <button class="pagination-btn">2</button>
                        <button class="pagination-btn">3</button>
                        <button class="pagination-btn">...</button>
                        <button class="pagination-btn">475</button>
                        <button class="pagination-btn">Next</button>
                    </div>
                </div>
            </div>

            <script>
                // Initialize filters with today's date
                document.addEventListener('DOMContentLoaded', function () {
                    const today = new Date().toISOString().split('T')[0];
                    document.getElementById('endDate').value = today;

                    const weekAgo = new Date();
                    weekAgo.setDate(weekAgo.getDate() - 7);
                    document.getElementById('startDate').value = weekAgo.toISOString().split('T')[0];
                });

                document.querySelectorAll('.flagged-checkbox').forEach(cb => {
                    cb.addEventListener('change', function () {
                        updateFlag(this);
                    });
                });

                function updateFlag(checkbox) {
                    const flagValue = checkbox.checked ? 1 : 0;
                    const logId = checkbox.getAttribute('data-log-id');
                    const formData = new FormData();
                    formData.append('flag_value', flagValue);
                    formData.append('log_id', logId);
                    formData.append('csrf_token', '<?= $csrf_token ?>');

                    fetch(`/HireFlow/public/systemadmin/accesslogs/updateFlag/details/${logId}`, { // details(action) and id(value) is passed for route testing
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Flag updated successfully!', 'success');
                                // setTimeout(() => {
                                //     location.reload();
                                // }, 1000);
                            }
                            else {
                                showToast('Failed to update flag', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Failed to update flag', 'error');
                        });


                }

                function applyFilters() {
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;
                    const userFilter = document.getElementById('userFilter').value;
                    const actionFilter = document.getElementById('actionFilter').value;
                    const flagFilter = document.getElementById('flagFilter').value;

                    const tableRows = document.querySelectorAll('.data-table tbody tr');
                    let visibleCount = 0;

                    tableRows.forEach(row => {
                        // Skip the "no logs found" row
                        if (row.querySelector('td[colspan]')) {
                            return;
                        }

                        const cells = row.querySelectorAll('td');
                        const userId = cells[1]?.textContent.trim() || '';
                        const userRole = cells[2]?.textContent.trim() || '';
                        const ipAddress = cells[3]?.textContent.trim() || '';
                        const action = cells[4]?.textContent.trim().toLowerCase() || '';
                        const details = cells[5]?.textContent.trim().toLowerCase() || '';
                        const userAgent = cells[6]?.textContent.trim().toLowerCase() || '';
                        const flagValue = cells[7]?.querySelector('input[type="checkbox"]')?.checked ? 'flagged' : 'unflagged'
                        const createdAt = cells[8]?.textContent.trim() || '';


                        let shouldShow = true;

                        // Date range filter
                        if (startDate && createdAt) {
                            const logDate = new Date(createdAt).setHours(0, 0, 0, 0);
                            const filterStartDate = new Date(startDate).setHours(0, 0, 0, 0);
                            if (logDate < filterStartDate) {
                                shouldShow = false;
                            }
                        }

                        if (endDate && createdAt) {
                            const logDate = new Date(createdAt).setHours(0, 0, 0, 0);
                            const filterEndDate = new Date(endDate).setHours(23, 59, 59, 999);
                            if (logDate > filterEndDate) {
                                shouldShow = false;
                            }
                        }

                        // Action filter
                        if (actionFilter && action !== actionFilter.toLowerCase()) {
                            shouldShow = false;
                        }

                        // User filter
                        if (userFilter && userRole.toLowerCase() !== userFilter.toLowerCase()) {
                            shouldShow = false;
                        }

                        if (flagFilter && flagValue.toLowerCase() !== flagFilter.toLowerCase()) {
                            shouldShow = false;
                        }

                        // Show or hide row
                        if (shouldShow) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Update pagination info
                    const paginationInfo = document.querySelector('.pagination-info');
                    if (paginationInfo) {
                        paginationInfo.textContent = `Showing ${visibleCount} log entries`;
                    }

                    showToast(`Filters applied. Showing ${visibleCount} results`, 'success');
                }

                function clearFilters() {
                    document.getElementById('startDate').value = '';
                    document.getElementById('endDate').value = '';
                    document.getElementById('userFilter').value = '';
                    document.getElementById('actionFilter').value = '';
                    document.getElementById('logSearch').value = '';
                    document.getElementById('flagFilter').value = '';

                    location.reload();
                    // showToast('Filters cleared', 'info');
                }

                function searchLogs() {
                    const searchTerm = document.getElementById('logSearch').value.toLowerCase();
                    const tableRows = document.querySelectorAll('.data-table tbody tr');
                    let visibleCount = 0;

                    if (searchTerm.trim() === '') {
                        // showToast('Please enter a search term', 'warning');
                        return;
                    }

                    tableRows.forEach(row => {
                        // Skip the "no logs found" row
                        if (row.querySelector('td[colspan]')) {
                            return;
                        }

                        const cells = row.querySelectorAll('td');
                        const userId = cells[1]?.textContent.trim() || '';
                        const userRole = cells[2]?.textContent.trim() || '';
                        const ipAddress = cells[3]?.textContent.trim() || '';
                        const action = cells[4]?.textContent.trim().toLowerCase() || '';
                        const details = cells[5]?.textContent.trim().toLowerCase() || '';
                        const userAgent = cells[6]?.textContent.trim().toLowerCase() || '';
                        const flagValue = cells[7]?.querySelector('input[type="checkbox"]')?.checked ? 'flagged' : 'unflagged'
                        const createdAt = cells[8]?.textContent.trim() || '';

                        let shouldShow = true;

                        // Search term filter (searches across user_id, ip_address, action, details, user_agent)
                        if (searchTerm) {
                            const searchableText = `${userId} ${userRole} ${ipAddress} ${action} ${details} ${userAgent} ${createdAt}`;
                            if (!searchableText.includes(searchTerm)) {
                                shouldShow = false;
                            }
                        }

                        // Show or hide row
                        if (shouldShow) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Perform search
                    showToast('Search completed', 'success');
                }

                function refreshLogs() {
                    // Clear all filters
                    document.getElementById('startDate').value = '';
                    document.getElementById('endDate').value = '';
                    document.getElementById('userFilter').value = '';
                    document.getElementById('actionFilter').value = '';
                    document.getElementById('logSearch').value = '';

                    // Show all rows
                    const tableRows = document.querySelectorAll('.data-table tbody tr');
                    tableRows.forEach(row => {
                        row.style.display = '';
                    });

                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                    showToast('Logs refreshed', 'success');
                }

                function exportLogs() {
                    if (!confirm("Do you want to export the filtered logs?")) {
                        return;
                    }
                    // Get all visible table rows (filtered rows)
                    const tableRows = document.querySelectorAll('.data-table tbody tr');
                    const visibleRows = Array.from(tableRows).filter(row => {
                        return row.style.display !== 'none' && !row.querySelector('td[colspan]');
                    });

                    if (visibleRows.length === 0) {
                        showToast('No logs to export', 'warning');
                        return;
                    }

                    // Prepare CSV data
                    const csvRows = [];

                    // Add header row
                    const headers = ['ID', 'User ID', 'User Role', 'IP Address', 'Action', 'Details', 'User Agent', 'Flagged', 'Created At'];
                    csvRows.push(headers.join(','));

                    // Add data rows
                    visibleRows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        const rowData = [
                            cells[0]?.textContent.trim() || '',
                            cells[1]?.textContent.trim() || '',
                            cells[2]?.textContent.trim() || '',
                            cells[3]?.textContent.trim() || '',
                            cells[4]?.textContent.trim() || '',
                            `"${(cells[5]?.textContent.trim() || '').replace(/"/g, '""')}"`, // Escape quotes in details
                            `"${(cells[6]?.textContent.trim() || '').replace(/"/g, '""')}"`, // Escape quotes in user agent
                            cells[7]?.querySelector('input[type="checkbox"]')?.checked ? 'Yes' : 'No' || '',
                            cells[8]?.textContent.trim() || ''
                        ];

                        csvRows.push(rowData.join(','));
                    });

                    // Create CSV string
                    const csvString = csvRows.join('\n');

                    // Create blob and download
                    const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');

                    link.href = url;
                    link.download = `access_logs_${new Date().toISOString().split('T')[0]}.csv`;

                    // Append to body, click, and remove
                    document.body.appendChild(link);
                    link.click();

                    // Clean up
                    setTimeout(() => {
                        document.body.removeChild(link);
                        URL.revokeObjectURL(url);
                    }, 100);

                    showToast(`Successfully exported ${visibleRows.length} log entries`, 'success');
                }

                function clearOldLogs() {
                    if (confirm('Are you sure you want to clear logs older than 90 days? This action cannot be undone.')) {
                        showToast('Old logs cleared successfully', 'success');
                    }
                }

                // Toast notification function
                function showToast(message, type) {
                    const toast = document.createElement('div');
                    toast.className = `toast toast-${type}`;
                    toast.textContent = message;
                    document.body.appendChild(toast);

                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                }
            </script>

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
</body>

<?php $this->view('components/footer') ?>