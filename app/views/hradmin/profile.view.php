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
                    <a href="<?= ROOT ?>/hradmin/categories" class="nav-link">
                        <span class="nav-text">Categories</span>
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
                                <button type="button" class="avatar-change-button" title="Change Profile Picture">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </button>
                                <input type="file" id="avatarFileInput" accept="image/*" style="display:none;">
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
                                <a href="<?= ROOT ?>/hradmin/applicant-database?tab=applications" class="action-item-beautiful">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Review Applications</span>
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
function editProfile() {
    const fullNameInput = document.getElementById('full_name');
    if (fullNameInput) {
        fullNameInput.focus();
        fullNameInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

function changePassword() {
    const currentPasswordInput = document.getElementById('current_password');
    if (currentPasswordInput) {
        currentPasswordInput.focus();
        currentPasswordInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        const profileForm = document.querySelector('.beautiful-profile-form');
        if (profileForm) {
            profileForm.reset();
        }
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
const profileForm = document.querySelector('.beautiful-profile-form');
if (profileForm) {
    profileForm.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const currentPassword = document.getElementById('current_password').value;

        if (newPassword && !currentPassword) {
            e.preventDefault();
            alert('Please enter your current password to change your password');
            return false;
        }
    });
}

const avatarButton = document.querySelector('.avatar-change-button');
const avatarFileInput = document.getElementById('avatarFileInput');
const avatarCircle = document.querySelector('.avatar-circle');

if (avatarButton && avatarFileInput) {
    avatarButton.addEventListener('click', function() {
        avatarFileInput.click();
    });
}

if (avatarFileInput && avatarCircle) {
    avatarFileInput.addEventListener('change', function(event) {
        const selectedFile = event.target.files && event.target.files[0];
        if (!selectedFile) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function(loadEvent) {
            avatarCircle.style.backgroundImage = `url('${loadEvent.target.result}')`;
            avatarCircle.style.backgroundSize = 'cover';
            avatarCircle.style.backgroundPosition = 'center';

            const initialsNode = avatarCircle.querySelector('.avatar-initials');
            if (initialsNode) {
                initialsNode.style.opacity = '0';
            }
        };
        reader.readAsDataURL(selectedFile);
    });
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
</script>

<!-- Modern HR Admin Design System -->
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --background-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --card-border: #e7e9f3;
        --card-shadow: 0 10px 24px rgba(86, 76, 207, 0.08);
        --hover-shadow: 0 18px 30px rgba(86, 76, 207, 0.15);
        --radius: 16px;
        --text-primary: #2f3552;
        --text-secondary: #6d7485;
    }

    .dashboard-content {
        background: var(--background-gradient);
        min-height: 100vh;
        padding: 1.5rem;
    }

    .main-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .hero-section {
        background: var(--primary-gradient);
        color: #fff;
        border-radius: 18px;
        padding: 1.8rem;
        margin-bottom: 1rem;
        box-shadow: 0 14px 28px rgba(86, 76, 207, 0.22);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .hero-title {
        font-size: 2rem;
        font-weight: 800;
        margin: 0 0 0.5rem;
        color: #fff;
    }

    .hero-description {
        margin: 0;
        color: rgba(255, 255, 255, 0.92);
    }

    .profile-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .meta-item {
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.26);
        border-radius: 10px;
        padding: 0.5rem 0.7rem;
        min-width: 150px;
    }

    .meta-label {
        font-size: 0.75rem;
        opacity: 0.9;
    }

    .meta-value {
        font-size: 0.85rem;
        font-weight: 700;
    }

    .hero-actions {
        display: flex;
        gap: 0.7rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.64rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-primary {
        background: #fff;
        color: #5a4ccf;
    }

    .btn-primary:hover {
        background: #f4f2ff;
        transform: translateY(-1px);
    }

    .btn-outline {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.38);
    }

    .btn-outline:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .alert {
        border-radius: 10px;
        margin-bottom: 0.9rem;
        padding: 0.85rem 1rem;
    }

    .alert-error {
        background: #ffe9ee;
        color: #a03a57;
        border: 1px solid #ffd2dc;
    }

    .alert-success {
        background: #eafbf2;
        color: #1f8d56;
        border: 1px solid #c9efd9;
    }

    .profile-hero-banner {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius);
        background: #fff;
        border: 1px solid var(--card-border);
        box-shadow: var(--card-shadow);
        margin-bottom: 1rem;
    }

    .hero-gradient {
        position: absolute;
        inset: 0;
        background: var(--primary-gradient);
        opacity: 0.06;
    }

    .hero-pattern {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 20px 20px, rgba(102, 126, 234, 0.2) 2px, transparent 0);
        background-size: 24px 24px;
        opacity: 0.2;
    }

    .profile-hero-banner .hero-content {
        position: relative;
        z-index: 2;
        padding: 1.2rem;
    }

    .profile-avatar-section {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .avatar-wrapper {
        position: relative;
        width: 92px;
        height: 92px;
    }

    .avatar-circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.5rem;
        font-weight: 800;
        border: 3px solid #fff;
        box-shadow: 0 6px 16px rgba(86, 76, 207, 0.25);
    }

    .avatar-status-indicator {
        position: absolute;
        right: 5px;
        bottom: 6px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #1f8d56;
        border: 2px solid #fff;
    }

    .avatar-change-button {
        position: absolute;
        right: -6px;
        top: -6px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1px solid #dfe4f6;
        background: #fff;
        color: #5a4ccf;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .hero-name {
        margin: 0;
        color: var(--text-primary);
    }

    .hero-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 0.45rem 0;
    }

    .badge-role,
    .badge-verified,
    .badge-role-small {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.22rem 0.58rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .badge-role,
    .badge-role-small {
        background: #edf1ff;
        color: #4052b5;
    }

    .badge-verified {
        background: #eafbf2;
        color: #1f8d56;
    }

    .hero-email {
        display: inline-flex;
        gap: 0.4rem;
        align-items: center;
        color: var(--text-secondary);
        margin: 0;
        font-size: 0.9rem;
    }

    .beautiful-profile-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr);
        gap: 1rem;
    }

    .profile-main-column,
    .profile-sidebar-column {
        min-width: 0;
    }

    .modern-card {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        box-shadow: var(--card-shadow);
    }

    .profile-card {
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .card-header-beautiful,
    .sidebar-card-header {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 1rem 1.1rem;
        border-bottom: 1px solid #ececf5;
        background: linear-gradient(135deg, #fafaff 0%, #f4f5ff 100%);
    }

    .header-icon-wrapper {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #edf1ff;
        color: #4052b5;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-title-beautiful,
    .sidebar-card-title {
        margin: 0;
        color: #3d3e8e;
        font-size: 1rem;
    }

    .card-subtitle-beautiful {
        margin: 0.2rem 0 0;
        color: var(--text-secondary);
        font-size: 0.82rem;
    }

    .card-body-beautiful,
    .sidebar-card-body,
    .quick-actions-beautiful,
    .activity-stats-beautiful {
        padding: 1rem 1.1rem;
    }

    .input-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.8rem;
        margin-bottom: 0.8rem;
    }

    .input-row-single {
        margin-bottom: 0.8rem;
    }

    .input-group-beautiful {
        display: flex;
        flex-direction: column;
        gap: 0.42rem;
    }

    .label-beautiful {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.82rem;
        font-weight: 700;
        color: #4d5470;
    }

    .input-beautiful {
        border: 1px solid #d8def2;
        border-radius: 10px;
        padding: 0.62rem 0.72rem;
        font-size: 0.9rem;
        color: var(--text-primary);
        background: #fafbff;
    }

    .input-beautiful:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.12);
        background: #fff;
    }

    .input-readonly {
        background: #f0f2f8;
        color: #6f778b;
    }

    .input-hint {
        color: #7a8195;
        font-size: 0.75rem;
    }

    .form-actions-beautiful {
        display: flex;
        justify-content: flex-end;
        gap: 0.6rem;
        margin-top: 0.8rem;
    }

    .btn-beautiful {
        border-radius: 10px;
        border: none;
        padding: 0.62rem 0.95rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .btn-primary-beautiful {
        background: var(--primary-gradient);
        color: #fff;
    }

    .btn-secondary-beautiful {
        background: #edf1ff;
        color: #4052b5;
    }

    .info-item-beautiful {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.7rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f0f2f9;
    }

    .info-item-beautiful:last-child {
        border-bottom: none;
    }

    .info-label-beautiful {
        color: #6f778b;
        font-size: 0.82rem;
    }

    .info-value-beautiful {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 0.84rem;
    }

    .badge-status-active {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: #eafbf2;
        color: #1f8d56;
        border: 1px solid #c9efd9;
        border-radius: 999px;
        padding: 0.2rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .status-pulse {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #1f8d56;
    }

    .quick-actions-beautiful {
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .action-item-beautiful {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        text-decoration: none;
        background: #fafbff;
        border: 1px solid #edf0fa;
        border-radius: 10px;
        color: #3f4560;
        padding: 0.65rem 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .action-item-beautiful:hover {
        background: #f1f5ff;
        border-color: #dce5ff;
        color: #4052b5;
        transform: translateY(-1px);
    }

    .stat-item-beautiful {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        border: 1px solid #edf0fa;
        background: #fafbff;
        border-radius: 10px;
        padding: 0.62rem 0.72rem;
        margin-bottom: 0.5rem;
    }

    .stat-item-beautiful:last-child {
        margin-bottom: 0;
    }

    .stat-icon-beautiful {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-blue { background: #e9f0ff; color: #3159c7; }
    .stat-green { background: #eafbf2; color: #1f8d56; }
    .stat-purple { background: #f0ebff; color: #5a4ccf; }

    .stat-number-beautiful {
        display: block;
        color: #334;
        font-size: 1.05rem;
        font-weight: 800;
        line-height: 1;
    }

    .stat-label-beautiful {
        display: block;
        margin-top: 0.2rem;
        color: #6f778b;
        font-size: 0.78rem;
    }

    @media (max-width: 1024px) {
        .beautiful-profile-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .dashboard-content {
            padding: 1rem;
        }

        .hero-section {
            padding: 1.2rem;
        }

        .hero-title {
            font-size: 1.6rem;
        }

        .input-row {
            grid-template-columns: 1fr;
        }

        .form-actions-beautiful {
            justify-content: stretch;
            flex-direction: column;
        }

        .btn-beautiful {
            justify-content: center;
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
