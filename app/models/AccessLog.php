<?php

class AccessLog
{
    use Model;
    protected $table = 'access_logs';
    protected $allowedColumns = [
        'user_id',
        'user_role',
        'action',
        'details',
        'ip_address',
        'user_agent',
        'created_at'
    ];

    /**
     * Log user activity
     */
    public static function log($action, $details = '', $userId = null)
    {
        $accessLog = new self();

        $data = [
            'user_id' => $userId ?? Auth::user_id(),
            'user_role' => Auth::user_role(),
            'action' => $action,
            'details' => $details,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $accessLog->insert($data);
    }

    /**
     * Get recent activity for user
     */
    public function getUserActivity($userId, $limit = 10)
    {
        // return $this->where(['user_id' => $userId], 'created_at desc', $limit);
        return $this->where(['user_id' => $userId], 'created_at desc');

    }

    /**
     * Get all activity with user details
     */
    public function getAllActivityWithUsers($limit = 50)
    {
        // Convert limit to integer to avoid SQL syntax errors
        $limit = (int) $limit;

        $query = "SELECT al.*, u.full_name, u.email, r.role_name 
                  FROM access_logs al 
                  LEFT JOIN users u ON al.user_id = u.id 
                  LEFT JOIN roles r ON u.role_id = r.id 
                  ORDER BY al.created_at DESC 
                  LIMIT $limit";

        return $this->query($query, []);
    }

    /**
     * Get failed login attempts
     */
    public function getFailedLogins($timeframe = 24)
    {
        // Convert timeframe to integer
        $timeframe = (int) $timeframe;

        $query = "SELECT * FROM access_logs 
                  WHERE action = 'failed_login' 
                  AND created_at >= DATE_SUB(NOW(), INTERVAL $timeframe HOUR)
                  ORDER BY created_at DESC";

        $result = $this->query($query, []);
        // Always return an array (even if query fails or returns nothing)
        if (is_array($result)) {
            return $result;
        }

        return [];
    }

    /**
     * Count login attempts from IP
     */
    public function countLoginAttempts($ipAddress, $timeframe = 1)
    {
        // Convert timeframe to integer
        $timeframe = (int) $timeframe;

        $query = "SELECT COUNT(*) as attempts FROM access_logs 
                  WHERE action IN ('login', 'failed_login') 
                  AND ip_address = ? 
                  AND created_at >= DATE_SUB(NOW(), INTERVAL $timeframe HOUR)";

        $result = $this->query($query, [$ipAddress]);
        return $result ? $result[0]['attempts'] : 0;
    }

    /**
     * Check if IP is blocked due to too many failed attempts
     */
    public function isIPBlocked($ipAddress, $maxAttempts = 5, $timeframe = 1)
    {
        // Convert timeframe to integer
        $timeframe = (int) $timeframe;

        $query = "SELECT COUNT(*) as failed_attempts FROM access_logs 
                  WHERE action = 'failed_login' 
                  AND ip_address = ? 
                  AND created_at >= DATE_SUB(NOW(), INTERVAL $timeframe HOUR)";

        $result = $this->query($query, [$ipAddress]);
        $failedAttempts = $result ? $result[0]['failed_attempts'] : 0;

        return $failedAttempts >= $maxAttempts;
    }


    public function countAction($action)
    {
        $query = "SELECT COUNT(*) AS total FROM {$this->table} WHERE action = '$action'";
        $result = $this->query($query);
        // logger($result);
        return $result ? (int) $result[0]['total'] : 0;
    }

    public function getUserTrendStats()
    {
        $query = "SELECT
        DATE(created_at) AS log_date,
        SUM(action = 'login') AS logins,
        SUM(action = 'registration') AS registrations,
        SUM(action = 'application_submit') AS applications_submitted
        FROM {$this->table}
        GROUP BY DATE(created_at)
        ORDER BY log_date ASC";

        $result = $this->query($query);
        return $result ? $result : 0;

    }

    public function getTotalLogs()
    {
        $result = $this->query("SELECT COUNT(*) as total FROM access_logs");
        return $result ? $result[0]['total'] : 0;
    }


    public function getUniqueActions()
    {
        $result = $this->query("SELECT DISTINCT action FROM access_logs ORDER BY action");
        return $result ? array_column($result, 'action') : [];
    }

    public function getAllUsers()
    {
        $user = new User();
        return $user->query("SELECT id, full_name, email FROM users ORDER BY full_name") ?: [];
    }

    public function getAllLogs()
    {
        $result = $this->query("SELECT * FROM access_logs");
        return $result ? $result : [];
    }


    public function getUniqueUsersToday()
    {
        $result = $this->query("SELECT COUNT(DISTINCT user_id) as unique_users 
                                   FROM access_logs 
                                   WHERE DATE(created_at) = CURDATE() 
                                   AND user_id IS NOT NULL");
        return $result ? $result[0]['unique_users'] : 0;
    }

    public function getBlockedIPs()
    {
        // Get IPs with more than 5 failed login attempts in the last hour
        $result = $this->query("SELECT ip_address, COUNT(*) as attempts 
                                   FROM access_logs 
                                   WHERE action = 'failed_login' 
                                   AND created_at >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
                                   GROUP BY ip_address 
                                   HAVING attempts >= 5");
        return $result ?: [];
    }

}
