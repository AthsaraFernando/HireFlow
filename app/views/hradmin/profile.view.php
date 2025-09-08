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
                    <a href="<?= ROOT ?>/hradmin/applications" class="nav-link">
                        <span class="nav-text">Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/applicant-database" class="nav-link">
                        <span class="nav-text">Applicant Database</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/interview-schedule" class="nav-link">
                        <span class="nav-text">Interviews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/reports" class="nav-link">
                        <span class="nav-text">Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/profile" class="nav-link active">
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
                <h1 class="page-title">My Profile</h1>
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
                <div class="header-section">
                    <h1 class="page-title">My Profile</h1>
                    <p class="page-description">Manage your personal information and account settings</p>
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

                <div class="profile-container">
                    <div class="profile-main">
                        <!-- Profile Header -->
                        <div class="profile-header">
                            <div class="profile-avatar">
                                <div class="avatar-image">
                                    <?= substr($_SESSION['USER']['full_name'] ?? 'HR', 0, 2) ?>
                                </div>
                                <button class="avatar-change-btn">Change Photo</button>
                            </div>
                            <div class="profile-info">
                                <h2 class="profile-name"><?= $_SESSION['USER']['full_name'] ?? 'HR Administrator' ?></h2>
                                <p class="profile-role">HR Administrator</p>
                                <p class="profile-email"><?= $_SESSION['USER']['email'] ?? '' ?></p>
                            </div>
                        </div>

                        <!-- Profile Form -->
                        <form method="POST" action="<?= ROOT ?>/hradmin/profile" class="profile-form">
                            <div class="form-section">
                                <h3 class="section-title">Personal Information</h3>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="full_name" class="form-label">Full Name</label>
                                        <input type="text" id="full_name" name="full_name" class="form-input" 
                                               value="<?= $_SESSION['USER']['full_name'] ?? '' ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-input" 
                                               value="<?= $_SESSION['USER']['email'] ?? '' ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" class="form-input" 
                                               value="<?= $_SESSION['USER']['phone'] ?? '' ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" id="department" name="department" class="form-input" 
                                               value="Human Resources" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="section-title">Security Settings</h3>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" id="current_password" name="current_password" class="form-input">
                                        <small class="form-hint">Leave blank to keep current password</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" id="new_password" name="new_password" class="form-input">
                                        <small class="form-hint">Minimum 8 characters with uppercase, lowercase, number and special character</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                                        <input type="password" id="confirm_password" name="confirm_password" class="form-input">
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                            </div>
                        </form>
                    </div>

                    <!-- Profile Sidebar -->
                    <div class="profile-sidebar">
                        <div class="sidebar-card">
                            <h4 class="card-title">Account Information</h4>
                            <div class="info-list">
                                <div class="info-item">
                                    <span class="info-label">User ID</span>
                                    <span class="info-value"><?= $_SESSION['USER']['id'] ?? 'HR001' ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Role</span>
                                    <span class="info-value">HR Administrator</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Status</span>
                                    <span class="status-badge status-active">Active</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Last Login</span>
                                    <span class="info-value"><?= date('M j, Y g:i A') ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-card">
                            <h4 class="card-title">Quick Actions</h4>
                            <div class="action-list">
                                <a href="<?= ROOT ?>/hradmin/create-job" class="action-link">
                                    <i class="icon-plus"></i>Create New Job Post
                                </a>
                                <a href="<?= ROOT ?>/hradmin/applications" class="action-link">
                                    <i class="icon-applications"></i>Review Applications
                                </a>
                                <a href="<?= ROOT ?>/hradmin/interview-schedule" class="action-link">
                                    <i class="icon-calendar"></i>Schedule Interview
                                </a>
                                <a href="<?= ROOT ?>/hradmin/reports" class="action-link">
                                    <i class="icon-reports"></i>View Reports
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        document.querySelector('.profile-form').reset();
    }
}

// Password validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (newPassword && confirmPassword && newPassword !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});

// Form submission validation
document.querySelector('.profile-form').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password').value;
    const currentPassword = document.getElementById('current_password').value;
    
    if (newPassword && !currentPassword) {
        e.preventDefault();
        alert('Please enter your current password to change your password');
        return false;
    }
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
</script>

<?php $this->view('components/footer') ?>
