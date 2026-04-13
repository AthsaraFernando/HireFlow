<?php

class Accesslogs extends Controller
{
    public function index()
    {
        // Require System Admin role (role_id = 1)
        Auth::requireRole(1);

        $data = [];
        $accessLog = new AccessLog();

        // Get summary statistics
        $data['total_logs'] = $accessLog->getTotalLogs();
        $data['failed_logins_today'] = count($accessLog->getFailedLogins(24));
        $data['unique_users_today'] = $accessLog->getUniqueUsersToday();
        $data['blocked_ips'] = $accessLog->getBlockedIPs();
        // Get filter options
        $data['actions'] = $accessLog->getUniqueActions();
        $data['users'] = $accessLog->getAllUsers();
        // Get all access logs
        $data['logs'] = $accessLog->getAllLogs();
        $data['view'] = 'accesslogs';
        $data['csrf_token'] = Auth::generateCSRFToken();
        $this->view('systemadmin', $data);
    }

    public function updateFlag($action = null, $id = null)
    {
        // logger($action); // Route testing
        // logger($id);

        Auth::requireRole(1);
        $canUpdateLogs = Auth::hasRole(1);
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$canUpdateLogs) {
                echo json_encode([
                    'message' => 'Not authorized to update accesslogs',
                    'success' => false
                ]);
                exit;
            } else if (!isset($_POST['csrf_token']) || !Auth::verifyCSRFToken($_POST['csrf_token'])) {
                echo json_encode([
                    'message' => 'Not authorized to update accesslogs',
                    'success' => false
                ]);
                exit;
            }

            $accessLogs = new AccessLog();

            $logId = $_POST['log_id'];
            $updateData = [
                'flagged' => $_POST['flag_value']
            ];

            if ($accessLogs->update($logId, $updateData)) {
                echo json_encode([
                    'success' => true
                ]);
                exit;
            } else {
                echo json_encode([
                    'success' => true
                ]);
                exit;
            }




        }

    }

}
