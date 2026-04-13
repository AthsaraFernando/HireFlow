<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/profile.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
    <style>
        .profile-content {
            padding: 32px;
            background-color: #f8fafc;
            min-height: calc(100vh - 96px);
            display: flex;
            flex-direction: column;
            gap: 24px;
            padding-bottom: 56px;
        }
        .profile-header-card {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 16px;
            padding: 28px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 28px;
            box-shadow: 0 8px 32px rgba(59, 130, 246, 0.3);
        }
        .profile-photo-section { flex-shrink: 0; }
        .profile-avatar {
            width: 96px;
            height: 96px;
            background: rgba(255, 255, 255, 0.2);
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.25rem;
            font-weight: 700;
            position: relative;
        }
        .profile-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            object-position: center top;
            display: block;
        }
        .avatar-upload {
            position: absolute;
            bottom: -8px;
            right: -8px;
            background: #10b981;
            border: 3px solid white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
        }
        .profile-basic-info { flex: 1; min-width: 260px; }
        .profile-name { font-size: 2rem; font-weight: 700; margin: 0 0 6px 0; color: white; }
        .profile-title { font-size: 1.1rem; margin: 0 0 6px 0; color: rgba(255, 255, 255, 0.9); }
        .profile-location { margin: 0 0 10px 0; color: rgba(255, 255, 255, 0.85); }
        .profile-contact { display: flex; gap: 18px; flex-wrap: wrap; }
        .contact-item { color: rgba(255, 255, 255, 0.85); }
        .profile-status-row { margin-top: 10px; }
        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            background: rgba(16, 185, 129, 0.18);
            color: #dcfce7;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }
        .profile-main-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 28px;
            align-items: start;
        }
        .profile-left-column, .profile-right-column {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .profile-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-top: 4px solid #3b82f6;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f3f4f6;
        }
        .section-header h3 { margin: 0; font-size: 1.2rem; color: #1f2937; }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group-full { grid-column: 1 / -1; }
        .form-label { font-size: 0.9rem; font-weight: 600; color: #1f2937; }
        .form-input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #fff;
            color: #111827;
            font-size: 0.95rem;
        }
        .form-hint { color: #6b7280; font-size: 0.8rem; }
        .password-requirements {
            margin-top: 16px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }
        .password-requirements h4 { margin: 0 0 8px 0; color: #1f2937; font-size: 1rem; }
        .password-requirements ul { margin: 0; padding-left: 18px; color: #6b7280; line-height: 1.7; }
        .section-actions {
            margin-top: 18px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }
        .stat-card {
            text-align: center;
            padding: 18px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .stat-number { font-size: 1.8rem; font-weight: 700; color: #3b82f6; margin: 0 0 4px 0; }
        .stat-label { font-size: 0.8rem; color: #6b7280; margin: 0; text-transform: uppercase; font-weight: 500; }
        .btn-large { padding: 12px 18px; font-size: 0.92rem; font-weight: 600; }
        .btn-outline { background: transparent; color: #374151; border: 1px solid #d1d5db; }
        .danger-zone {
            border-top-color: #dc2626;
            background: #fff7f7;
        }
        .danger-note {
            margin: 0 0 12px 0;
            color: #7f1d1d;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        .btn-danger {
            background: #dc2626;
            color: #fff;
            border: 1px solid #dc2626;
        }
        .btn-danger:hover {
            background: #b91c1c;
            border-color: #b91c1c;
        }
        .alert {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-weight: 500;
        }
        .alert-success { background: #ecfdf3; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        @media (max-width: 1200px) {
            .profile-main-layout { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .profile-content { padding: 20px; }
            .form-grid, .stats-grid { grid-template-columns: 1fr; }
            .profile-header-card { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">Applicant Portal</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/dashboard" class="nav-link"><span class="nav-text">Dashboard</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/jobs" class="nav-link"><span class="nav-text">Browse Jobs</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/applications" class="nav-link"><span class="nav-text">My Applications</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/savedJobs" class="nav-link"><span class="nav-text">Saved Jobs</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/interviews" class="nav-link"><span class="nav-text">Interview Schedule</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/interviews/feedback" class="nav-link"><span class="nav-text">Interview Feedback</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/profile" class="nav-link active"><span class="nav-text">My Profile</span></a></li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= ROOT ?>/signout" class="logout-btn"><span>Logout</span></a>
        </div>
    </div>

    <div class="main-content">
        <header class="header">
            <div class="header-left">
                <h1 class="page-title">My Profile</h1>
                <p class="page-subtitle">Manage your personal and account information</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name"><?= esc($user['name'] ?? 'Applicant') ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'A', 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="profile-content">
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <form id="applicantProfileForm" method="POST" action="<?= ROOT ?>/applicant/profile/update" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="submit_section" id="submit_section" value="">
                <input type="hidden" name="photo_upload_intent" id="photo_upload_intent" value="0">
                <div class="profile-header-card">
                    <div class="profile-photo-section">
                        <div class="profile-avatar">
                            <img src="<?= esc($user['profile_picture_url'] ?? ROOT . '/assets/images/profiles/default-avatar.jpg') ?>" alt="Profile picture">
                            <button type="button" class="avatar-upload" onclick="document.getElementById('profile_picture').click()">📷</button>
                        </div>
                        <input hidden type="file" id="profile_picture" name="profile_picture" accept="image/*">
                    </div>

                    <div class="profile-basic-info">
                        <h2 class="profile-name"><?= esc($user['name'] ?? 'Applicant') ?></h2>
                        <p class="profile-title"><?= esc($user['role_label'] ?? 'Applicant') ?></p>
                        <p class="profile-location">📍 <?= esc($user['location'] ?? 'Not provided') ?></p>
                        <div class="profile-contact">
                            <span class="contact-item">📧 <?= esc($user['email'] ?? '') ?></span>
                            <span class="contact-item">📱 <?= esc($user['phone'] ?? '') ?></span>
                        </div>
                        <div class="profile-status-row">
                            <span class="status-pill"><?= ucfirst($user['status'] ?? 'active') ?></span>
                        </div>
                    </div>
                </div>

                <div class="profile-main-layout">
                    <div class="profile-left-column">
                        <div class="profile-section">
                            <div class="section-header">
                                <h3>Personal Information</h3>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" id="full_name" name="full_name" class="form-input" value="<?= esc($form_values['full_name'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-input" value="<?= esc($form_values['email'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" class="form-input" value="<?= esc($form_values['phone'] ?? '') ?>">
                                </div>
                                <div class="form-group form-group-full">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" id="address" name="address" class="form-input" value="<?= esc($form_values['address'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="section-actions">
                                <button type="submit" name="submit_section" value="personal" class="btn btn-primary btn-large">Update Personal Information</button>
                                <button type="button" class="btn btn-outline btn-large" onclick="resetProfileForm()">Reset</button>
                            </div>
                        </div>

                        <div class="profile-section">
                            <div class="section-header">
                                <h3>Security Settings</h3>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" id="current_password" name="current_password" class="form-input" autocomplete="off">
                                    <small class="form-hint">Keep this empty unless changing password.</small>
                                </div>
                                <div class="form-group">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" id="new_password" name="new_password" class="form-input" autocomplete="new-password">
                                    <small class="form-hint">Leave blank to keep current password.</small>
                                </div>
                                <div class="form-group form-group-full">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-input" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="password-requirements">
                                <h4>Password Requirements</h4>
                                <ul>
                                    <li>At least 8 characters long</li>
                                    <li>Contains uppercase and lowercase letters</li>
                                    <li>Contains at least one number</li>
                                    <li>Contains at least one special character</li>
                                </ul>
                            </div>
                            <div class="section-actions">
                                <button type="submit" name="submit_section" value="security" class="btn btn-primary btn-large">Update Security Settings</button>
                            </div>
                        </div>
                    </div>

                    <div class="profile-right-column">
                        <div class="profile-section">
                            <div class="section-header">
                                <h3>Application Snapshot</h3>
                            </div>
                            <div class="stats-grid">
                                <div class="stat-card">
                                    <div class="stat-number"><?= (int)($application_stats['total_applications'] ?? 0) ?></div>
                                    <p class="stat-label">Applications</p>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-number"><?= (int)($application_stats['under_review_applications'] ?? 0) ?></div>
                                    <p class="stat-label">Under Review</p>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-number"><?= (int)($application_stats['shortlisted_applications'] ?? 0) ?></div>
                                    <p class="stat-label">Shortlisted</p>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-number"><?= (int)($interview_stats['upcoming_interviews'] ?? 0) ?></div>
                                    <p class="stat-label">Upcoming Interviews</p>
                                </div>
                            </div>
                        </div>

                        <div class="profile-section danger-zone">
                            <div class="section-header">
                                <h3>Danger Zone</h3>
                            </div>
                            <p class="danger-note">
                                Deleting your profile will deactivate your account immediately.
                                Your personal details are anonymized for privacy while related records are retained for auditing.
                            </p>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="delete_current_password" class="form-label">Current Password</label>
                                    <input type="password" id="delete_current_password" name="delete_current_password" class="form-input" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="delete_confirmation" class="form-label">Type DELETE to confirm</label>
                                    <input type="text" id="delete_confirmation" name="delete_confirmation" class="form-input" placeholder="DELETE">
                                </div>
                            </div>
                            <div class="section-actions">
                                <button
                                    type="submit"
                                    id="deleteProfileButton"
                                    class="btn btn-danger btn-large"
                                    formaction="<?= ROOT ?>/applicant/deleteProfile"
                                    formmethod="POST"
                                >Delete My Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function resetProfileForm() {
            window.location.reload();
        }

        const profilePictureInput = document.getElementById('profile_picture');
        const profileForm = document.getElementById('applicantProfileForm');
        const submitSection = document.getElementById('submit_section');
        const photoUploadIntent = document.getElementById('photo_upload_intent');
        if (profilePictureInput) {
            profilePictureInput.addEventListener('change', function() {
                if (this.files.length === 0) {
                    return;
                }

                if (!this.files[0].type.startsWith('image/')) {
                    alert('Please choose a valid image file.');
                    this.value = '';
                    return;
                }

                if (currentPassword) currentPassword.value = '';
                if (newPassword) newPassword.value = '';
                if (confirmPassword) confirmPassword.value = '';

                if (submitSection) {
                    submitSection.value = 'photo';
                }

                if (photoUploadIntent) {
                    photoUploadIntent.value = '1';
                }

                if (profileForm) {
                    profileForm.submit();
                }
            });
        }

        const currentPassword = document.getElementById('current_password');
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');
        const deleteProfileButton = document.getElementById('deleteProfileButton');
        const deleteConfirmation = document.getElementById('delete_confirmation');
        const deleteCurrentPassword = document.getElementById('delete_current_password');
        if (currentPassword) currentPassword.value = '';
        if (newPassword) newPassword.value = '';
        if (confirmPassword) confirmPassword.value = '';

        if (deleteProfileButton) {
            deleteProfileButton.addEventListener('click', function(event) {
                const hasPassword = deleteCurrentPassword && deleteCurrentPassword.value.trim() !== '';
                const hasDeleteWord = deleteConfirmation && deleteConfirmation.value.trim().toUpperCase() === 'DELETE';

                if (!hasPassword || !hasDeleteWord) {
                    event.preventDefault();
                    alert('Enter your current password and type DELETE to continue.');
                    return;
                }

                const confirmed = confirm('Are you sure? This will permanently delete your profile and all related application/interview data.');
                if (!confirmed) {
                    event.preventDefault();
                }
            });
        }
    </script>
</body>
</html>
