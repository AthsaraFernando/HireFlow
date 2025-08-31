<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' - HireFlow' : 'HireFlow - Recruitment Management System' ?></title>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/table.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/modal.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/alert.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/toast.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/systemadmin/dashboard.style.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/systemadmin/system-admin.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/hradmin/hradmin.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/recruitment/recruitment.css">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <style>
        /* Icon styles for better compatibility */
        .icon-plus::before { content: '➕'; }
        .icon-download::before { content: '⬇️'; }
        .icon-edit::before { content: '✏️'; }
        .icon-eye::before { content: '👁️'; }
        .icon-trash::before { content: '🗑️'; }
        .icon-pause::before { content: '⏸️'; }
        .icon-play::before { content: '▶️'; }
        .icon-refresh::before { content: '🔄'; }
        .icon-warning::before { content: '⚠️'; }
        .icon-chart::before { content: '📊'; }
        .icon-search::before { content: '🔍'; }
        .icon-calendar::before { content: '📅'; }
        .icon-back::before { content: '← '; }
        .icon-delete::before { content: '🗑️'; }
        .icon-database::before { content: '🗄️'; }
        .icon-user::before { content: '👤'; }
        .icon-users::before { content: '👥'; }
        .icon-mail::before { content: '📧'; }
        .icon-phone::before { content: '📞'; }
        .icon-location::before { content: '📍'; }
        .icon-clock::before { content: '🕐'; }
        .icon-check::before { content: '✅'; }
        .icon-close::before { content: '❌'; }
        .icon-filter::before { content: '🔍'; }
        .icon-copy::before { content: '📋'; }
        .icon-archive::before { content: '📦'; }
        .icon-star::before { content: '⭐'; }
        .icon-reject::before { content: '❌'; }
        .icon-email::before { content: '📧'; }
        
        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 0;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .modal-header h3 {
            margin: 0;
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }
    </style>
</head>
<body>

<header class="main-header">
    <div class="header-container">
        <div class="header-left">
            <a href="<?= ROOT ?>" class="brand-link">
                <img src="<?= ROOT ?>/assets/images/logo.png" alt="HireFlow Logo" class="brand-logo">
                <span class="brand-text">Hire<span class="brand-accent">Flow</span></span>
            </a>
        </div>
        
        <nav class="header-nav">
            <?php if (isset($user_role)): ?>
                <?php if ($user_role === 'System Admin'): ?>
                    <a href="<?= ROOT ?>/systemadmin/dashboard" class="nav-link">Dashboard</a>
                    <a href="<?= ROOT ?>/systemadmin/usermanage" class="nav-link">Users</a>
                    <a href="<?= ROOT ?>/systemadmin/viewdata" class="nav-link">Data</a>
                    <a href="<?= ROOT ?>/systemadmin/accesslogs" class="nav-link">Logs</a>
                <?php elseif ($user_role === 'HR Admin'): ?>
                    <a href="<?= ROOT ?>/hradmin/dashboard" class="nav-link">Dashboard</a>
                    <a href="<?= ROOT ?>/hradmin/job-posts" class="nav-link">Jobs</a>
                    <a href="<?= ROOT ?>/hradmin/applications" class="nav-link">Applications</a>
                    <a href="<?= ROOT ?>/hradmin/reports" class="nav-link">Reports</a>
                <?php elseif ($user_role === 'Recruitment Manager'): ?>
                    <a href="<?= ROOT ?>/recruitment/dashboard" class="nav-link">Dashboard</a>
                    <a href="<?= ROOT ?>/recruitment/applications" class="nav-link">Applications</a>
                    <a href="<?= ROOT ?>/recruitment/interview-schedule" class="nav-link">Interviews</a>
                    <a href="<?= ROOT ?>/recruitment/reports" class="nav-link">Reports</a>
                <?php elseif ($user_role === 'Applicant'): ?>
                    <a href="<?= ROOT ?>/applicant/dashboard" class="nav-link">Dashboard</a>
                    <a href="<?= ROOT ?>/applicant/browse-jobs" class="nav-link">Browse Jobs</a>
                    <a href="<?= ROOT ?>/applicant/my-applications" class="nav-link">My Applications</a>
                    <a href="<?= ROOT ?>/applicant/profile-edit" class="nav-link">Profile</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?= ROOT ?>/signin" class="nav-link">Sign In</a>
                <a href="<?= ROOT ?>/signup" class="nav-link">Join as Applicant</a>
            <?php endif; ?>
        </nav>
        
        <div class="header-right">
            <?php if (isset($user_name)): ?>
                <div class="user-menu">
                    <button class="user-menu-toggle">
                        <div class="user-avatar">
                            <?= strtoupper(substr($user_name, 0, 1)) ?>
                        </div>
                        <span class="user-name"><?= htmlspecialchars($user_name) ?></span>
                        <i class="dropdown-arrow">▼</i>
                    </button>
                    <div class="user-dropdown">
                        <a href="<?= ROOT ?>/profile" class="dropdown-item">
                            <i class="icon">👤</i> Profile
                        </a>
                        <a href="<?= ROOT ?>/change-password" class="dropdown-item">
                            <i class="icon">🔒</i> Change Password
                        </a>
                        <a href="<?= ROOT ?>/notifications" class="dropdown-item">
                            <i class="icon">🔔</i> Notifications
                            <?php if (isset($unread_notifications) && $unread_notifications > 0): ?>
                                <span class="notification-badge"><?= $unread_notifications ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= ROOT ?>/signout" class="dropdown-item">
                            <i class="icon">🚪</i> Sign Out
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?= ROOT ?>/signin" class="btn btn-primary">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<style>
.main-header {
    background: white;
    border-bottom: 1px solid #e1e8ed;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.header-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    height: 70px;
}

.header-left {
    display: flex;
    align-items: center;
}

.brand-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #2c3e50;
}

.brand-logo {
    width: 40px;
    height: 40px;
    margin-right: 10px;
}

.brand-text {
    font-size: 1.5em;
    font-weight: 700;
}

.brand-accent {
    color: #667eea;
}

.header-nav {
    display: flex;
    gap: 20px;
}

.nav-link {
    text-decoration: none;
    color: #555;
    font-weight: 500;
    padding: 8px 12px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.nav-link:hover {
    background: #f8f9fa;
    color: #667eea;
}

.header-right {
    display: flex;
    align-items: center;
}

.user-menu {
    position: relative;
}

.user-menu-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: none;
    padding: 8px 12px;
    border-radius: 25px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.user-menu-toggle:hover {
    background: #f8f9fa;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #667eea;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.9em;
}

.user-name {
    font-weight: 500;
    color: #2c3e50;
}

.dropdown-arrow {
    font-size: 0.7em;
    color: #666;
    transition: transform 0.3s ease;
}

.user-menu.open .dropdown-arrow {
    transform: rotate(180deg);
}

.user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #e1e8ed;
    border-radius: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    min-width: 200px;
    z-index: 1001;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.user-menu.open .user-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    text-decoration: none;
    color: #333;
    transition: background 0.3s ease;
}

.dropdown-item:hover {
    background: #f8f9fa;
}

.dropdown-divider {
    height: 1px;
    background: #e1e8ed;
    margin: 8px 0;
}

.notification-badge {
    background: #dc3545;
    color: white;
    font-size: 0.7em;
    padding: 2px 6px;
    border-radius: 10px;
    margin-left: auto;
}

@media (max-width: 768px) {
    .header-nav {
        display: none;
    }
    
    .user-name {
        display: none;
    }
    
    .header-container {
        padding: 0 15px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userMenu = document.querySelector('.user-menu');
    const userMenuToggle = document.querySelector('.user-menu-toggle');
    
    if (userMenuToggle) {
        userMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenu.classList.toggle('open');
        });
        
        document.addEventListener('click', function() {
            userMenu.classList.remove('open');
        });
        
        userMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>
