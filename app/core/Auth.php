<?php

class Auth
{
    private const REMEMBER_ME_COOKIE = 'hireflow_remember';
    private const REMEMBER_ME_DAYS = 30;

    /**
     * Check if user is logged in
     */
    public static function logged_in()
    {
        if (isset($_SESSION['USER']) && !empty($_SESSION['USER'])) {
            return true;
        }

        return self::loginFromRememberMeCookie();
    }

    /**
     * Get current user data
     */
    public static function user()
    {
        return $_SESSION['USER'] ?? null;
    }

    /**
     * Get current user ID
     */
    public static function user_id()
    {
        return $_SESSION['USER_ID'] ?? null;
    }

    /**
     * Get current user role ID
     */
    public static function user_role()
    {
        return $_SESSION['USER_ROLE'] ?? null;
    }

    /**
     * Check if user has specific role
     */
    public static function hasRole($roleId)
    {
        return self::user_role() == $roleId;
    }

    /**
     * Check if user is System Admin
     */
    public static function isSystemAdmin()
    {
        return self::hasRole(1);
    }

    /**
     * Check if user is HR Admin
     */
    public static function isHRAdmin()
    {
        return self::hasRole(2);
    }

    /**
     * Check if user is Recruitment Manager
     */
    public static function isRecruitmentManager()
    {
        return self::hasRole(3);
    }

    /**
     * Check if user is Applicant
     */
    public static function isApplicant()
    {
        return self::hasRole(4);
    }

    /**
     * Check if user has minimum role level
     */
    public static function hasMinRole($minRoleId)
    {
        $userRole = self::user_role();
        return $userRole && $userRole <= $minRoleId;
    }

    /**
     * Require login - redirect if not logged in
     */
    public static function requireLogin($redirectTo = 'signin')
    {
        if (!self::logged_in()) {
            redirect($redirectTo);
            exit();
        }
        
        // Check session timeout (30 minutes)
        if (isset($_SESSION['LOGIN_TIME']) && (time() - $_SESSION['LOGIN_TIME']) > 1800) {
            self::logout();
            redirect($redirectTo . '?timeout=1');
            exit();
        }
        
        // Update session activity
        $_SESSION['LOGIN_TIME'] = time();
    }

    /**
     * Require specific role - redirect if insufficient permissions
     */
    public static function requireRole($roleId, $redirectTo = '404')
    {
        self::requireLogin();
        
        if (!self::hasRole($roleId)) {
            redirect($redirectTo);
            exit();
        }
    }

    /**
     * Require minimum role level
     */
    public static function requireMinRole($minRoleId, $redirectTo = '404')
    {
        self::requireLogin();
        
        if (!self::hasMinRole($minRoleId)) {
            redirect($redirectTo);
            exit();
        }
    }

    /**
     * Logout user
     */
    public static function logout()
    {
        // Log access
        if (self::logged_in()) {
            AccessLog::log('logout', 'User logged out');
        }
        
        // Clear session
        unset($_SESSION['USER']);
        unset($_SESSION['USER_ID']);
        unset($_SESSION['USER_ROLE']);
        unset($_SESSION['LOGIN_TIME']);

        self::clearRememberMeCookie();
        
        // Destroy session if no other data
        if (empty($_SESSION)) {
            session_destroy();
        }
    }

    /**
     * Enable remember me for a user
     */
    public static function setRememberMeCookie($userId)
    {
        $userId = (int) $userId;
        if ($userId <= 0) {
            return;
        }

        $expires = time() + (self::REMEMBER_ME_DAYS * 24 * 60 * 60);
        $payload = $userId . '|' . $expires;
        $signature = hash_hmac('sha256', $payload, self::rememberMeSecret());
        $cookieValue = base64_encode($payload . '|' . $signature);

        setcookie(self::REMEMBER_ME_COOKIE, $cookieValue, [
            'expires' => $expires,
            'path' => '/',
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    /**
     * Clear remember me cookie
     */
    public static function clearRememberMeCookie()
    {
        setcookie(self::REMEMBER_ME_COOKIE, '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        unset($_COOKIE[self::REMEMBER_ME_COOKIE]);
    }

    /**
     * Try to restore login from remember me cookie
     */
    private static function loginFromRememberMeCookie()
    {
        if (empty($_COOKIE[self::REMEMBER_ME_COOKIE])) {
            return false;
        }

        $decoded = base64_decode($_COOKIE[self::REMEMBER_ME_COOKIE], true);
        if ($decoded === false) {
            self::clearRememberMeCookie();
            return false;
        }

        $parts = explode('|', $decoded);
        if (count($parts) !== 3) {
            self::clearRememberMeCookie();
            return false;
        }

        [$userId, $expires, $signature] = $parts;
        if (!ctype_digit($userId) || !ctype_digit($expires)) {
            self::clearRememberMeCookie();
            return false;
        }

        if ((int) $expires < time()) {
            self::clearRememberMeCookie();
            return false;
        }

        $payload = $userId . '|' . $expires;
        $expectedSignature = hash_hmac('sha256', $payload, self::rememberMeSecret());
        if (!hash_equals($expectedSignature, $signature)) {
            self::clearRememberMeCookie();
            return false;
        }

        $userModel = new User();
        $user = $userModel->first(['id' => (int) $userId], []);

        if (!$user || (isset($user['status']) && $user['status'] !== 'active')) {
            self::clearRememberMeCookie();
            return false;
        }

        $_SESSION['USER'] = $user;
        $_SESSION['USER_ID'] = $user['id'];
        $_SESSION['USER_ROLE'] = $user['role_id'];
        $_SESSION['LOGIN_TIME'] = time();

        return true;
    }

    /**
     * Generate a secret for signing remember me cookies
     */
    private static function rememberMeSecret()
    {
        return hash('sha256', APP_NAME . '|' . DB_NAME . '|' . DB_USER . '|hireflow-remember');
    }

    /**
     * Get user's full name
     */
    public static function fullName()
    {
        $user = self::user();
        return $user['full_name'] ?? 'Unknown User';
    }

    /**
     * Get user's email
     */
    public static function email()
    {
        $user = self::user();
        return $user['email'] ?? '';
    }

    /**
     * Get user's profile image
     */
    public static function profileImage()
    {
        $user = self::user();
        return $user['profile_picture'] ?? 'default-avatar.jpg';
    }

    /**
     * Check if current user can access route
     */
    public static function canAccess($route)
    {
        if (!self::logged_in()) {
            return false;
        }

        $role = self::user_role();
        
        // Define route permissions
        $permissions = [
            1 => [ // System Admin
                'systemadmin', 'hradmin', 'manager', 'applicant'
            ],
            2 => [ // HR Admin
                'hradmin', 'manager', 'applicant'
            ],
            3 => [ // Recruitment Manager
                'manager', 'applicant'
            ],
            4 => [ // Applicant
                'applicant'
            ]
        ];

        if (!isset($permissions[$role])) {
            return false;
        }

        // Extract main route part
        $mainRoute = explode('/', trim($route, '/'))[0];
        
        return in_array($mainRoute, $permissions[$role]);
    }

    /**
     * Get role name
     */
    public static function roleName()
    {
        $roleNames = [
            1 => 'System Administrator',
            2 => 'HR Administrator', 
            3 => 'Recruitment Manager',
            4 => 'Applicant'
        ];
        
        return $roleNames[self::user_role()] ?? 'Unknown Role';
    }

    /**
     * Start secure session
     */
    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Secure session configuration
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
            ini_set('session.use_strict_mode', 1);
            
            session_start();
            
            // Regenerate session ID periodically
            if (!isset($_SESSION['created'])) {
                $_SESSION['created'] = time();
            } elseif (time() - $_SESSION['created'] > 1800) {
                session_regenerate_id(true);
                $_SESSION['created'] = time();
            }
        }
    }

    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verify CSRF token
     */
    public static function verifyCSRFToken($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
