<?php

class Auth
{
    /**
     * Check if user is logged in
     */
    public static function logged_in()
    {
        return isset($_SESSION['USER']) && !empty($_SESSION['USER']);
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
        
        // Destroy session if no other data
        if (empty($_SESSION)) {
            session_destroy();
        }
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
        return $user['profile_image'] ?? 'default-avatar.png';
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
