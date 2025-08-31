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
            <div class="metric-value">156</div>
            <div class="metric-label">Total Users</div>
            <div class="metric-change positive">+12 this month</div>
        </div>
        <div class="metric-card">
            <div class="metric-value">89</div>
            <div class="metric-label">Active Users</div>
            <div class="metric-change positive">+5 this week</div>
        </div>
        <div class="metric-card">
            <div class="metric-value">67</div>
            <div class="metric-label">Inactive Users</div>
            <div class="metric-change neutral">No change</div>
        </div>
        <div class="metric-card">
            <div class="metric-value">4</div>
            <div class="metric-label">User Roles</div>
            <div class="metric-change neutral">Stable</div>
        </div>
    </div>

    <!-- User Management Actions -->
    <div class="action-section">
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="openUserModal('add')">
                <i class="icon-plus"></i>Add Staff User
            </button>
            <button class="btn btn-secondary" onclick="exportUsers()">
                <i class="icon-download"></i>Export Users
            </button>
            <button class="btn btn-secondary" onclick="openBulkActionsModal()">
                <i class="icon-edit"></i>Bulk Actions
            </button>
        </div>
        
        <div class="info-note">
            <p class="text-muted small">
                <strong>Note:</strong> Applicants self-register. Only create HR Admin and Recruitment Manager accounts here.
            </p>
        </div>
        
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
                <tr>
                    <td><input type="checkbox" class="user-checkbox" value="1"></td>
                    <td>USR-001</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">JD</div>
                            <div>
                                <div class="user-name">John Doe</div>
                                <div class="user-meta">Administrator</div>
                            </div>
                        </div>
                    </td>
                    <td>john.doe@company.com</td>
                    <td><span class="role-badge system-admin">System Admin</span></td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>2024-01-15 10:30 AM</td>
                    <td>2024-01-01</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="viewUser(1)" title="View">
                                <i class="icon-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editUser(1)" title="Edit">
                                <i class="icon-edit"></i>
                            </button>
                            <button class="btn-icon danger" onclick="toggleUserStatus(1)" title="Suspend">
                                <i class="icon-pause"></i>
                            </button>
                            <button class="btn-icon danger" onclick="deleteUser(1)" title="Delete">
                                <i class="icon-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="user-checkbox" value="2"></td>
                    <td>USR-002</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">MS</div>
                            <div>
                                <div class="user-name">Mary Smith</div>
                                <div class="user-meta">HR Manager</div>
                            </div>
                        </div>
                    </td>
                    <td>mary.smith@company.com</td>
                    <td><span class="role-badge hr-admin">HR Admin</span></td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>2024-01-15 09:15 AM</td>
                    <td>2024-01-02</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="viewUser(2)" title="View">
                                <i class="icon-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editUser(2)" title="Edit">
                                <i class="icon-edit"></i>
                            </button>
                            <button class="btn-icon danger" onclick="toggleUserStatus(2)" title="Suspend">
                                <i class="icon-pause"></i>
                            </button>
                            <button class="btn-icon danger" onclick="deleteUser(2)" title="Delete">
                                <i class="icon-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="user-checkbox" value="3"></td>
                    <td>USR-003</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">RJ</div>
                            <div>
                                <div class="user-name">Robert Johnson</div>
                                <div class="user-meta">Recruiter</div>
                            </div>
                        </div>
                    </td>
                    <td>robert.johnson@company.com</td>
                    <td><span class="role-badge recruitment-manager">Recruitment Manager</span></td>
                    <td><span class="status-badge inactive">Inactive</span></td>
                    <td>2024-01-10 04:20 PM</td>
                    <td>2024-01-03</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="viewUser(3)" title="View">
                                <i class="icon-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editUser(3)" title="Edit">
                                <i class="icon-edit"></i>
                            </button>
                            <button class="btn-icon success" onclick="toggleUserStatus(3)" title="Activate">
                                <i class="icon-play"></i>
                            </button>
                            <button class="btn-icon danger" onclick="deleteUser(3)" title="Delete">
                                <i class="icon-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="user-checkbox" value="4"></td>
                    <td>USR-004</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">LD</div>
                            <div>
                                <div class="user-name">Lisa Davis</div>
                                <div class="user-meta">Job Seeker</div>
                            </div>
                        </div>
                    </td>
                    <td>lisa.davis@email.com</td>
                    <td><span class="role-badge applicant">Applicant</span></td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>2024-01-14 02:45 PM</td>
                    <td>2024-01-05</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="viewUser(4)" title="View">
                                <i class="icon-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editUser(4)" title="Edit">
                                <i class="icon-edit"></i>
                            </button>
                            <button class="btn-icon danger" onclick="toggleUserStatus(4)" title="Suspend">
                                <i class="icon-pause"></i>
                            </button>
                            <button class="btn-icon danger" onclick="deleteUser(4)" title="Delete">
                                <i class="icon-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination-info">Showing 1-4 of 156 users</div>
        <div class="pagination">
            <button class="pagination-btn" disabled>Previous</button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">...</button>
            <button class="pagination-btn">39</button>
            <button class="pagination-btn">Next</button>
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
    
    // Here you would make an AJAX call to save the user
    showToast('Staff account created successfully!', 'success');
    closeUserModal();
    // Refresh the user table
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
        // Make AJAX call to delete user
        showToast('User deleted successfully!', 'success');
        // Refresh the user table
    }
}

function toggleUserStatus(userId) {
    // Toggle user active/inactive status
    showToast('User status updated successfully!', 'success');
    // Refresh the user table
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