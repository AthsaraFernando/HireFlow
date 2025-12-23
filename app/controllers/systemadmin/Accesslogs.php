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
        $this->view('systemadmin', $data);
    }

}
