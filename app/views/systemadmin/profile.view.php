<?php $this->view('components/header') ?>

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
                    <a href="<?= ROOT ?>/systemadmin/accesslogs" class="nav-link">
                        <span class="nav-text">Access Logs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/backuprestore" class="nav-link">
                        <span class="nav-text">Backup & Restore</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/profile" class="nav-link active">
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

            <div class="profile-content">
                <form method="POST" action="<?= ROOT ?>/systemadmin/profile" class="profile-form"
                    enctype="multipart/form-data">

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
                    <div class="profile-header-card">
                        <img src="<?= ROOT ?>/assets/images/profiles/<?= $profileImage ?>" alt=""
                            class="profile_picture">
                        <div class="form-group">
                            <label for="profile_picture" class="form-label"></label>
                            <input hidden type="file" id="profile_picture" name="profile_picture" class="form-input"
                                accept="image/*">
                            <br>
                            <!-- <small class="text-muted">Accepted formats: JPG, PNG, GIF (Max 2MB)</small> -->
                        </div>
                        <div class="profile-header-info">
                            <h1 class="profile-name"><?= $_SESSION['USER']['full_name'] ?? 'System Administrator' ?>
                            </h1>
                            <p class="profile-role">System Administrator</p>
                            <p class="profile-email"><?= $_SESSION['USER']['email'] ?? '' ?></p>
                            <div class="profile-stats">
                                <div class="stat-item">
                                    <strong>User ID:</strong> <?= $_SESSION['USER']['id'] ?? 'SA001' ?>
                                </div>
                                <div class="stat-item">
                                    <strong>Status:</strong> <span class="status-active">Active</span>
                                </div>
                                <div class="stat-item">
                                    <strong>Last Login:</strong> <?= date('M j, Y g:i A') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Form -->
                    <div class="profile-form-container">
                        <!-- Personal Information Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <h3 class="section-title">Personal Information</h3>
                                <p class="section-description">Update your personal details and contact information</p>
                            </div>
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
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" id="address" name="address" class="form-input"
                                        value="<?= $_SESSION['USER']['address'] ?? '' ?>">
                                </div>

                                <div class="form-group">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" id="department" name="department" class="form-input"
                                        value="System Administration" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="role" class="form-label">Role</label>
                                    <input type="text" id="role" name="role" class="form-input"
                                        value="System Administrator" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Security Settings Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <h3 class="section-title">Security Settings</h3>
                                <p class="section-description">Change your password and security preferences</p>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" id="current_password" name="current_password"
                                        class="form-input">
                                    <small class="form-hint">Required only when changing password</small>
                                </div>

                                <div class="form-group">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" id="new_password" name="new_password" class="form-input">
                                    <small class="form-hint">Leave blank to keep current password</small>
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password"
                                        class="form-input">
                                </div>
                            </div>
                            <div class="password-requirements">
                                <h4>Password Requirements:</h4>
                                <ul>
                                    <li>At least 8 characters long</li>
                                    <li>Contains uppercase and lowercase letters</li>
                                    <li>Contains at least one number</li>
                                    <li>Contains at least one special character (@$!%*?&)</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-large">
                                <i class="icon-save"></i>Update Profile
                            </button>
                            <button type="button" class="btn btn-secondary btn-large" onclick="resetForm()">
                                <i class="icon-reset"></i>Reset Changes
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Quick Actions Card -->
                <div class="quick-actions-card">
                    <h3 class="card-title">Quick Actions</h3>
                    <div class="quick-actions-grid">
                        <a href="<?= ROOT ?>/systemadmin/usermanage" class="quick-action">
                            <!-- <div class="action-icon"></div> -->
                            <div class="action-content">
                                <h4>Manage Users</h4>
                                <p>Add, edit, or remove user accounts</p>
                            </div>
                        </a>
                        <a href="<?= ROOT ?>/systemadmin/reports" class="quick-action">
                            <!-- <div class="action-icon"></div> -->
                            <div class="action-content">
                                <h4>System Reports</h4>
                                <p>View analytics and system insights</p>
                            </div>
                        </a>
                        <a href="<?= ROOT ?>/systemadmin/accesslogs" class="quick-action">
                            <!-- <div class="action-icon"></div> -->
                            <div class="action-content">
                                <h4>Access Logs</h4>
                                <p>Monitor system access and security</p>
                            </div>
                        </a>
                        <a href="<?= ROOT ?>/systemadmin/dashboard" class="quick-action">
                            <!-- <div class="action-icon"></div> -->
                            <div class="action-content">
                                <h4>Dashboard</h4>
                                <p>Return to main dashboard</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-content {
            padding: 0;
        }

        .profile-header-card {
            background: linear-gradient(135deg, #4e31aa 0%, #3b2693 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
            box-shadow: 0 8px 25px rgba(78, 49, 170, 0.2);
        }

        .profile-header-card .profile_picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.3);
            margin-left: 20px;
        }

        .profile-avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .profile-avatar-large {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }

        .change-avatar-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .change-avatar-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .profile-header-info {
            flex: 1;
        }

        .profile-name {
            font-size: 2rem;
            margin: 0 0 8px 0;
            font-weight: 700;
        }

        .profile-role {
            font-size: 1.2rem;
            margin: 0 0 8px 0;
            opacity: 0.9;
        }

        .profile-email {
            font-size: 1rem;
            margin: 0 0 20px 0;
            opacity: 0.8;
        }

        .profile-stats {
            display: flex;
            gap: 30px;
        }

        .stat-item {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .status-active {
            color: #4ade80;
            font-weight: 600;
        }

        .profile-form-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            margin-bottom: 40px;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .section-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 8px 0;
        }

        .section-description {
            color: #64748b;
            margin: 0;
            font-size: 0.9rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-input {
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #4e31aa;
            box-shadow: 0 0 0 3px rgba(78, 49, 170, 0.1);
        }

        .form-input:read-only {
            background-color: #f8fafc;
            color: #64748b;
        }

        .form-hint {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 5px;
        }

        .password-requirements {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .password-requirements h4 {
            margin: 0 0 12px 0;
            font-size: 0.9rem;
            color: #374151;
        }

        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
        }

        .password-requirements li {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 5px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            padding-top: 30px;
            border-top: 2px solid #f1f5f9;
        }

        .btn-large {
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 600;
        }

        .quick-actions-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 25px 0;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .quick-action {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }

        .quick-action:hover {
            border-color: #4e31aa;
            box-shadow: 0 4px 15px rgba(78, 49, 170, 0.1);
            transform: translateY(-2px);
        }

        .action-icon {
            font-size: 1.5rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            border-radius: 8px;
        }

        .action-content h4 {
            margin: 0 0 4px 0;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
        }

        .action-content p {
            margin: 0;
            font-size: 0.8rem;
            color: #64748b;
        }

        @media (max-width: 768px) {
            .profile-header-card {
                flex-direction: column;
                text-align: center;
            }

            .profile-stats {
                flex-direction: column;
                gap: 10px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .quick-actions-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        function resetForm() {
            if (confirm('Are you sure you want to reset all changes?')) {
                document.querySelector('.profile-form').reset();
            }
        }

        function uploadPhoto() {
            const imageInput = document.querySelector('.profile_picture');
            imageInput.addEventListener('click',
                function () {
                    document.getElementById('profile_picture').click();
                });
        }
        uploadPhoto()


        // Password validation
        document.getElementById('confirm_password').addEventListener('input', function () {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;

            if (newPassword && confirmPassword && newPassword !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        // Form submission validation
        document.querySelector('.profile-form').addEventListener('submit', function (e) {
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