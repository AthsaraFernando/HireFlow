<?php
// Sample user data - in real implementation this would come from session/database
$user = [
    'id' => 1,
    'full_name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'phone' => '+94771234567',
    'address' => '123 Main Street, Colombo',
    'role' => 'System Admin',
    'created_at' => '2024-01-15'
];

if (!function_exists('old_value')) {
    function old_value($key, $default = '')
    {
        return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : $default;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - HireFlow System Admin</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/dashboard.style.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/alert.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
    
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
        
        .profile-photo-section {
            flex-shrink: 0;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5em;
            font-weight: bold;
            position: relative;
            border: 4px solid rgba(255,255,255,0.3);
        }
        
        .avatar-upload {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #fff;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .profile-basic-info {
            flex: 1;
        }
        
        .profile-name {
            font-size: 2rem;
            margin: 0 0 8px 0;
            font-weight: 700;
        }
        
        .profile-title {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0 0 15px 0;
        }
        
        .profile-contact {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }
        
        .profile-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .profile-main-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .profile-left-column,
        .profile-right-column {
            display: flex;
            flex-direction: column;
        }
        
        .profile-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        
        .section-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f3f5;
        }
        
        .section-header h3 {
            margin: 0;
            color: #2d3748;
            font-size: 1.3rem;
            font-weight: 600;
        }
        
        .edit-btn {
            background: none;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            color: #4e31aa;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        
        .edit-btn:hover {
            background: #4e31aa;
            color: white;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2d3748;
        }
        
        .form-input, .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
        }
        
        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: #4e31aa;
        }
        
        .readonly-field {
            background: #f7fafc;
            cursor: not-allowed;
        }
        
        .text-muted {
            font-size: 0.85rem;
            color: #718096;
            margin-top: 5px;
        }
        
        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background: #4e31aa;
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background: #3b2693;
        }
        
        .btn-outline {
            background: transparent;
            color: #4e31aa;
            border: 2px solid #4e31aa;
        }
        
        .btn-outline:hover {
            background: #4e31aa;
            color: white;
        }
        
        @media (max-width: 768px) {
            .profile-header-card {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
            
            .profile-main-layout {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
        
        .readonly-field {
            background: #f8f9fa;
            color: #6c757d;
        }
    </style>
</head>

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
                    <a href="<?= ROOT ?>/profile" class="nav-link active">
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
                            <?= $_SESSION['USER']['full_name'] ?? $user['full_name'] ?></span>
                        <span class="user-role">System Administrator</span>
                    </div>
                    <div class="user-avatar">
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="profile-content" style="padding: 30px; margin: 0; max-width: none;">
                <!-- Profile Header Card -->
                <div class="profile-header-card">
                    <div class="profile-photo-section">
                        <div class="profile-avatar">
                            <?= strtoupper(substr($user['full_name'], 0, 2)) ?>
                            <button class="avatar-upload" onclick="uploadPhoto()">📷</button>
                        </div>
                    </div>
                    <div class="profile-basic-info">
                        <h2 class="profile-name"><?= htmlspecialchars($user['full_name']) ?></h2>
                        <p class="profile-title"><?= htmlspecialchars($user['role']) ?></p>
                        <div class="profile-contact">
                            <span class="contact-item">📧 <?= htmlspecialchars($user['email']) ?></span>
                            <span class="contact-item">📱 <?= htmlspecialchars($user['phone']) ?></span>
                            <span class="contact-item">📅 Member since <?= date('F Y', strtotime($user['created_at'])) ?></span>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button class="btn btn-primary" onclick="editProfile()">✏️ Edit Profile</button>
                        <button class="btn btn-outline" onclick="changePassword()">🔒 Change Password</button>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="profile-main-layout">
                    <!-- Left Column -->
                    <div class="profile-left-column">
                        <!-- Personal Information Section -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3>Personal Information</h3>
                                <button class="edit-btn" onclick="editSection('personal')">✏️ Edit</button>
                            </div>
                            <div class="section-content">
                                <?php if (!empty($errors)): ?>
                                    <div class="alert alert-error mb-3">
                                        <?= implode('<br>', $errors) ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($success)): ?>
                                    <div class="alert alert-success mb-3">
                                        <?= $success ?>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="full_name" class="form-label">Full Name</label>
                                            <input 
                                                type="text" 
                                                id="full_name" 
                                                name="full_name" 
                                                class="form-input" 
                                                value="<?= old_value('full_name', $user['full_name']) ?>"
                                                required>
                                        </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input readonly-field" 
                            value="<?= htmlspecialchars($user['email']) ?>"
                            readonly>
                        <small class="text-muted">Email cannot be changed</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            class="form-input" 
                            value="<?= old_value('phone', $user['phone']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <input 
                            type="text" 
                            id="role" 
                            name="role" 
                            class="form-input readonly-field" 
                            value="<?= htmlspecialchars($user['role']) ?>"
                            readonly>
                        <small class="text-muted">Role is managed by system admin</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <textarea 
                        id="address" 
                        name="address" 
                        class="form-input" 
                        rows="3"
                        placeholder="Enter your address"><?= old_value('address', $user['address']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input 
                        type="file" 
                        id="profile_picture" 
                        name="profile_picture" 
                        class="form-input"
                        accept="image/*">
                    <small class="text-muted">Accepted formats: JPG, PNG, GIF (Max 2MB)</small>
                </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="profile-right-column">
                        <!-- Security Settings Section -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3>Security Settings</h3>
                                <button class="edit-btn" onclick="editSection('security')">🔒 Manage</button>
                            </div>
                            <div class="section-content">
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <p style="margin: 0; color: #718096;">Last changed: 30 days ago</p>
                                    <a href="<?= ROOT ?>/change-password" class="btn btn-outline" style="margin-top: 10px; display: inline-block;">Change Password</a>
                                </div>
                                
                                <div class="form-group" style="margin-top: 20px;">
                                    <label class="form-label">Two-Factor Authentication</label>
                                    <p style="margin: 0; color: #718096;">Add an extra layer of security</p>
                                    <button class="btn btn-outline" style="margin-top: 10px;" onclick="setup2FA()">Setup 2FA</button>
                                </div>
                            </div>
                        </div>

                        <!-- System Information Section -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3>System Information</h3>
                            </div>
                            <div class="section-content">
                                <div style="margin-bottom: 15px;">
                                    <strong>User ID:</strong> #<?= $user['id'] ?>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <strong>Account Created:</strong> <?= date('F j, Y', strtotime($user['created_at'])) ?>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <strong>Last Login:</strong> <?= date('F j, Y g:i A') ?>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <strong>Access Level:</strong> <span style="color: #4e31aa; font-weight: 600;">Full Administrator</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="<?= ROOT ?>/assets/js/main.js"></script>
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

        // Profile page specific functions
        function editProfile() {
            alert('Edit profile functionality - to be implemented');
        }

        function changePassword() {
            window.location.href = '<?= ROOT ?>/change-password';
        }

        function uploadPhoto() {
            document.getElementById('profile_picture')?.click();
        }

        function editSection(section) {
            alert(`Edit ${section} section - to be implemented`);
        }

        function setup2FA() {
            alert('Two-factor authentication setup - to be implemented');
        }
    </script>
</body>
</html>
