<?php
// Sample security data - in real implementation this would come from database/config
$security_settings = [
    'two_factor_auth' => false,
    'password_expiry_days' => 90,
    'session_security' => true,
    'ip_whitelist_enabled' => false,
    'brute_force_protection' => true,
    'audit_logging' => true,
    'ssl_required' => false,
    'email_verification' => true
];

$failed_logins = [
    ['ip' => '192.168.1.100', 'attempts' => 3, 'last_attempt' => '2025-08-31 14:30:15', 'status' => 'Blocked'],
    ['ip' => '10.0.0.25', 'attempts' => 2, 'last_attempt' => '2025-08-31 13:45:22', 'status' => 'Monitoring'],
    ['ip' => '172.16.0.5', 'attempts' => 1, 'last_attempt' => '2025-08-31 12:15:08', 'status' => 'Normal']
];

$active_sessions = [
    ['user' => 'Admin User', 'ip' => '192.168.1.50', 'login_time' => '2025-08-31 09:00:00', 'last_activity' => '2025-08-31 15:45:00', 'device' => 'Windows Desktop'],
    ['user' => 'HR Manager', 'ip' => '192.168.1.51', 'login_time' => '2025-08-31 08:30:00', 'last_activity' => '2025-08-31 15:30:00', 'device' => 'MacOS Laptop'],
    ['user' => 'John Doe', 'ip' => '192.168.1.52', 'login_time' => '2025-08-31 10:15:00', 'last_activity' => '2025-08-31 15:20:00', 'device' => 'Android Mobile']
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Settings - HireFlow Admin</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/table.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/alert.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/dashboard.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">

    <style>
        .security-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .security-section {
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .security-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .security-card {
            border: 2px solid #ecf0f1;
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .security-card.enabled {
            border-color: #27ae60;
            background: #f8fff8;
        }

        .security-card.disabled {
            border-color: #e74c3c;
            background: #fff8f8;
        }

        .security-card.warning {
            border-color: #f39c12;
            background: #fffbf0;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .card-title {
            font-weight: 600;
            color: #2c3e50;
        }

        .security-status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: 500;
        }

        .status-enabled {
            background: #d4edda;
            color: #155724;
        }

        .status-disabled {
            background: #f8d7da;
            color: #721c24;
        }

        .status-warning {
            background: #fff3cd;
            color: #856404;
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
            background: #27ae60;
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

        .security-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .security-table th,
        .security-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        .security-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        .ip-input-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .threat-level {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .threat-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .threat-low {
            background: #27ae60;
        }

        .threat-medium {
            background: #f39c12;
        }

        .threat-high {
            background: #e74c3c;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
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

    <div class="security-container">
        <div class="page-header">
            <h1>Security Settings</h1>
            <p style="padding:20px;">Configure system security policies and monitor security events</p>
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

        <!-- Security Overview -->
        <div class="security-section">
            <h2 class="section-title">Security Overview</h2>
            <div class="security-grid">
                <!-- <div class="security-card <?= $security_settings['brute_force_protection'] ? 'enabled' : 'disabled' ?>">
                    <div class="card-header">
                        <span class="card-title">Brute Force Protection</span>
                        <span
                            class="security-status <?= $security_settings['brute_force_protection'] ? 'status-enabled' : 'status-disabled' ?>">
                            <?= $security_settings['brute_force_protection'] ? 'Enabled' : 'Disabled' ?>
                        </span>
                    </div>
                    <p>Protects against automated login attacks</p>
                    <div class="toggle-switch <?= $security_settings['brute_force_protection'] ? 'active' : '' ?>"
                        onclick="toggleSecurity(this, 'brute_force_protection')">
                        <div class="toggle-slider"></div>
                    </div>
                </div> -->

                <!-- <div class="security-card <?= $security_settings['two_factor_auth'] ? 'enabled' : 'warning' ?>">
                    <div class="card-header">
                        <span class="card-title">Two-Factor Authentication</span>
                        <span
                            class="security-status <?= $security_settings['two_factor_auth'] ? 'status-enabled' : 'status-warning' ?>">
                            <?= $security_settings['two_factor_auth'] ? 'Enabled' : 'Recommended' ?>
                        </span>
                    </div>
                    <p>Adds extra layer of login security</p>
                    <div class="toggle-switch <?= $security_settings['two_factor_auth'] ? 'active' : '' ?>"
                        onclick="toggleSecurity(this, 'two_factor_auth')">
                        <div class="toggle-slider"></div>
                    </div>
                </div> -->

                <!-- <div class="security-card <?= $security_settings['ssl_required'] ? 'enabled' : 'warning' ?>">
                    <div class="card-header">
                        <span class="card-title">SSL/HTTPS Required</span>
                        <span
                            class="security-status <?= $security_settings['ssl_required'] ? 'status-enabled' : 'status-warning' ?>">
                            <?= $security_settings['ssl_required'] ? 'Enforced' : 'Optional' ?>
                        </span>
                    </div>
                    <p>Forces secure connections only</p>
                    <div class="toggle-switch <?= $security_settings['ssl_required'] ? 'active' : '' ?>"
                        onclick="toggleSecurity(this, 'ssl_required')">
                        <div class="toggle-slider"></div>
                    </div>
                </div> -->

                <!-- <div class="security-card enabled">
                    <div class="card-header">
                        <span class="card-title">System Status</span>
                        <span class="security-status status-enabled">Secure</span>
                    </div>
                    <div class="threat-level">
                        <div class="threat-indicator threat-low"></div>
                        <span>Threat Level: Low</span>
                    </div>
                    <small>Last security scan: 2 hours ago</small>
                </div> -->
            </div>
        </div>

        <!-- Authentication Settings -->
        <div class="security-section">
            <h2 class="section-title">Authentication Settings</h2>
            <form method="POST" action="<?= ROOT ?>/systemadmin/security-settings">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="password_expiry" class="form-label">Password Expiry (days)</label>
                        <input type="number" id="password_expiry" name="password_expiry" class="form-input"
                            value="<?= $security_settings['password_expiry_days'] ?>" min="0" max="365">
                        <small class="text-muted">0 = never expires</small>
                    </div>

                    <div class="form-group">
                        <label for="max_sessions" class="form-label">Max Concurrent Sessions</label>
                        <select id="max_sessions" name="max_sessions" class="form-input">
                            <option value="1">1 Session</option>
                            <option value="3" selected>3 Sessions</option>
                            <option value="5">5 Sessions</option>
                            <option value="unlimited">Unlimited</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">
                        <input type="checkbox" <?= $security_settings['email_verification'] ? 'checked' : '' ?>
                            name="email_verification">
                        Require email verification for new accounts
                    </label>
                </div>

                <div class="mt-3">
                    <label class="form-label">
                        <input type="checkbox" <?= $security_settings['session_security'] ? 'checked' : '' ?>
                            name="session_security">
                        Enhanced session security (IP validation)
                    </label>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Save Authentication Settings</button>
            </form>
        </div>

        <!-- IP Whitelist -->
        <!-- <div class="security-section">
            <h2 class="section-title"> IP Access Control</h2>
            <div class="mb-3">
                <label class="form-label">
                    <input type="checkbox" <?= $security_settings['ip_whitelist_enabled'] ? 'checked' : '' ?>
                        onchange="toggleIPWhitelist(this)">
                    Enable IP Whitelist (Admin access only)
                </label>
            </div>

            <div id="ipWhitelistSection"
                style="<?= $security_settings['ip_whitelist_enabled'] ? '' : 'display:none' ?>">
                <div class="ip-input-group">
                    <input type="text" id="newIP" class="form-input" placeholder="192.168.1.100"
                        pattern="^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$">
                    <input type="text" id="ipDescription" class="form-input" placeholder="Description">
                    <button type="button" class="btn btn-primary" onclick="addIP()">Add IP</button>
                </div>

                <div class="alert alert-warning mt-2">
                    <strong>Warning:</strong> Your current IP (192.168.1.50) will be automatically added to prevent
                    lockout.
                </div>

                <table class="security-table mt-3">
                    <thead>
                        <tr>
                            <th>IP Address</th>
                            <th>Description</th>
                            <th>Added Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ipWhitelistTable">
                        <tr>
                            <td>192.168.1.50</td>
                            <td>Admin Workstation (Current)</td>
                            <td>2025-08-31</td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger" disabled>Protected</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->

        <!-- Failed Login Attempts -->
        <div class="security-section">
            <h2 class="section-title">Security Monitoring</h2>
            <h3>Failed Login Attempts</h3>
            <table class="security-table">
                <thead>
                    <tr>
                        <th>IP Address</th>
                        <th>Failed Attempts</th>
                        <th>Last Attempt</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($failed_logins as $login): ?>
                        <tr>
                            <td><?= htmlspecialchars($login['ip']) ?></td>
                            <td><?= $login['attempts'] ?></td>
                            <td><?= date('M d, H:i', strtotime($login['last_attempt'])) ?></td>
                            <td>
                                <span
                                    class="security-status <?= $login['status'] === 'Blocked' ? 'status-disabled' : ($login['status'] === 'Monitoring' ? 'status-warning' : 'status-enabled') ?>">
                                    <?= $login['status'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($login['status'] === 'Blocked'): ?>
                                    <button class="btn btn-sm btn-outline-primary" onclick="unblockIP('<?= $login['ip'] ?>')">
                                        Unblock
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-outline-danger" onclick="blockIP('<?= $login['ip'] ?>')">
                                        Block
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Active Sessions -->
        <div class="security-section">
            <h2 class="section-title">Active Sessions</h2>
            <table class="security-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>IP Address</th>
                        <th>Login Time</th>
                        <th>Last Activity</th>
                        <th>Device</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($active_sessions as $session): ?>
                        <tr>
                            <td><?= htmlspecialchars($session['user']) ?></td>
                            <td><?= htmlspecialchars($session['ip']) ?></td>
                            <td><?= date('M d, H:i', strtotime($session['login_time'])) ?></td>
                            <td><?= date('H:i', strtotime($session['last_activity'])) ?></td>
                            <td><?= htmlspecialchars($session['device']) ?></td>
                            <td>
                                <?php if ($session['user'] === 'Admin User'): ?>
                                    <span class="text-muted">Current Session</span>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-outline-danger"
                                        onclick="terminateSession('<?= $session['user'] ?>')">
                                        Terminate
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="<?= ROOT ?>/systemadmin/dashboard" class="btn btn-outline-secondary">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    <?php  // include '../views/components/footer.view.php'; 
    $this->view('components/footer')

        ?>

    <script src="<?= ROOT ?>/assets/js/main.js"></script>
    <script>
        function toggleSecurity(element, setting) {
            element.classList.toggle('active');
            const isActive = element.classList.contains('active');

            // Update the parent card styling
            const card = element.closest('.security-card');
            card.className = 'security-card ' + (isActive ? 'enabled' : 'disabled');

            // Update status badge
            const statusBadge = card.querySelector('.security-status');
            statusBadge.className = 'security-status ' + (isActive ? 'status-enabled' : 'status-disabled');
            statusBadge.textContent = isActive ? 'Enabled' : 'Disabled';

            showToast(`${setting.replace('_', ' ')} ${isActive ? 'enabled' : 'disabled'}`, 'info');
        }

        function toggleIPWhitelist(checkbox) {
            const section = document.getElementById('ipWhitelistSection');
            section.style.display = checkbox.checked ? 'block' : 'none';

            if (checkbox.checked) {
                showToast('IP Whitelist enabled - Only whitelisted IPs can access admin areas', 'warning');
            } else {
                showToast('IP Whitelist disabled', 'info');
            }
        }

        function addIP() {
            const ipInput = document.getElementById('newIP');
            const descInput = document.getElementById('ipDescription');
            const ip = ipInput.value.trim();
            const desc = descInput.value.trim() || 'No description';

            if (!ip) {
                showToast('Please enter a valid IP address', 'error');
                return;
            }

            // Simple IP validation
            const ipRegex = /^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/;
            if (!ipRegex.test(ip)) {
                showToast('Invalid IP address format', 'error');
                return;
            }

            // Add to table
            const table = document.getElementById('ipWhitelistTable');
            const row = table.insertRow();
            row.innerHTML = `
                <td>${ip}</td>
                <td>${desc}</td>
                <td>${new Date().toISOString().split('T')[0]}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeIP(this, '${ip}')">
                        Remove
                    </button>
                </td>
            `;

            ipInput.value = '';
            descInput.value = '';
            showToast(`IP ${ip} added to whitelist`, 'success');
        }

        function removeIP(button, ip) {
            if (confirm(`Remove IP ${ip} from whitelist?`)) {
                button.closest('tr').remove();
                showToast(`IP ${ip} removed from whitelist`, 'success');
            }
        }

        function blockIP(ip) {
            if (confirm(`Block IP address ${ip}?`)) {
                showToast(`IP ${ip} has been blocked`, 'success');
                // In real implementation, this would update the database
            }
        }

        function unblockIP(ip) {
            if (confirm(`Unblock IP address ${ip}?`)) {
                showToast(`IP ${ip} has been unblocked`, 'success');
                // In real implementation, this would update the database
            }
        }

        function terminateSession(user) {
            if (confirm(`Terminate session for ${user}?`)) {
                showToast(`Session terminated for ${user}`, 'success');
                // In real implementation, this would invalidate the session
            }
        }

        function showToast(message, type) {
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