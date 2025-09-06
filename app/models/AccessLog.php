<?php

class AccessLog
{
    use Model;
    protected $table = 'access_logs';
    protected $allowedColumns = [
        'user_id',
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
        return $this->where(['user_id' => $userId], 'created_at desc', $limit);
    }

    /**
     * Get all activity with user details
     */
    public function getAllActivityWithUsers($limit = 50)
    {
        // Convert limit to integer to avoid SQL syntax errors
        $limit = (int)$limit;
        
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
        $timeframe = (int)$timeframe;
        
        $query = "SELECT * FROM access_logs 
                  WHERE action = 'failed_login' 
                  AND created_at >= DATE_SUB(NOW(), INTERVAL $timeframe HOUR)
                  ORDER BY created_at DESC";
        
        return $this->query($query, []);
    }

    /**
     * Count login attempts from IP
     */
    public function countLoginAttempts($ipAddress, $timeframe = 1)
    {
        // Convert timeframe to integer
        $timeframe = (int)$timeframe;
        
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
        $timeframe = (int)$timeframe;
        
        $query = "SELECT COUNT(*) as failed_attempts FROM access_logs 
                  WHERE action = 'failed_login' 
                  AND ip_address = ? 
                  AND created_at >= DATE_SUB(NOW(), INTERVAL $timeframe HOUR)";
        
        $result = $this->query($query, [$ipAddress]);
        $failedAttempts = $result ? $result[0]['failed_attempts'] : 0;
        
        return $failedAttempts >= $maxAttempts;
    }
}
