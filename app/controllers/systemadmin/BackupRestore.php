<?php

class BackupRestore extends Controller
{
    public function index()
    {
        Auth::requireRole(1);

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';

        // Pass user role information to view
        $data['current_user_role'] = Auth::user_role();
        $data['is_system_admin'] = Auth::hasRole(1);
        $data['user_role_name'] = getRoleName(Auth::user_role());
        $data['current_user'] = Auth::user();
        $data['csrf_token'] = Auth::generateCSRFToken();


        $accessLog = new AccessLog();
        $data['recent_logins'] = $accessLog->getAllActivityWithUsers(15);

        $canCreateBackups = Auth::hasRole(1);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // logger($_POST);
            if (!$canCreateBackups) {
                echo json_encode(['success' => false, 'message' => 'Insufficient privileges to perform this action.']);
                return;
            } elseif (!isset($_POST['csrf_token']) || !Auth::verifyCSRFToken($_POST['csrf_token'])) {
                echo json_encode(['success' => false, 'message' => 'Invalid request. Please try again.']);
                return;
            }

            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create':
                    $this->createBackup();
                    return;
                case 'restore':
                    $this->restoreBackup();
                    return;
                case 'download':
                    $this->downloadBackup();
                    return;
                default:
                    $data['errors']['general'] = "Invalid action";
                    return;
            }
        }

        $backup = new Backup();
        $data['logs'] = $backup->fetchLogs();


        $this->view('systemadmin/backup-restore', $data);

    }

    // Create access logs for all the activites

    public function createBackup()
    { // Implement here - Use the backup name + current datetime and create a db backup and save in  the backups folder

        $date = date('Ymd_His');
        if (isset($_POST['backupName'])) {
            $backupName = "hireflow_backup_{$_POST['backupName']}_{$date}.sql";
        } else {
            $backupName = "hireflow_backup_{$date}.sql";
        }
        $backupFolder = __DIR__ . '/backups/';
        $backupPath = $backupFolder . $backupName;

        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPass = '';
        $dbName = 'hireflow_db';

        if (!is_dir($backupFolder)) {
            mkdir($backupFolder, 0755, true);
        }

        $command = "mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} --ignore-table={$dbName}.db_backups --ignore-table={$dbName}.access_logs > {$backupPath}";
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Backup failed']);
            exit;
        }

        $fileSize = filesize($backupPath);

        Backup::log($backupName, $backupPath, $fileSize, 'success');

        $accessLog = new AccessLog();
        $accessLog::log('db_backup', 'Database backed up successfully');

        echo json_encode(['success' => true, 'message' => 'Backup created successfully']);
    }


    public function restoreBackup()
    { // Implement here
        $backupId = (int) $_POST['backup_id'];

        $backup = new Backup();
        $backupData = $backup->first(['id' => $backupId]);

        $backupPath = $backupData['file_path'];
        if (!file_exists($backupPath)) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Backup file missing']);
            exit;
        }

        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPass = '';
        $dbName = 'hireflow_db';

        $command = "mysql --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} < {$backupPath}";
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database restore failed']);
            exit;
        }

        $backup->markAsRestored($backupId);

        $accessLog = new AccessLog();
        $accessLog::log('db_restore', "Database restored from backup ID {$backupId}");

        echo json_encode(['success' => true, 'message' => 'Backup restored successfully']);

    }

    public function downloadBackup()
    {
        $backupId = (int) ($_POST['backup_id'] ?? 0);

        if ($backupId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid backup ID']);
            return;
        }

        $backup = new Backup();
        $backupData = $backup->first(['id' => $backupId]);

        if (!$backupData || empty($backupData['file_path'])) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Backup record not found']);
            return;
        }

        $backupPath = $backupData['file_path'];
        if (!file_exists($backupPath) || !is_readable($backupPath)) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Backup file missing or unreadable']);
            return;
        }

        $downloadName = !empty($backupData['backup_name']) ? basename($backupData['backup_name']) : basename($backupPath);

        // Ensure no buffered output corrupts the file stream.
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="' . $downloadName . '"');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: public');
        header('Expires: 0');
        header('Content-Length: ' . filesize($backupPath));

        $accessLog = new AccessLog();
        $accessLog::log('db_backup_download', "Database backup downloaded: ID {$backupId}");

        readfile($backupPath);
        exit;

    }


}
