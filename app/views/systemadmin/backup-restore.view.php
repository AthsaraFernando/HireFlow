<?php
// Sample backup data - in real implementation this would come from filesystem/database
$backups = [
    [
        'id' => 1,
        'filename' => 'hireflow_backup_2025_08_31_10_30.sql',
        'size' => '2.5 MB',
        'created_at' => '2025-08-31 10:30:15',
        'type' => 'Full',
        'status' => 'Complete'
    ],
    [
        'id' => 2,
        'filename' => 'hireflow_backup_2025_08_30_10_30.sql',
        'size' => '2.3 MB',
        'created_at' => '2025-08-30 10:30:12',
        'type' => 'Full',
        'status' => 'Complete'
    ],
    [
        'id' => 3,
        'filename' => 'hireflow_backup_2025_08_29_10_30.sql',
        'size' => '2.1 MB',
        'created_at' => '2025-08-29 10:30:08',
        'type' => 'Full',
        'status' => 'Complete'
    ]
];

$backup_schedule = [
    'auto_backup' => true,
    'frequency' => 'daily',
    'time' => '10:30',
    'retention_days' => 30,
    'max_backups' => 50
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup & Restore - HireFlow Admin</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/table.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/alert.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/dashboard.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
    
    <style>
        .backup-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .backup-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.3em;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .backup-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .action-card {
            border: 2px solid #ecf0f1;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .action-card:hover {
            border-color: #3498db;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.2);
        }
        
        .action-icon {
            font-size: 2.5em;
            margin-bottom: 15px;
        }
        
        .backup-progress {
            width: 100%;
            height: 20px;
            background: #ecf0f1;
            border-radius: 10px;
            overflow: hidden;
            margin: 15px 0;
        }
        
        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #3498db, #2ecc71);
            border-radius: 10px;
            transition: width 0.3s ease;
        }
        
        .backup-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .backup-table th,
        .backup-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }
        
        .backup-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: 500;
        }
        
        .status-complete {
            background: #d4edda;
            color: #155724;
        }
        
        .status-progress {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-error {
            background: #f8d7da;
            color: #721c24;
        }
        
        .schedule-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
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
        
        .danger-zone {
            border: 2px solid #e74c3c;
            background: #fdf2f2;
        }
        
        .restore-warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <?php 
    // Set user data for header
    $user_role = 'System Admin';
    $user_name = 'Admin User';
    include '../views/components/header.view.php'; 
    ?>
    
    <div class="backup-container">
        <div class="page-header">
            <h1>💾 Backup & Restore</h1>
            <p>Manage database backups and restore operations</p>
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

        <!-- Quick Actions -->
        <div class="backup-section">
            <h2 class="section-title">Quick Actions</h2>
            <div class="backup-actions">
                <div class="action-card">
                    <div class="action-icon">📦</div>
                    <h3>Create Backup</h3>
                    <p>Generate a full database backup</p>
                    <button class="btn btn-primary" onclick="createBackup()">Create Now</button>
                </div>
                
                <div class="action-card">
                    <div class="action-icon">📤</div>
                    <h3>Export Data</h3>
                    <p>Export specific tables or data</p>
                    <button class="btn btn-outline-primary" onclick="showExportModal()">Export</button>
                </div>
                
                <div class="action-card">
                    <div class="action-icon">📥</div>
                    <h3>Import Data</h3>
                    <p>Import from backup file</p>
                    <button class="btn btn-outline-secondary" onclick="showImportModal()">Import</button>
                </div>
                
                <div class="action-card">
                    <div class="action-icon">🔄</div>
                    <h3>System Status</h3>
                    <p>Database: <span style="color: #27ae60;">✓ Online</span></p>
                    <p>Storage: <span style="color: #27ae60;">✓ 8.5GB Free</span></p>
                </div>
            </div>
        </div>

        <!-- Backup Progress (hidden by default) -->
        <div id="backupProgress" class="backup-section" style="display: none;">
            <h2 class="section-title">Backup in Progress</h2>
            <div class="backup-progress">
                <div class="progress-bar" id="progressBar" style="width: 0%"></div>
            </div>
            <p id="progressText">Initializing backup...</p>
            <button class="btn btn-outline-danger" onclick="cancelBackup()">Cancel</button>
        </div>

        <!-- Backup Schedule -->
        <div class="backup-section">
            <h2 class="section-title">Backup Schedule</h2>
            <form method="POST" action="<?= ROOT ?>/systemadmin/backup-restore" class="schedule-form">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <input type="checkbox" <?= $backup_schedule['auto_backup'] ? 'checked' : '' ?> name="auto_backup"> 
                            Enable Automatic Backups
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label for="frequency" class="form-label">Frequency</label>
                        <select id="frequency" name="frequency" class="form-input">
                            <option value="daily" <?= $backup_schedule['frequency'] === 'daily' ? 'selected' : '' ?>>Daily</option>
                            <option value="weekly" <?= $backup_schedule['frequency'] === 'weekly' ? 'selected' : '' ?>>Weekly</option>
                            <option value="monthly" <?= $backup_schedule['frequency'] === 'monthly' ? 'selected' : '' ?>>Monthly</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="backup_time" class="form-label">Backup Time</label>
                        <input type="time" id="backup_time" name="backup_time" class="form-input" 
                               value="<?= $backup_schedule['time'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="retention_days" class="form-label">Keep Backups (days)</label>
                        <input type="number" id="retention_days" name="retention_days" class="form-input" 
                               value="<?= $backup_schedule['retention_days'] ?>" min="1" max="365">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary mt-3">Save Schedule</button>
            </form>
        </div>

        <!-- Existing Backups -->
        <div class="backup-section">
            <h2 class="section-title">Available Backups</h2>
            <table class="backup-table">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Size</th>
                        <th>Created</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($backups as $backup): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($backup['filename']) ?></strong>
                        </td>
                        <td><?= htmlspecialchars($backup['size']) ?></td>
                        <td><?= date('M d, Y H:i', strtotime($backup['created_at'])) ?></td>
                        <td><?= htmlspecialchars($backup['type']) ?></td>
                        <td>
                            <span class="status-badge status-complete">
                                <?= htmlspecialchars($backup['status']) ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="downloadBackup('<?= $backup['id'] ?>')">
                                📥 Download
                            </button>
                            <button class="btn btn-sm btn-outline-warning ml-1" onclick="restoreBackup('<?= $backup['id'] ?>', '<?= $backup['filename'] ?>')">
                                🔄 Restore
                            </button>
                            <button class="btn btn-sm btn-outline-danger ml-1" onclick="deleteBackup('<?= $backup['id'] ?>', '<?= $backup['filename'] ?>')">
                                🗑️ Delete
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Restore Operations -->
        <div class="backup-section danger-zone">
            <h2 class="section-title">⚠️ Restore Operations</h2>
            
            <div class="restore-warning">
                <strong>Warning:</strong> Restore operations will overwrite existing data. 
                Make sure to create a backup before proceeding with any restore operation.
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="restore_file" class="form-label">Upload Backup File</label>
                    <input type="file" id="restore_file" name="restore_file" class="form-input" accept=".sql">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Restore Options</label>
                    <div>
                        <label><input type="checkbox" checked> Drop existing tables</label><br>
                        <label><input type="checkbox" checked> Reset auto-increment values</label><br>
                        <label><input type="checkbox"> Create database if not exists</label>
                    </div>
                </div>
            </div>
            
            <button class="btn btn-danger" onclick="confirmRestore()">
                🔄 Start Restore Process
            </button>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?= ROOT ?>/systemadmin/dashboard" class="btn btn-outline-secondary">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    <?php include '../views/components/footer.view.php'; ?>

    <script src="<?= ROOT ?>/assets/js/main.js"></script>
    <script>
        function createBackup() {
            if (confirm('Create a new full database backup?')) {
                showProgress();
                simulateBackupProgress();
            }
        }
        
        function showProgress() {
            document.getElementById('backupProgress').style.display = 'block';
            document.getElementById('backupProgress').scrollIntoView();
        }
        
        function simulateBackupProgress() {
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            let progress = 0;
            
            const steps = [
                'Initializing backup...',
                'Backing up user data...',
                'Backing up job posts...',
                'Backing up applications...',
                'Compressing backup file...',
                'Backup completed successfully!'
            ];
            
            const interval = setInterval(() => {
                progress += 20;
                progressBar.style.width = progress + '%';
                
                if (progress <= 100) {
                    progressText.textContent = steps[Math.floor(progress / 20)];
                }
                
                if (progress >= 100) {
                    clearInterval(interval);
                    setTimeout(() => {
                        document.getElementById('backupProgress').style.display = 'none';
                        showToast('Backup created successfully!', 'success');
                        // In real implementation, reload the backup list
                    }, 2000);
                }
            }, 1000);
        }
        
        function cancelBackup() {
            if (confirm('Cancel the current backup operation?')) {
                document.getElementById('backupProgress').style.display = 'none';
                showToast('Backup operation cancelled', 'warning');
            }
        }
        
        function downloadBackup(id) {
            showToast('Preparing download...', 'info');
            // In real implementation, this would trigger a file download
            setTimeout(() => {
                showToast('Download started', 'success');
            }, 1000);
        }
        
        function restoreBackup(id, filename) {
            if (confirm(`Restore from backup: ${filename}?\n\nWARNING: This will overwrite all existing data!`)) {
                showToast('Restore operation started', 'warning');
                // In real implementation, this would start the restore process
            }
        }
        
        function deleteBackup(id, filename) {
            if (confirm(`Delete backup: ${filename}?\n\nThis action cannot be undone.`)) {
                showToast('Backup deleted', 'success');
                // In real implementation, this would delete the file
            }
        }
        
        function confirmRestore() {
            const fileInput = document.getElementById('restore_file');
            if (!fileInput.files.length) {
                showToast('Please select a backup file first', 'error');
                return;
            }
            
            if (confirm('Start restore process?\n\nWARNING: This will overwrite all existing data!')) {
                showToast('Restore process initiated', 'warning');
                // In real implementation, this would upload and restore the file
            }
        }
        
        function showExportModal() {
            showToast('Export feature coming soon', 'info');
            // In real implementation, this would show an export modal
        }
        
        function showImportModal() {
            showToast('Import feature coming soon', 'info');
            // In real implementation, this would show an import modal
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
