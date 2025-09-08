<?php $this->view('components/header') ?>

<style>
/* Page Controls Styling - Full Width */

/* Page Header inside Controls */
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
    color: rgba(255,255,255,0.9);
}

/* Statistics Cards */
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
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.controls-stats .metric-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
    background: #3b2693;
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

/* Table Container inside Page Controls */
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

/* Proper full width within content area */
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
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    width: 100%;
    max-width: none;
    display: block;
}



.text-muted {
    color: #6b7280;
}

/* Icon Styles */
.icon-search::before { content: "🔍"; }
.icon-download::before { content: "📥"; }
.icon-refresh::before { content: "🔄"; }
.icon-trash::before { content: "🗑️"; }



/* Responsive Design */
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
</style>

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
                        <h1 class="page-title">Access Logs</h1>
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

            <!-- Access Log Controls -->
            <div class="page-controls">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">Access Logs</h1>
                    <p class="page-description">Monitor and track all system access activities</p>
                </div>
                
                <!-- Statistics Cards -->
                <div class="controls-stats">
            <div class="metric-card">
                <div class="metric-value">2,847</div>
                <div class="metric-label">Total Logins Today</div>
                <div class="metric-change positive">+15% from yesterday</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">156</div>
                <div class="metric-label">Unique Users</div>
                <div class="metric-change positive">+8 new users</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">12</div>
                <div class="metric-label">Failed Attempts</div>
                <div class="metric-change negative">+4 from yesterday</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">3</div>
                <div class="metric-label">Suspicious Activities</div>
                <div class="metric-change warning">Requires attention</div>
            </div>
        </div>
        
        <div class="controls-header">
            <div class="controls-left">
                <div class="search-container">
                    <input type="text" placeholder="Search by user, IP address, or action..." class="search-input" id="logSearch">
                    <button class="search-btn" onclick="searchLogs()">
                        <i class="icon-search"></i>
                    </button>
                </div>
            </div>
            <div class="controls-right">
                <button class="btn btn-primary" onclick="exportLogs()">
                    <i class="icon-download"></i>Export Logs
                </button>
                <button class="btn btn-secondary" onclick="refreshLogs()">
                    <i class="icon-refresh"></i>Refresh
                </button>
                <button class="btn btn-warning" onclick="clearOldLogs()">
                    <i class="icon-trash"></i>Clear Old
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
                    <option value="system_admin">System Admins</option>
                    <option value="hr_admin">HR Admins</option>
                    <option value="recruitment_manager">Recruitment Managers</option>
                    <option value="applicant">Applicants</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Filter by Action:</label>
                <select class="filter-select" id="actionFilter">
                    <option value="">All Actions</option>
                    <option value="login">Login</option>
                    <option value="logout">Logout</option>
                    <option value="failed_login">Failed Login</option>
                    <option value="password_change">Password Change</option>
                    <option value="profile_update">Profile Update</option>
                    <option value="data_access">Data Access</option>
                    <option value="admin_action">Admin Action</option>
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
                    <th>Timestamp</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Action</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2024-01-15 14:32:15</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">JD</div>
                            <div>
                                <div class="user-name">John Doe</div>
                                <div class="user-email">john.doe@company.com</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="role-badge system-admin">System Admin</span></td>
                    <td><span class="action-badge login">Login</span></td>
                    <td>192.168.1.100</td>
                    <td class="user-agent" title="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36">Chrome 120.0 (Windows)</td>
                    <td><span class="status-badge success">Success</span></td>
                    <td>
                        <button class="btn-icon" onclick="viewLogDetails(1)" title="View Details">
                            <i class="icon-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>2024-01-15 14:30:22</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">MS</div>
                            <div>
                                <div class="user-name">Mary Smith</div>
                                <div class="user-email">mary.smith@company.com</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="role-badge hr-admin">HR Admin</span></td>
                    <td><span class="action-badge data-access">Data Access</span></td>
                    <td>192.168.1.105</td>
                    <td class="user-agent" title="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36">Chrome 120.0 (macOS)</td>
                    <td><span class="status-badge success">Success</span></td>
                    <td>
                        <button class="btn-icon" onclick="viewLogDetails(2)" title="View Details">
                            <i class="icon-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>2024-01-15 14:28:45</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">UK</div>
                            <div>
                                <div class="user-name">Unknown User</div>
                                <div class="user-email">test@suspicious.com</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="role-badge unknown">Unknown</span></td>
                    <td><span class="action-badge failed-login">Failed Login</span></td>
                    <td>203.145.67.89</td>
                    <td class="user-agent" title="Bot/Crawler attempting access">Suspicious Bot Activity</td>
                    <td><span class="status-badge error">Failed</span></td>
                    <td>
                        <button class="btn-icon warning" onclick="viewLogDetails(3)" title="View Details">
                            <i class="icon-warning"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>2024-01-15 14:25:12</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">RJ</div>
                            <div>
                                <div class="user-name">Robert Johnson</div>
                                <div class="user-email">robert.johnson@company.com</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="role-badge recruitment-manager">Recruitment Manager</span></td>
                    <td><span class="action-badge profile-update">Profile Update</span></td>
                    <td>192.168.1.112</td>
                    <td class="user-agent" title="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36">Edge 120.0 (Windows)</td>
                    <td><span class="status-badge success">Success</span></td>
                    <td>
                        <button class="btn-icon" onclick="viewLogDetails(4)" title="View Details">
                            <i class="icon-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>2024-01-15 14:20:33</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">LD</div>
                            <div>
                                <div class="user-name">Lisa Davis</div>
                                <div class="user-email">lisa.davis@email.com</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="role-badge applicant">Applicant</span></td>
                    <td><span class="action-badge login">Login</span></td>
                    <td>203.123.45.67</td>
                    <td class="user-agent" title="Mozilla/5.0 (iPhone; CPU iPhone OS 17_1 like Mac OS X) AppleWebKit/605.1.15">Safari (iOS)</td>
                    <td><span class="status-badge success">Success</span></td>
                    <td>
                        <button class="btn-icon" onclick="viewLogDetails(5)" title="View Details">
                            <i class="icon-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>2024-01-15 14:18:15</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">JD</div>
                            <div>
                                <div class="user-name">John Doe</div>
                                <div class="user-email">john.doe@company.com</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="role-badge system-admin">System Admin</span></td>
                    <td><span class="action-badge admin-action">Admin Action</span></td>
                    <td>192.168.1.100</td>
                    <td class="user-agent" title="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36">Chrome 120.0 (Windows)</td>
                    <td><span class="status-badge success">Success</span></td>
                    <td>
                        <button class="btn-icon" onclick="viewLogDetails(6)" title="View Details">
                            <i class="icon-eye"></i>
                        </button>
                    </td>
                </tr>
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

<!-- Log Details Modal -->
<div id="logDetailsModal" class="modal">
    <div class="modal-content large">
        <div class="modal-header">
            <h2>Access Log Details</h2>
            <span class="close" onclick="closeLogDetailsModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div class="log-detail-grid">
                <div class="detail-item">
                    <label>Timestamp:</label>
                    <span id="detailTimestamp">-</span>
                </div>
                <div class="detail-item">
                    <label>User:</label>
                    <span id="detailUser">-</span>
                </div>
                <div class="detail-item">
                    <label>Role:</label>
                    <span id="detailRole">-</span>
                </div>
                <div class="detail-item">
                    <label>Action:</label>
                    <span id="detailAction">-</span>
                </div>
                <div class="detail-item">
                    <label>IP Address:</label>
                    <span id="detailIP">-</span>
                </div>
                <div class="detail-item">
                    <label>Location:</label>
                    <span id="detailLocation">-</span>
                </div>
                <div class="detail-item">
                    <label>User Agent:</label>
                    <span id="detailUserAgent">-</span>
                </div>
                <div class="detail-item">
                    <label>Session ID:</label>
                    <span id="detailSession">-</span>
                </div>
                <div class="detail-item full-width">
                    <label>Additional Details:</label>
                    <div id="detailAdditional">-</div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeLogDetailsModal()">Close</button>
            <button type="button" class="btn btn-warning" onclick="flagSuspicious()">Flag as Suspicious</button>
        </div>
    </div>
</div>

<script>
// Initialize filters with today's date
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('endDate').value = today;
    
    const weekAgo = new Date();
    weekAgo.setDate(weekAgo.getDate() - 7);
    document.getElementById('startDate').value = weekAgo.toISOString().split('T')[0];
});

function applyFilters() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const userFilter = document.getElementById('userFilter').value;
    const actionFilter = document.getElementById('actionFilter').value;
    
    // Apply filters to the table
    showToast('Filters applied successfully', 'success');
    // In real implementation, this would make an AJAX call to fetch filtered data
}

function clearFilters() {
    document.getElementById('startDate').value = '';
    document.getElementById('endDate').value = '';
    document.getElementById('userFilter').value = '';
    document.getElementById('actionFilter').value = '';
    document.getElementById('logSearch').value = '';
    
    showToast('Filters cleared', 'info');
}

function searchLogs() {
    const searchTerm = document.getElementById('logSearch').value;
    if (searchTerm.trim() === '') {
        showToast('Please enter a search term', 'warning');
        return;
    }
    
    // Perform search
    showToast('Search completed', 'success');
}

function refreshLogs() {
    showToast('Logs refreshed', 'success');
    // In real implementation, this would reload the log data
}

function exportLogs() {
    showToast('Export started. Download will begin shortly.', 'info');
    // In real implementation, this would generate and download a CSV/PDF file
}

function clearOldLogs() {
    if (confirm('Are you sure you want to clear logs older than 90 days? This action cannot be undone.')) {
        showToast('Old logs cleared successfully', 'success');
        // In real implementation, this would make an AJAX call to delete old logs
    }
}

function viewLogDetails(logId) {
    // Sample data - in real implementation, this would fetch from database
    const logData = {
        1: {
            timestamp: '2024-01-15 14:32:15',
            user: 'John Doe (john.doe@company.com)',
            role: 'System Admin',
            action: 'Login',
            ip: '192.168.1.100',
            location: 'New York, NY, USA',
            userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            session: 'sess_abc123def456',
            additional: 'Successful login from corporate network. No security concerns detected.'
        },
        2: {
            timestamp: '2024-01-15 14:30:22',
            user: 'Mary Smith (mary.smith@company.com)',
            role: 'HR Admin',
            action: 'Data Access',
            ip: '192.168.1.105',
            location: 'New York, NY, USA',
            userAgent: 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            session: 'sess_xyz789ghi012',
            additional: 'Accessed candidate database. Viewed 15 candidate profiles during this session.'
        },
        3: {
            timestamp: '2024-01-15 14:28:45',
            user: 'Unknown User (test@suspicious.com)',
            role: 'Unknown',
            action: 'Failed Login',
            ip: '203.145.67.89',
            location: 'Unknown (VPN/Proxy)',
            userAgent: 'python-requests/2.28.1',
            session: 'N/A',
            additional: 'SECURITY ALERT: Multiple failed login attempts detected. IP address flagged as suspicious. Possible bot/automated attack.'
        }
    };
    
    const data = logData[logId] || logData[1];
    
    document.getElementById('detailTimestamp').textContent = data.timestamp;
    document.getElementById('detailUser').textContent = data.user;
    document.getElementById('detailRole').textContent = data.role;
    document.getElementById('detailAction').textContent = data.action;
    document.getElementById('detailIP').textContent = data.ip;
    document.getElementById('detailLocation').textContent = data.location;
    document.getElementById('detailUserAgent').textContent = data.userAgent;
    document.getElementById('detailSession').textContent = data.session;
    document.getElementById('detailAdditional').textContent = data.additional;
    
    document.getElementById('logDetailsModal').style.display = 'block';
}

function closeLogDetailsModal() {
    document.getElementById('logDetailsModal').style.display = 'none';
}

function flagSuspicious() {
    if (confirm('Are you sure you want to flag this activity as suspicious?')) {
        showToast('Activity flagged as suspicious. Security team has been notified.', 'warning');
        closeLogDetailsModal();
    }
}

// Real-time log updates (simulated)
setInterval(function() {
    const badge = document.querySelector('.metric-card .metric-value');
    if (badge) {
        const currentValue = parseInt(badge.textContent.replace(',', ''));
        badge.textContent = (currentValue + Math.floor(Math.random() * 3)).toLocaleString();
    }
}, 30000); // Update every 30 seconds

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

<style>
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

.action-badge.login { background: #e3f2fd; color: #1976d2; }
.action-badge.logout { background: #f3e5f5; color: #7b1fa2; }
.action-badge.failed-login { background: #ffebee; color: #d32f2f; }
.action-badge.data-access { background: #e8f5e8; color: #388e3c; }
.action-badge.profile-update { background: #fff3e0; color: #f57c00; }
.action-badge.admin-action { background: #fce4ec; color: #c2185b; }

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