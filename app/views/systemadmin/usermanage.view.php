<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">User Management</h1>
        <p class="page-description">Manage system users, roles, and permissions</p>
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

    <!-- User Statistics Cards -->
    <div class="card-grid">
        <div class="metric-card">
            <div class="metric-value"><?= count($users ?? []) ?></div>
            <div class="metric-label">Total Users</div>
            <div class="metric-change neutral">All registered users</div>
        </div>
        <div class="metric-card">
            <?php 
                $activeUsers = array_filter($users ?? [], function($user) { return $user['status'] === 'active'; });
            ?>
            <div class="metric-value"><?= count($activeUsers) ?></div>
            <div class="metric-label">Active Users</div>
            <div class="metric-change positive">Currently active</div>
        </div>
        <div class="metric-card">
            <?php 
                $inactiveUsers = array_filter($users ?? [], function($user) { return $user['status'] === 'inactive'; });
            ?>
            <div class="metric-value"><?= count($inactiveUsers) ?></div>
            <div class="metric-label">Inactive Users</div>
            <div class="metric-change neutral">Currently inactive</div>
        </div>
        <div class="metric-card">
            <div class="metric-value"><?= count($roles ?? []) ?></div>
            <div class="metric-label">User Roles</div>
            <div class="metric-change neutral">Available roles</div>
        </div>
    </div>

    <!-- User Management Actions -->
    <div class="action-section">
        <div class="action-buttons">
            <?php if ($can_manage_users ?? false): ?>
                <button class="btn btn-primary" onclick="openUserModal('add')">
                    <i class="icon-plus"></i>Add Staff User
                </button>
                <button class="btn btn-secondary" onclick="exportUsers()">
                    <i class="icon-download"></i>Export Users
                </button>
                <button class="btn btn-secondary" onclick="openBulkActionsModal()">
                    <i class="icon-edit"></i>Bulk Actions
                </button>
            <?php else: ?>
                <div class="alert alert-info">
                    <p><strong>View Only Mode:</strong> You can view user information but cannot manage users. Contact a System Administrator for user management tasks.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if ($can_manage_users ?? false): ?>
            <div class="info-note">
                <p class="text-muted small">
                    <strong>Note:</strong> Applicants self-register. Only create HR Admin and Recruitment Manager accounts here.
                </p>
            </div>
        <?php endif; ?>
        
        <div class="search-filter">
            <input type="text" placeholder="Search users..." class="search-input" id="userSearch">
            <select class="filter-select" id="roleFilter">
                <option value="">All Roles</option>
                <option value="system_admin">System Admin</option>
                <option value="hr_admin">HR Admin</option>
                <option value="recruitment_manager">Recruitment Manager</option>
                <option value="applicant">Applicant</option>
            </select>
            <select class="filter-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="suspended">Suspended</option>
            </select>
        </div>
    </div>

    <!-- Users Table -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
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
                            $roleClass = str_replace(' ', '-', strtolower($user['role_name'] ?? 'unknown'));
                            
                            // Format dates
                            $lastLogin = $user['last_login'] ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'Never';
                            $createdDate = date('M j, Y', strtotime($user['created_at']));
                        ?>
                        <tr data-user-id="<?= $user['id'] ?>">
                            <td><input type="checkbox" class="user-checkbox" value="<?= $user['id'] ?>"></td>
                            <td>USR-<?= str_pad($user['id'], 3, '0', STR_PAD_LEFT) ?></td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar"><?= $initials ?></div>
                                    <div>
                                        <div class="user-name"><?= htmlspecialchars($user['full_name']) ?></div>
                                        <div class="user-meta"><?= htmlspecialchars($user['role_name'] ?? 'Unknown Role') ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><span class="role-badge <?= $roleClass ?>"><?= htmlspecialchars($user['role_name'] ?? 'Unknown') ?></span></td>
                            <td><span class="status-badge <?= $user['status'] ?>"><?= ucfirst($user['status']) ?></span></td>
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
                                        <button class="btn-icon danger" onclick="toggleUserStatus(<?= $user['id'] ?>)" title="<?= $user['status'] === 'active' ? 'Suspend' : 'Activate' ?>">
                                            <i class="icon-<?= $user['status'] === 'active' ? 'pause' : 'play' ?>"></i>
                                        </button>
                                        <button class="btn-icon danger" onclick="deleteUser(<?= $user['id'] ?>)" title="Delete">
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
                            <p>No users found. <a href="#" onclick="openUserModal('add')">Create the first user</a></p>
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
            <div class="info-box mb-3">
                <p class="text-muted small">
                    <strong>Account Creation Policy:</strong> Only create HR Admin and Recruitment Manager accounts here. 
                    Applicants register themselves through the public signup page.
                </p>
            </div>
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
                        <small class="form-text">Applicant accounts are created through public registration</small>
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
                    <small>Minimum 8 characters with at least one uppercase, lowercase, number and special character</small>
                </div>
                
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password *</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="sendWelcome" name="sendWelcome" checked>
                        Send welcome email to user
                    </label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeUserModal()">Cancel</button>
            <button type="submit" class="btn btn-primary" onclick="saveUser()">Create Staff Account</button>
        </div>
    </div>
</div>

<script>
// User management functionality
function openUserModal(action, userId = null) {
    const modal = document.getElementById('userModal');
    const title = document.getElementById('modalTitle');
    const form = document.getElementById('userForm');
    
    if (action === 'add') {
        title.textContent = 'Add Staff User';
        form.reset();
    } else if (action === 'edit') {
        title.textContent = 'Edit User';
        // Load user data for editing
        loadUserData(userId);
    }
    
    modal.style.display = 'block';
}

function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
}

function saveUser() {
    const form = document.getElementById('userForm');
    const formData = new FormData(form);
    
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
    // Open user details view
    window.location.href = `/HireFlow/public/systemadmin/userdetails/${userId}`;
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
document.getElementById('userSearch').addEventListener('input', function() {
    filterUsers();
});

document.getElementById('roleFilter').addEventListener('change', function() {
    filterUsers();
});

document.getElementById('statusFilter').addEventListener('change', function() {
    filterUsers();
});

function filterUsers() {
    const searchTerm = document.getElementById('userSearch').value.toLowerCase();
    const roleFilter = document.getElementById('roleFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    
    // Filter table rows based on criteria
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const name = row.querySelector('.user-name').textContent.toLowerCase();
        const email = row.cells[3].textContent.toLowerCase();
        const role = row.querySelector('.role-badge').textContent.toLowerCase();
        const status = row.querySelector('.status-badge').textContent.toLowerCase();
        
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

// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
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
</script>

<?php $this->view('components/footer') ?>