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
        color: rgba(255, 255, 255, 0.9);
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
        max-width: 400px;
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
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: none;
        display: block;
    }



    .text-muted {
        color: #6b7280;
    }

    /* Icon Styles */
    .icon-search::before {
        content: "🔍";
    }

    .icon-plus::before {
        content: "➕";
    }

    .icon-download::before {
        content: "📥";
    }

    .icon-edit::before {
        content: "✏️";
    }

    .icon-info::before {
        content: "ℹ️";
    }



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
                    <a href="<?= ROOT ?>/systemadmin/usermanage" class="nav-link active">
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
                        <h1 class="page-title">User Management</h1>
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

            <!-- User Management Controls -->
            <div class="page-controls">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">User Management</h1>
                    <p class="page-description">Manage system users, roles, and permissions</p>
                </div>

                <!-- Statistics Cards -->
                <div class="controls-stats">
                    <div class="metric-card">
                        <div class="metric-value"><?= count($users ?? []) ?></div>
                        <div class="metric-label">Total Users</div>
                        <!-- <div class="metric-change neutral">All registered users</div> -->
                    </div>
                    <div class="metric-card">
                        <?php
                        $activeUsers = array_filter($users ?? [], function ($user) {
                            return $user['status'] === 'active';
                        });
                        ?>
                        <div class="metric-value"><?= count($activeUsers) ?></div>
                        <div class="metric-label">Active Users</div>
                        <!-- <div class="metric-change positive">Currently active</div> -->
                    </div>
                    <div class="metric-card">
                        <?php
                        $inactiveUsers = array_filter($users ?? [], function ($user) {
                            return $user['status'] === 'inactive';
                        });
                        ?>
                        <div class="metric-value"><?= count($inactiveUsers) ?></div>
                        <div class="metric-label">Inactive Users</div>
                        <!-- <div class="metric-change neutral">Currently inactive</div> -->
                    </div>
                    <div class="metric-card">
                        <div class="metric-value"><?= count($roles ?? []) ?></div>
                        <div class="metric-label">User Roles</div>
                        <!-- <div class="metric-change neutral">Available roles</div> -->
                    </div>
                </div>

                <div class="controls-header">
                    <div class="controls-left">
                        <div class="search-container">
                            <input type="text" placeholder="Search users..." class="search-input" id="userSearch">
                            <button class="search-btn" onclick="filterUsers()">
                                <!-- <i class="icon-search"></i> -->Search
                            </button>
                        </div>
                    </div>
                    <div class="controls-right">
                        <?php if ($can_manage_users ?? false): ?>
                            <button class="btn btn-primary" onclick="openUserModal('add')">
                                <!-- <i class="icon-plus"></i> -->
                                Add Staff User
                            </button>
                            <!-- <button class="btn btn-secondary" onclick="exportUsers()">
                                <i class="icon-download"></i>Export
                            </button> -->
                            <!-- <button class="btn btn-outline" onclick="openBulkActionsModal()">
                                <i class="icon-edit"></i>Bulk Actions
                            </button> -->
                        <?php endif; ?>
                    </div>
                </div>

                <div class="controls-filters">
                    <div class="filter-group">
                        <label>Filter by Role:</label>
                        <select class="filter-select" id="roleFilter">
                            <option value="">All Roles</option>
                            <option value="System Admin">System Admin</option>
                            <option value="HR Admin">HR Admin</option>
                            <option value="Recruitment Manager">Recruitment Manager</option>
                            <option value="Applicant">Applicant</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Filter by Status:</label>
                        <select class="filter-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <!-- <option value="suspended">Suspended</option> -->
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button class="btn btn-sm btn-outline" onclick="clearFilters()">Clear Filters</button>
                    </div>
                </div>

                <?php if ($can_manage_users ?? false): ?>
                    <div class="info-note">
                        <p class="text-muted">
                            <i class="icon-info"></i>
                            <strong>Note:</strong> Applicants self-register through the public portal. Only create HR Admin
                            and Recruitment Manager accounts here.
                        </p>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <p><strong>View Only Mode:</strong> You can view user information but cannot manage users. Contact a
                            System Administrator for user management tasks.</p>
                    </div>
                <?php endif; ?>

                <!-- Users Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <!-- <th><input type="checkbox" id="selectAll"></th> -->
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <?php
                                    // Generate initials for avatar
                                    $nameParts = explode(' ', trim($user['full_name']));
                                    $initials = '';
                                    foreach ($nameParts as $part) {
                                        $initials .= strtoupper(substr($part, 0, 1));
                                    }
                                    $initials = substr($initials, 0, 2);

                                    // Format role badge class
                                    // $roleClass = str_replace(' ', '-', strtolower($user['role_name'] ?? 'unknown'));
                            
                                    // Format dates
                                    $lastLogin = $user['last_login'] ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'Never';
                                    $createdDate = date('M j, Y', strtotime($user['created_at']));
                                    ?>
                                    <tr data-user-id="<?= $user['id'] ?>">
                                        <!-- <td><input type="checkbox" class="user-checkbox" value="<?= $user['id'] ?>"></td> -->
                                        <td>USR-<?= str_pad($user['id'], 3, '0', STR_PAD_LEFT) ?></td>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar"><?= $initials ?></div>
                                                <div>
                                                    <div class="user-name"><?= htmlspecialchars($user['full_name']) ?></div>
                                                    <div class="user-meta">
                                                        <? // = htmlspecialchars($user['role_name'] ?? 'Unknown Role') ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><span
                                                class="role-badge <?= $roleClass ?>"><?= htmlspecialchars($user['role_name'] ?? 'Unknown') ?></span>
                                        </td>
                                        <td><span
                                                class="status-badge <?= $user['status'] ?>"><?= ucfirst($user['status']) ?></span>
                                        </td>
                                        <td><?= $lastLogin ?></td>
                                        <td><?= $createdDate ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-icon" onclick="viewUser(<?= $user['id'] ?>)" title="View">
                                                    <i class="icon-eye"></i>
                                                </button>
                                                <?php if (($can_manage_users ?? false) && $user['id'] != Auth::user_id()): ?>
                                                    <button class="btn-icon" onclick="editUser(<?= $user['id'] ?>)" title="Edit">
                                                        <i class="icon-edit"></i>
                                                    </button>
                                                    <button class="btn-icon danger" onclick="toggleUserStatus(<?= $user['id'] ?>)"
                                                        title="<?= $user['status'] === 'active' ? 'Suspend' : 'Activate' ?>">
                                                        <i class="icon-<?= $user['status'] === 'active' ? 'pause' : 'play' ?>"></i>
                                                    </button>
                                                    <button class="btn-icon danger" onclick="deleteUser(<?= $user['id'] ?>)"
                                                        title="Delete">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                <?php elseif ($user['id'] == Auth::user_id()): ?>
                                                    <span class="text-muted small">Current User</span>
                                                <?php elseif (!($can_manage_users ?? false)): ?>
                                                    <span class="text-muted small">View Only</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        <p>No users found. <a href="#" onclick="openUserModal('add')">Create the first
                                                user</a></p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination-info">
                        <?php
                        $totalUsers = count($users);
                        echo "Showing 1-{$totalUsers} of {$totalUsers} users";
                        ?>
                    </div>
                    <div class="pagination">
                        <button class="pagination-btn" disabled>Previous</button>
                        <button class="pagination-btn active">1</button>
                        <?php if ($totalUsers > 10): ?>
                            <button class="pagination-btn">2</button>
                            <button class="pagination-btn">Next</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- User Modal -->
            <div id="userModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 id="modalTitle">Add Staff User</h2>
                        <span class="close" onclick="closeUserModal()">&times;</span>
                    </div>
                    <div class="modal-body">
                        <!-- <div class="info-box mb-3">
                            <p class="text-muted small">
                                <strong>Account Creation Policy:</strong> Only create HR Admin and Recruitment Manager
                                accounts here.
                                Applicants register themselves through the public signup page.
                            </p>
                        </div> -->
                        <form id="userForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstName">First Name *</label>
                                    <input type="text" id="firstName" name="firstName" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Last Name *</label>
                                    <input type="text" id="lastName" name="lastName" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" id="phone" name="phone">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="role">Role *</label>
                                    <select id="role" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="system_admin">System Admin</option>
                                        <option value="hr_admin">HR Admin</option>
                                        <option value="recruitment_manager">Recruitment Manager</option>
                                    </select>
                                    <!-- <small class="form-text">Applicant accounts are created through public
                                        registration</small> -->
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password *</label>
                                <input type="password" id="password" name="password" required>
                                <small>Minimum 8 characters with at least one uppercase, lowercase, number and special
                                    character</small>
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password *</label>
                                <input type="password" id="confirmPassword" name="confirmPassword" required>
                            </div>

                            <!-- <div class="form-group">
                                <label>
                                    <input type="checkbox" id="sendWelcome" name="sendWelcome" checked>
                                    Send welcome email to user
                                </label>
                            </div> -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeUserModal()">Cancel</button>
                        <button type="submit" id="action" class="btn btn-primary" onclick="saveUser()">Create Staff
                            Account</button>
                    </div>
                </div>
            </div>

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

                // User management functionality
                function openUserModal(action, userId = null) {
                    const modal = document.getElementById('userModal');
                    const title = document.getElementById('modalTitle');
                    const form = document.getElementById('userForm');
                    const button = document.getElementById('action');

                    // Reset all fields to be editable (remove readonly/disabled)
                    form.querySelectorAll('input, select').forEach(field => {
                        field.removeAttribute('readonly');
                        field.removeAttribute('disabled');
                    });

                    // Show the action button
                    button.style.display = 'inline-block';

                    if (action === 'add') {
                        title.textContent = 'Add Staff User';
                        form.reset();
                        // Reset password fields to required
                        document.getElementById('password').required = true;
                        document.getElementById('confirmPassword').required = true;
                        button.textContent = 'Create Staff Account';
                        button.onclick = saveUser;
                    } else if (action === 'edit') {
                        title.textContent = 'Edit User';
                        button.textContent = 'Update User';
                        // Store userId in a data attribute for later use
                        modal.setAttribute('data-user-id', userId);
                        button.onclick = function () {
                            updateUser(userId);
                        };
                        // Load user data for editing
                        loadUserData(userId, modal);
                    }

                    modal.style.display = 'block';
                }

                function loadUserData(userId, modal) {
                    const formData = new FormData();
                    formData.append('action', 'fetch');
                    formData.append('user_id', userId);

                    fetch('/HireFlow/public/systemadmin/usermanage', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => {
                            // Check if response is JSON
                            const contentType = response.headers.get('content-type');
                            if (!contentType || !contentType.includes('application/json')) {
                                throw new Error('Server did not return JSON');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                console.log(data);
                                const user = data.user;

                                // Split name into first and last
                                const nameParts = user.full_name.split(' ');
                                document.getElementById('firstName').value = nameParts[0] || '';
                                document.getElementById('lastName').value = nameParts.slice(1).join(' ') || '';
                                document.getElementById('email').value = user.email;
                                document.getElementById('phone').value = user.phone || '';

                                // Map role_id to role name
                                const roleMap = {
                                    1: 'system_admin',
                                    2: 'hr_admin',
                                    3: 'recruitment_manager',
                                    4: 'applicant'
                                };
                                document.getElementById('role').value = roleMap[user.role_id] || '';
                                document.getElementById('status').value = user.status;

                                // Make password fields optional for edit
                                document.getElementById('password').required = false;
                                document.getElementById('confirmPassword').required = false;
                                document.getElementById('password').value = '';
                                document.getElementById('confirmPassword').value = '';

                                modal.style.display = 'block';
                            } else {
                                alert('User not found: ' + (data.message || ''));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to load user data: ' + error.message);
                        });
                }
                function updateUser(userId) {
                    const form = document.getElementById('userForm');
                    const formData = new FormData();

                    // Add action and user_id
                    formData.append('action', 'update');
                    formData.append('user_id', userId);

                    // Add form fields
                    const firstName = document.getElementById('firstName').value.trim();
                    const lastName = document.getElementById('lastName').value.trim();
                    formData.append('full_name', firstName + ' ' + lastName);
                    formData.append('email', document.getElementById('email').value.trim());
                    formData.append('phone', document.getElementById('phone').value.trim());
                    formData.append('status', document.getElementById('status').value);

                    // Map role name to role_id
                    const roleMap = {
                        'system_admin': 1,
                        'hr_admin': 2,
                        'recruitment_manager': 3,
                        'applicant': 4
                    };
                    const roleValue = document.getElementById('role').value;
                    formData.append('role_id', roleMap[roleValue]);

                    // Only include password if it was changed
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;

                    if (password) {
                        if (password !== confirmPassword) {
                            showToast('Passwords do not match', 'error');
                            return;
                        }
                        if (password.length < 8) {
                            showToast('Password must be at least 8 characters long', 'error');
                            return;
                        }
                        formData.append('password', password);
                    }

                    // Add CSRF token
                    formData.append('csrf_token', '<?= $csrf_token ?>');

                    // Send update request
                    fetch('/HireFlow/public/systemadmin/usermanage', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.text())
                        .then(data => {
                            showToast('User updated successfully!', 'success');
                            closeUserModal();
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Failed to update user', 'error');
                        });
                }

                function closeUserModal() {
                    document.getElementById('userModal').style.display = 'none';
                }

                function saveUser() {
                    const form = document.getElementById('userForm');
                    const formData = new FormData(form);

                    console.log(formData);
                    // Basic validation
                    const password = formData.get('password');
                    const confirmPassword = formData.get('confirmPassword');

                    if (password !== confirmPassword) {
                        showToast('Passwords do not match', 'error');
                        return;
                    }

                    // Password strength validation
                    if (password.length < 8) {
                        showToast('Password must be at least 8 characters long', 'error');
                        return;
                    }

                    // Create user via AJAX
                    fetch('/HireFlow/public/systemadmin/usermanage/create', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Staff account created successfully!', 'success');
                                closeUserModal();
                                // Refresh the page to show new user
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                console.log(data.message)
                                showToast(data.message || 'Failed to create user', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('An error occurred while creating the user', 'error');
                        });
                }

                function editUser(userId) {
                    openUserModal('edit', userId);
                }

                function viewUser(userId) {
                    const formData = new FormData();
                    formData.append('action', 'fetch');
                    formData.append('user_id', userId);

                    fetch('/HireFlow/public/systemadmin/usermanage', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => {
                            const contentType = response.headers.get('content-type');
                            if (!contentType || !contentType.includes('application/json')) {
                                throw new Error('Server did not return JSON');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Show user details in a modal or view
                                showUserDetailsModal(data.user);
                            } else {
                                showToast('User not found: ' + (data.message || ''), 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Failed to load user data: ' + error.message, 'error');
                        });
                }

                function showUserDetailsModal(user) {
                    // Create a view-only modal with user details
                    const modal = document.getElementById('userModal');
                    const title = document.getElementById('modalTitle');
                    const form = document.getElementById('userForm');

                    title.textContent = 'View User Details';

                    // Populate fields
                    const nameParts = user.full_name.split(' ');
                    document.getElementById('firstName').value = nameParts[0] || '';
                    document.getElementById('lastName').value = nameParts.slice(1).join(' ') || '';
                    document.getElementById('email').value = user.email;
                    document.getElementById('phone').value = user.phone || '';

                    const roleMap = {
                        1: 'system_admin',
                        2: 'hr_admin',
                        3: 'recruitment_manager',
                        4: 'applicant'
                    };
                    document.getElementById('role').value = roleMap[user.role_id] || '';
                    document.getElementById('status').value = user.status;

                    // Clear password fields for view mode
                    document.getElementById('password').value = '';
                    document.getElementById('confirmPassword').value = '';

                    // Make all fields read-only AFTER populating them
                    form.querySelectorAll('input, select').forEach(field => {
                        field.setAttribute('readonly', true);
                        field.setAttribute('disabled', true);
                    });

                    // Hide action button
                    document.getElementById('action').style.display = 'none';

                    modal.style.display = 'block';
                }

                function deleteUser(userId) {
                    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                        const formData = new FormData();
                        formData.append('action', 'delete');
                        formData.append('user_id', userId);
                        formData.append('csrf_token', '<?= $csrf_token ?>');

                        fetch('/HireFlow/public/systemadmin/usermanage', {
                            method: 'POST',
                            body: formData
                        })
                            .then(response => response.text())
                            .then(data => {
                                showToast('User deleted successfully!', 'success');
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showToast('Failed to delete user', 'error');
                            });
                    }
                }

                function toggleUserStatus(userId) {
                    // Get current status from the row
                    const statusBadge = document.querySelector(`tr[data-user-id="${userId}"] .status-badge`);
                    const currentStatus = statusBadge.classList.contains('active') ? 'active' : 'inactive';
                    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';

                    const formData = new FormData();
                    formData.append('action', 'toggle_status');
                    formData.append('user_id', userId);
                    formData.append('status', newStatus);
                    formData.append('csrf_token', '<?= $csrf_token ?>');

                    fetch('/HireFlow/public/systemadmin/usermanage', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.text())
                        .then(data => {
                            showToast('User status updated successfully!', 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Failed to update user status', 'error');
                        });
                }

                function exportUsers() {
                    // Export users to CSV
                    showToast('Export started. Download will begin shortly.', 'info');
                }

                // Search and filter functionality
                document.getElementById('userSearch').addEventListener('input', function () {
                    filterUsers();
                });

                document.getElementById('roleFilter').addEventListener('change', function () {
                    filterUsers();
                });

                document.getElementById('statusFilter').addEventListener('change', function () {
                    filterUsers();
                });

                function filterUsers() {
                    const searchTerm = document.getElementById('userSearch').value.toLowerCase();
                    const roleFilter = document.getElementById('roleFilter').value;
                    const statusFilter = document.getElementById('statusFilter').value;
                    
                    // Filter table rows based on criteria
                    const rows = document.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        const name = row.cells[1].textContent.toLowerCase();
                        const email = row.cells[2].textContent.toLowerCase();
                        const role = row.cells[3].textContent.toLowerCase();
                        const status = row.cells[4].textContent.toLowerCase();

                        const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                        const matchesRole = !roleFilter || role.includes(roleFilter.toLowerCase());
                        const matchesStatus = !statusFilter || status.includes(statusFilter);

                        if (matchesSearch && matchesRole && matchesStatus) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }

                // Clear all filters
                function clearFilters() {
                    document.getElementById('userSearch').value = '';
                    document.getElementById('roleFilter').value = '';
                    document.getElementById('statusFilter').value = '';

                    // Show all rows
                    const rows = document.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        row.style.display = '';
                    });

                    showToast('Filters cleared', 'info');
                }

                // Select all functionality
                document.getElementById('selectAll').addEventListener('change', function () {
                    const checkboxes = document.querySelectorAll('.user-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });

                // Toast notification function
                function showToast(message, type) {
                    // Create and show toast notification
                    const toast = document.createElement('div');
                    toast.className = `toast toast-${type}`;
                    toast.textContent = message;
                    document.body.appendChild(toast);

                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                }

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