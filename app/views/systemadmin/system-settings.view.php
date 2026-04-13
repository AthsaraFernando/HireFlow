<?php
// Sample system settings data - in real implementation this would come from database
$settings = [
    'site_name' => 'HireFlow',
    'max_file_size' => '5242880', // 5MB in bytes
    'allowed_file_types' => 'pdf,doc,docx',
    'session_timeout' => '3600', // 1 hour
    'email_notifications' => 'true',
    'auto_backup' => 'false',
    'maintenance_mode' => 'false',
    'max_login_attempts' => '5',
    'password_min_length' => '8',
    'password_require_special' => 'true'
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
    <title>System Settings - HireFlow Admin</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/alert.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/dashboard.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">

    <style>
        .settings-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .settings-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.3em;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 24px;
            background: #ccc;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .toggle-switch.active {
            background: #3498db;
        }

        .toggle-slider {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        .toggle-switch.active .toggle-slider {
            transform: translateX(26px);
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .setting-item:last-child {
            border-bottom: none;
        }

        .setting-label {
            font-weight: 500;
            color: #2c3e50;
        }

        .setting-description {
            font-size: 0.9em;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .current-value {
            background: #ecf0f1;
            padding: 8px 12px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 0.9em;
        }

        .danger-zone {
            border: 2px solid #e74c3c;
            background: #fdf2f2;
        }

        .danger-zone .section-title {
            color: #e74c3c;
            border-bottom-color: #e74c3c;
        }
    </style>
</head>

<body>
    <?php
    // Set user data for header
    $user_role = 'System Admin';
    $user_name = 'Admin User';
    // include '../views/components/header.view.php'; 
    $this->view('components/header')

        ?>

    <div class="settings-container">
        <div class="page-header">
            <h1>System Settings</h1>
            <p style="padding:20px;">Configure global system parameters and preferences</p>
        </div>

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

        <!-- General Settings -->
        <div class="settings-section">
            <h2 class="section-title">General Settings</h2>
            <form method="POST" action="<?= ROOT ?>/systemadmin/system-settings">
                <div class="settings-grid">
                    <div class="form-group">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" id="site_name" name="site_name" class="form-input"
                            value="<?= old_value('site_name', $settings['site_name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="session_timeout" class="form-label">Session Timeout (seconds)</label>
                        <input type="number" id="session_timeout" name="session_timeout" class="form-input"
                            value="<?= old_value('session_timeout', $settings['session_timeout']) ?>" min="300"
                            max="86400">
                    </div>
                </div>

                <div class="setting-item">
                    <div>
                        <div class="setting-label">Email Notifications</div>
                        <div class="setting-description">Send system notifications via email</div>
                    </div>
                    <div class="toggle-switch <?= $settings['email_notifications'] === 'true' ? 'active' : '' ?>"
                        onclick="toggleSetting(this, 'email_notifications')">
                        <div class="toggle-slider"></div>
                    </div>
                </div>

                <div class="setting-item">
                    <div>
                        <div class="setting-label">Maintenance Mode</div>
                        <div class="setting-description">Temporarily disable public access</div>
                    </div>
                    <div class="toggle-switch <?= $settings['maintenance_mode'] === 'true' ? 'active' : '' ?>"
                        onclick="toggleSetting(this, 'maintenance_mode')">
                        <div class="toggle-slider"></div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Save General Settings</button>
            </form>
        </div>

        <!-- File Upload Settings -->
        <!-- <div class="settings-section">
            <h2 class="section-title">File Upload Settings</h2>
            <form method="POST" action="<?= ROOT ?>/systemadmin/system-settings">
                <div class="settings-grid">
                    <div class="form-group">
                        <label for="max_file_size" class="form-label">Max File Size (bytes)</label>
                        <input type="number" id="max_file_size" name="max_file_size" class="form-input"
                            value="<?= old_value('max_file_size', $settings['max_file_size']) ?>" min="1048576">
                        <small class="text-muted">Current:
                            <?= number_format($settings['max_file_size'] / 1048576, 1) ?>MB</small>
                    </div>

                    <div class="form-group">
                        <label for="allowed_file_types" class="form-label">Allowed File Types</label>
                        <input type="text" id="allowed_file_types" name="allowed_file_types" class="form-input"
                            value="<?= old_value('allowed_file_types', $settings['allowed_file_types']) ?>"
                            placeholder="pdf,doc,docx,jpg,png">
                        <small class="text-muted">Comma-separated list of extensions</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Upload Settings</button>
            </form>
        </div> -->

        <!-- Security Settings -->
        <!-- <div class="settings-section">
            <h2 class="section-title">Security Settings</h2>
            <form method="POST" action="<?= ROOT ?>/systemadmin/system-settings">
                <div class="settings-grid">
                    <div class="form-group">
                        <label for="max_login_attempts" class="form-label">Max Login Attempts</label>
                        <input type="number" id="max_login_attempts" name="max_login_attempts" class="form-input"
                            value="<?= old_value('max_login_attempts', $settings['max_login_attempts']) ?>" min="3"
                            max="10">
                    </div>

                    <div class="form-group">
                        <label for="password_min_length" class="form-label">Minimum Password Length</label>
                        <input type="number" id="password_min_length" name="password_min_length" class="form-input"
                            value="<?= old_value('password_min_length', $settings['password_min_length']) ?>" min="6"
                            max="20">
                    </div>
                </div>

                <div class="setting-item">
                    <div>
                        <div class="setting-label">Require Special Characters in Password</div>
                        <div class="setting-description">Force users to include special characters</div>
                    </div>
                    <div class="toggle-switch <?= $settings['password_require_special'] === 'true' ? 'active' : '' ?>"
                        onclick="toggleSetting(this, 'password_require_special')">
                        <div class="toggle-slider"></div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Security Settings</button>
            </form>
        </div> -->

        <!-- Backup Settings -->
        <div class="settings-section">
            <h2 class="section-title">Backup Settings</h2>
            <div class="setting-item">
                <div>
                    <div class="setting-label">Automatic Backup</div>
                    <div class="setting-description">Enable daily automatic database backups</div>
                </div>
                <div class="toggle-switch <?= $settings['auto_backup'] === 'true' ? 'active' : '' ?>"
                    onclick="toggleSetting(this, 'auto_backup')">
                    <div class="toggle-slider"></div>
                </div>
            </div>

            <div class="mt-3">
                <a href="<?= ROOT ?>/systemadmin/backup-restore" class="btn btn-outline-primary">
                    Manage Backups
                </a>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="settings-section danger-zone">
            <h2 class="section-title">⚠️ Danger Zone</h2>
            <div class="setting-item">
                <div>
                    <div class="setting-label">Reset All Settings</div>
                    <div class="setting-description">Restore all settings to default values</div>
                </div>
                <button type="button" class="btn btn-danger" onclick="confirmReset()">
                    Reset to Defaults
                </button>
            </div>

            <div class="setting-item">
                <div>
                    <div class="setting-label">Clear All Logs</div>
                    <div class="setting-description">Delete all access logs and audit trails</div>
                </div>
                <button type="button" class="btn btn-danger" onclick="confirmClearLogs()">
                    Clear Logs
                </button>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="<?= ROOT ?>/systemadmin/dashboard" class="btn btn-outline-secondary">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    <?php // include '../views/components/footer.view.php'; 
    $this->view('components/footer')

        ?>

    <script src="<?= ROOT ?>/assets/js/main.js"></script>
    <script>
        function toggleSetting(element, settingName) {
            element.classList.toggle('active');
            const isActive = element.classList.contains('active');

            // Create hidden input to store the value
            let input = document.querySelector(`input[name="${settingName}"]`);
            if (!input) {
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = settingName;
                element.closest('form').appendChild(input);
            }
            input.value = isActive ? 'true' : 'false';

            // Show confirmation
            showToast(`${settingName.replace('_', ' ')} ${isActive ? 'enabled' : 'disabled'}`, 'info');
        }

        function confirmReset() {
            if (confirm('Are you sure you want to reset all settings to default values? This action cannot be undone.')) {
                // In real implementation, this would make an AJAX call
                showToast('Settings reset to defaults', 'success');
            }
        }

        function confirmClearLogs() {
            if (confirm('Are you sure you want to clear all logs? This action cannot be undone.')) {
                // In real implementation, this would make an AJAX call
                showToast('All logs cleared successfully', 'success');
            }
        }

        function showToast(message, type) {
            // Simple toast notification
            const toast = document.createElement('div');
            toast.className = `alert alert-${type}`;
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
                min-width: 300px;
                animation: slideIn 0.3s ease;
            `;
            toast.textContent = message;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
</body>

</html>