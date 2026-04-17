<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup & Restore</title>

    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/table.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/alert.css">

    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/systemadmin/dashboard.style.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/systemadmin/system-admin.css">

    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">

    <style>
        .profile_picture {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.3);
            margin-left: 20px;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .chart-container {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            position: relative;
            height: 300px;
        }

        .chart-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #666;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/dashboard" class="nav-link active">
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
                    <a href="<?= ROOT ?>/announcements" class="nav-link">
                        <span class="nav-text">Announcements</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/profile" class="nav-link">
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
                </button>
                <h1 class="page-title">Backup & Restore</h1>
            </div>

            <div class="header-right">


                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">System Administrator</span>
                    </div>
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
                    <img src="<?= ROOT ?>/assets/images/profiles/<?= $profileImage ?>" alt="" class="profile_picture">
                    
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <?php if (!($is_system_admin ?? false)): ?>
                <div class="alert alert-info mb-4">
                    <h4> Viewing as <?= htmlspecialchars($user_role_name ?? 'Unknown Role') ?></h4>
                    <p>You are viewing the System Admin dashboard with limited permissions. Some features may be restricted
                        or hidden based on your role.</p>
                </div>
            <?php endif; ?>

            <div class="dashboard-sections">
                <div class="dashboard-section" style="display: flex; flex-direction: row; gap: 10px;">
                    <div class="reports-section">
                        <h2 class="section-title">Monthly Backup Frequency</h2>
                        <div class="export-buttons">

                           
                        </div>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <canvas id="myChart1" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="reports-section">
                        <h2 class="section-title">Monthly Restore Frequency</h2>
                        <div class="export-buttons">

                           
                        </div>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <canvas id="myChart2" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Backups and Restores</h2>
                    </div>
                
                    <?php if (!empty($logs)): ?>
                        
                        <div class="table-container">
                            <table class="data-table activity-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Backup name</th>
                                        <th>Size</th>
                                        <!-- <th>Status</th> -->
                                        <th>Created</th>
                                        <th>Restored</th>
                                        <th style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($logs as $log): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($log['id']) ?></td>
                                            <td><?= htmlspecialchars($log['backup_name']) ?></td>
                                            <td><?= htmlspecialchars(round($log['file_size'] / (1024 * 1024), 2)) ?> MB</td>
                                            <!-- <td><?= htmlspecialchars($log['status']) ?></td> -->
                                            <td><?= htmlspecialchars($log['created_at']) ?></td>
                                            <td><?= !empty($log['restored_at']) ? htmlspecialchars($log['restored_at']) : 'N/A' ?>
                                            </td>
                                            <td style="display:flex; gap :15px">
                                                <button <?= !empty($log['restored_at']) ? 'disabled' : '' ?> type="button"
                                                    class="btn btn-sm btn-primary"
                                                    onclick="restoreBackup(<?= $log['id'] ?>,this)"><?= empty($log['restored_at']) ? 'Restore' : 'Restored' ?>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    onclick="downloadBackup(<?= $log['id'] ?>)">Download</button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="deleteBackup(<?= $log['id'] ?>)">Delete</button>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <p>No backups or restores to display</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div style="display:grid;  grid-template-columns: repeat(2, 1fr); gap:16px"
                    class="dashboard-section-parent">
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2 class="section-title">Create backup</h2>
                        </div>
                        <form id="backup-form" action="" method="post">
                            <input type="hidden" name="csrf_token" value="<?= $data['csrf_token'] ?>">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="backupName">Backup Name *</label>
                                    <input type="text" id="backupName" name="backupName" required>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="resetForm()">Reset</button>
                            <button type="button" class="btn btn-primary" onclick="createBackup()">Create</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const whiteBackgroundPlugin = {
            id: 'custom_canvas_background_color',
            beforeDraw: (chart) => {
                const ctx = chart.ctx;
                ctx.save();
                ctx.globalCompositeOperation = 'destination-over';
                ctx.fillStyle = '#f8f9fa';
                ctx.fillRect(0, 0, chart.width, chart.height);
                ctx.restore();
            }
        };
        Chart.register(whiteBackgroundPlugin);
        Chart.defaults.devicePixelRatio = 3;


        let userChart1;
        function backupFrequencyChart() {
            const stats = <?= json_encode($data['monthly_backup_frequencies']) ?>;
            const labels = stats.map(row => row.instance);
            const count = stats.map(row => row.monthly_backup_count);

            const ctx = document.getElementById('myChart1').getContext('2d');

            userChart1 = new Chart(ctx, {   
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Number of backups', data: count, borderWidth: 2 },
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        }
        backupFrequencyChart()

        let userChart2;
        function restoreFrequencyChart() {
            const stats = <?= json_encode($data['monthly_restore_frequencies']) ?>;
            const labels = stats.map(row => row.instance);
            const count = stats.map(row => row.monthly_restore_count);

            const ctx = document.getElementById('myChart2').getContext('2d');

            userChart2 = new Chart(ctx, {  
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Number of restores', data: count, borderWidth: 2 },
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        }
        restoreFrequencyChart()


        const csrfToken = '<?= $data['csrf_token'] ?>';

        function createBackup() {
            if (!confirm("Do you want to create a backup now?")) {
                return;
            }

            const form = document.getElementById('backup-form');
            const formData = new FormData(form);
            formData.set('action', 'create');

            const backupName = formData.get('backupName').trim();
            if (backupName === "") {
                showToast('Backup name is required', 'error');
                return;
            }

            fetch('/HireFlow/public/systemadmin/backuprestore', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while creating database backup', 'error');
                });

        }


        function restoreBackup(id, button) {

            if (!confirm("Do you want to restore a backup now?")) {
                return;
            }

            button.disabled = true;
            button.textContent = 'Restoring...';

            const formData = new FormData(document.createElement('form'));
            formData.set('csrf_token', csrfToken);
            formData.set('action', 'restore');
            formData.set('backup_id', id);

            fetch('/HireFlow/public/systemadmin/backuprestore', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        button.disabled = false;
                        button.textContent = 'Restore';
                        showToast(data.message || 'Restore failed', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    button.disabled = false;
                    button.textContent = 'Restore';
                    showToast('An error occurred while restoring database backup', 'error');
                });

        }


        function deleteBackup(id) {
            if (!confirm("Do you want to delete the backup?")) {
                return;
            }

            const formData = new FormData(document.createElement('form'));
            formData.set('csrf_token', csrfToken);
            formData.set('action', 'delete');
            formData.set('backup_id', id);

            fetch('/HireFlow/public/systemadmin/backuprestore', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast(data.message || 'Deletion failed', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while deleting the database backup', 'error');
                });
        }

        function downloadBackup(id) {
            if (!confirm("Do you want to download the backup?")) {
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/HireFlow/public/systemadmin/backuprestore';
            form.style.display = 'none';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'download';
            form.appendChild(actionInput);

            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'backup_id';
            idInput.value = id;
            form.appendChild(idInput);

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        function resetForm() {
            document.getElementById('backup-form').reset();
        }

        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });

        document.querySelector('.sidebar-toggle').addEventListener('click', function (e) {
            if (e.target.textContent.trim() === ">") {
                e.target.textContent = "<";
            } else { e.target.textContent = ">"; }
        }); document.addEventListener('DOMContentLoaded',
            function () {
                const currentPath = window.location.pathname; const navLinks = document.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    if (link.getAttribute('href').includes(currentPath)) {
                        navLinks.forEach(l => l.classList.remove('active'));
                        link.classList.add('active');
                    }
                });
            });

        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
</body>

</html>