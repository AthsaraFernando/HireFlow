<?php

class Accesslogs extends Controller
{
    public function index()
    {
        // Require System Admin role (role_id = 1)
        Auth::requireRole(1);

        $data = [];
        $accessLog = new AccessLog();

        // Get filter parameters
        $action = $_GET['action'] ?? '';
        $userId = $_GET['user_id'] ?? '';
        $dateFrom = $_GET['date_from'] ?? '';
        $dateTo = $_GET['date_to'] ?? '';
        $limit = (int) ($_GET['limit'] ?? 50);

        // Build query conditions
        $conditions = [];
        $params = [];

        if (!empty($action)) {
            $conditions[] = "al.action = ?";
            $params[] = $action;
        }

        if (!empty($userId)) {
            $conditions[] = "al.user_id = ?";
            $params[] = $userId;
        }

        if (!empty($dateFrom)) {
            $conditions[] = "DATE(al.created_at) >= ?";
            $params[] = $dateFrom;
        }

        if (!empty($dateTo)) {
            $conditions[] = "DATE(al.created_at) <= ?";
            $params[] = $dateTo;
        }

        // Build query
        $whereClause = '';
        if (!empty($conditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $conditions);
        }

        $query = "SELECT al.*, u.full_name, u.email, r.role_name 
                  FROM access_logs al 
                  LEFT JOIN users u ON al.user_id = u.id 
                  LEFT JOIN roles r ON u.role_id = r.id 
                  $whereClause
                  ORDER BY al.created_at DESC 
                  LIMIT " . (int) $limit;

        // Get filtered logs
        $data['logs'] = $accessLog->query($query, $params) ?: [];

        // Get summary statistics
        $data['total_logs'] = $this->getTotalLogs($accessLog);
        $data['failed_logins_today'] = count($accessLog->getFailedLogins(24));
        $data['unique_users_today'] = $this->getUniqueUsersToday($accessLog);
        $data['blocked_ips'] = $this->getBlockedIPs($accessLog);

        // Get filter options
        $data['actions'] = $this->getUniqueActions($accessLog);
        $data['users'] = $this->getAllUsers();

        // Current filter values
        $data['current_filters'] = [
            'action' => $action,
            'user_id' => $userId,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'limit' => $limit
        ];

        $data['logs'] =  $this->getAllLogs($accessLog);
        $data['view'] = 'accesslogs';
        $this->view('systemadmin', $data);
    }

    private function getTotalLogs($accessLog)
    {
        $result = $accessLog->query("SELECT COUNT(*) as total FROM access_logs");
        return $result ? $result[0]['total'] : 0;
    }

    private function getUniqueUsersToday($accessLog)
    {
        $result = $accessLog->query("SELECT COUNT(DISTINCT user_id) as unique_users 
                                   FROM access_logs 
                                   WHERE DATE(created_at) = CURDATE() 
                                   AND user_id IS NOT NULL");
        return $result ? $result[0]['unique_users'] : 0;
    }

    private function getBlockedIPs($accessLog)
    {
        // Get IPs with more than 5 failed login attempts in the last hour
        $result = $accessLog->query("SELECT ip_address, COUNT(*) as attempts 
                                   FROM access_logs 
                                   WHERE action = 'failed_login' 
                                   AND created_at >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
                                   GROUP BY ip_address 
                                   HAVING attempts >= 5");
        return $result ?: [];
    }

    private function getUniqueActions($accessLog)
    {
        $result = $accessLog->query("SELECT DISTINCT action FROM access_logs ORDER BY action");
        return $result ? array_column($result, 'action') : [];
    }

    private function getAllUsers()
    {
        $user = new User();
        return $user->query("SELECT id, full_name, email FROM users ORDER BY full_name") ?: [];
    }

    private function getAllLogs($accessLog)
    {
        $result = $accessLog->query("SELECT * FROM access_logs");
        return $result ? $result : [];
    }
}
