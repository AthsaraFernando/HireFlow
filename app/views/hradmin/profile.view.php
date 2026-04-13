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
                <div class="hero-section">
                    <div class="hero-content">
                        <h1 class="hero-title">My Profile</h1>
                        <p class="hero-description">Manage your personal information, account settings, and preferences to customize your HR admin experience.</p>
                        <div class="profile-meta">
                            <div class="meta-item">
                                <span class="meta-label">Role:</span>
                                <span class="meta-value">HR Administrator</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Department:</span>
                                <span class="meta-value">Human Resources</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Last Login:</span>
                                <span class="meta-value"><?= date('M d, Y H:i') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="hero-actions">
                        <button class="btn btn-primary" onclick="editProfile()">
                            <i class="icon-edit"></i>Edit Profile
                        </button>
                        <button class="btn btn-outline" onclick="changePassword()">
                            <i class="icon-key"></i>Change Password
                        </button>
                    </div>
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

                <!-- Beautiful Profile Hero Banner -->
                <div class="profile-hero-banner">
                    <div class="hero-gradient"></div>
                    <div class="hero-pattern"></div>
                    <div class="hero-content">
                        <div class="profile-avatar-section">
                            <div class="avatar-wrapper">
                                <div class="avatar-circle">
                                    <div class="avatar-initials">
                                        <?= substr($_SESSION['USER']['full_name'] ?? 'HR', 0, 2) ?>
                                    </div>
                                    <div class="avatar-status-indicator"></div>
                                </div>
                                <button class="avatar-change-button" title="Change Profile Picture">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="profile-hero-info">
                                <h1 class="hero-name"><?= $_SESSION['USER']['full_name'] ?? 'HR Administrator' ?></h1>
                                <div class="hero-badges">
                                    <span class="badge-role">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                        </svg>
                                        HR Administrator
                                    </span>
                                    <span class="badge-verified">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Verified
                                    </span>
                                </div>
                                <p class="hero-email">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                    <?= $_SESSION['USER']['email'] ?? 'admin@hireflow.com' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="beautiful-profile-grid">
                    <!-- Left Column - Main Form -->
                    <div class="profile-main-column">
                        <form method="POST" action="<?= ROOT ?>/hradmin/profile" class="beautiful-profile-form">
                            <!-- Personal Information Card -->
                            <div class="profile-card modern-card">
                                <div class="card-header-beautiful">
                                    <div class="header-icon-wrapper">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20" class="header-icon">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="header-text">
                                        <h3 class="card-title-beautiful">Personal Information</h3>
                                        <p class="card-subtitle-beautiful">Update your profile details</p>
                                    </div>
                                </div>
                                
                                <div class="card-body-beautiful">
                                    <div class="input-row">
                                        <div class="input-group-beautiful">
                                            <label for="full_name" class="label-beautiful">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                                Full Name
                                            </label>
                                            <input type="text" id="full_name" name="full_name" class="input-beautiful" 
                                                   value="<?= $_SESSION['USER']['full_name'] ?? '' ?>" 
                                                   placeholder="Enter your full name" required>
                                        </div>
                                        
                                        <div class="input-group-beautiful">
                                            <label for="email" class="label-beautiful">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                                </svg>
                                                Email Address
                                            </label>
                                            <input type="email" id="email" name="email" class="input-beautiful" 
                                                   value="<?= $_SESSION['USER']['email'] ?? '' ?>" 
                                                   placeholder="your.email@hireflow.com" required>
                                        </div>
                                    </div>

                                    <div class="input-row">
                                        <div class="input-group-beautiful">
                                            <label for="phone" class="label-beautiful">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                </svg>
                                                Phone Number
                                            </label>
                                            <input type="tel" id="phone" name="phone" class="input-beautiful" 
                                                   value="<?= $_SESSION['USER']['phone'] ?? '' ?>" 
                                                   placeholder="+1 (555) 000-0000">
                                        </div>

                                        <div class="input-group-beautiful">
                                            <label for="department" class="label-beautiful">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                                                </svg>
                                                Department
                                            </label>
                                            <input type="text" id="department" name="department" class="input-beautiful input-readonly" 
                                                   value="Human Resources" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Security Settings Card -->
                            <div class="profile-card modern-card">
                                <div class="card-header-beautiful">
                                    <div class="header-icon-wrapper">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20" class="header-icon">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="header-text">
                                        <h3 class="card-title-beautiful">Security Settings</h3>
                                        <p class="card-subtitle-beautiful">Manage your password</p>
                                    </div>
                                </div>
                                
                                <div class="card-body-beautiful">
                                    <div class="input-row-single">
                                        <div class="input-group-beautiful">
                                            <label for="current_password" class="label-beautiful">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Current Password
                                            </label>
                                            <input type="password" id="current_password" name="current_password" class="input-beautiful" 
                                                   placeholder="Enter your current password">
                                            <small class="input-hint">Leave blank to keep your current password</small>
                                        </div>
                                    </div>

                                    <div class="input-row">
                                        <div class="input-group-beautiful">
                                            <label for="new_password" class="label-beautiful">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                                </svg>
                                                New Password
                                            </label>
                                            <input type="password" id="new_password" name="new_password" class="input-beautiful" 
                                                   placeholder="Enter new password">
                                            <small class="input-hint">Min. 8 characters, uppercase, lowercase, number & symbol</small>
                                        </div>

                                        <div class="input-group-beautiful">
                                            <label for="confirm_password" class="label-beautiful">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Confirm Password
                                            </label>
                                            <input type="password" id="confirm_password" name="confirm_password" class="input-beautiful" 
                                                   placeholder="Confirm new password">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="form-actions-beautiful">
                                <button type="button" class="btn-beautiful btn-secondary-beautiful" onclick="resetForm()">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                    </svg>
                                    Reset Changes
                                </button>
                                <button type="submit" class="btn-beautiful btn-primary-beautiful">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right Column - Sidebar -->
                    <div class="profile-sidebar-column">
                        <!-- Account Info Card -->
                        <div class="sidebar-card-beautiful modern-card">
                            <div class="sidebar-card-header">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <h4 class="sidebar-card-title">Account Information</h4>
                            </div>
                            <div class="sidebar-card-body">
                                <div class="info-item-beautiful">
                                    <span class="info-label-beautiful">User ID</span>
                                    <span class="info-value-beautiful"><?= $_SESSION['USER']['id'] ?? 'HR001' ?></span>
                                </div>
                                <div class="info-item-beautiful">
                                    <span class="info-label-beautiful">Role</span>
                                    <span class="badge-role-small">HR Administrator</span>
                                </div>
                                <div class="info-item-beautiful">
                                    <span class="info-label-beautiful">Status</span>
                                    <span class="badge-status-active">
                                        <span class="status-pulse"></span>
                                        Active
                                    </span>
                                </div>
                                <div class="info-item-beautiful">
                                    <span class="info-label-beautiful">Member Since</span>
                                    <span class="info-value-beautiful"><?= date('M Y') ?></span>
                                </div>
                                <div class="info-item-beautiful">
                                    <span class="info-label-beautiful">Last Login</span>
                                    <span class="info-value-beautiful"><?= date('M j, g:i A') ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions Card -->
                        <div class="sidebar-card-beautiful modern-card">
                            <div class="sidebar-card-header">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                </svg>
                                <h4 class="sidebar-card-title">Quick Actions</h4>
                            </div>
                            <div class="quick-actions-beautiful">
                                <a href="<?= ROOT ?>/hradmin/create-job" class="action-item-beautiful">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Create Job Post</span>
                                </a>
                                <a href="<?= ROOT ?>/hradmin/applications" class="action-item-beautiful">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Review Applications</span>
                                </a>
                                <a href="<?= ROOT ?>/hradmin/interview-schedule" class="action-item-beautiful">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Schedule Interview</span>
                                </a>
                                <a href="<?= ROOT ?>/hradmin/reports" class="action-item-beautiful">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                    </svg>
                                    <span>View Reports</span>
                                </a>
                            </div>
                        </div>

                        <!-- Activity Stats Card -->
                        <div class="sidebar-card-beautiful modern-card">
                            <div class="sidebar-card-header">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1zm1-4a1 1 0 100 2h.01a1 1 0 100-2H7zm2 1a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zm4-4a1 1 0 100 2h.01a1 1 0 100-2H13zM9 9a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zM7 8a1 1 0 000 2h.01a1 1 0 000-2H7z" clip-rule="evenodd"/>
                                </svg>
                                <h4 class="sidebar-card-title">Activity Summary</h4>
                            </div>
                            <div class="activity-stats-beautiful">
                                <div class="stat-item-beautiful">
                                    <div class="stat-icon-beautiful stat-blue">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="stat-details-beautiful">
                                        <span class="stat-number-beautiful">24</span>
                                        <span class="stat-label-beautiful">Jobs Posted</span>
                                    </div>
                                </div>
                                <div class="stat-item-beautiful">
                                    <div class="stat-icon-beautiful stat-green">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                        </svg>
                                    </div>
                                    <div class="stat-details-beautiful">
                                        <span class="stat-number-beautiful">156</span>
                                        <span class="stat-label-beautiful">Apps Reviewed</span>
                                    </div>
                                </div>
                                <div class="stat-item-beautiful">
                                    <div class="stat-icon-beautiful stat-purple">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="stat-details-beautiful">
                                        <span class="stat-number-beautiful">12</span>
                                        <span class="stat-label-beautiful">Interviews</span>
                                    </div>
                                </div>
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
</script>

<!-- Modern HR Admin Design System -->
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --background-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
        --card-hover-shadow: 0 20px 40px rgba(0,0,0,0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-content {
        background: var(--background-gradient);
        min-height: 100vh;
        padding: 2rem;
    }

    .hero-section {
        background: linear-gradient(135deg, #4c63d2 0%, #5a67d8 50%, #667eea 100%);
        color: white;
        padding: 3rem 2.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2.5rem;
        box-shadow: var(--card-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.1);
        border-radius: var(--border-radius);
        pointer-events: none;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: #ffffff;
        text-shadow: 0 4px 12px rgba(0,0,0,0.3);
        position: relative;
        z-index: 1;
    }

    .hero-description {
        font-size: 1.125rem;
        opacity: 1;
        margin-bottom: 1.5rem;
        color: rgba(255,255,255,0.95);
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }

    .profile-meta {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .meta-label {
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .meta-value {
        font-weight: 600;
        font-size: 1rem;
    }

    .btn {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background: white;
        color: #667eea;
        box-shadow: 0 8px 25px rgba(255,255,255,0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(255,255,255,0.4);
    }

    .btn-outline {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .btn-outline:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-3px);
    }

    .profile-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    .action-item-beautiful {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: white;
        border-radius: 12px;
        text-decoration: none;
        color: #2d3748;
        transition: var(--transition);
        box-shadow: var(--card-shadow);
        margin-bottom: 1rem;
    }

    .action-item-beautiful:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-hover-shadow);
        color: #667eea;
    }

    .icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .alert {
        padding: 1.5rem 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        font-weight: 500;
    }

    .alert-error {
        background: linear-gradient(135deg, #feb2b2, #f56565);
        color: white;
        box-shadow: 0 8px 25px rgba(245, 101, 101, 0.3);
    }

    .alert-success {
        background: linear-gradient(135deg, #9ae6b4, #48bb78);
        color: white;
        box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
    }

    @media (max-width: 768px) {
        .hero-section {
            flex-direction: column;
            text-align: center;
        }
        .dashboard-content {
            padding: 1rem;
        }
    }
</style>

<script>
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
