<?php

class Dashboard extends Controller
{
    public function index()
    {
        // Require System Admin access
        Auth::requireRole(1);
        
        $data = [];
        
        // Get system statistics
        $user = new User();
        $role = new Role();
        $accessLog = new AccessLog();
        
        // User statistics
        $allUsers = $user->findAll();
        $data['total_users'] = is_array($allUsers) ? count($allUsers) : 0;
        
        $activeUsers = $user->where(['status' => 'active']);
        $data['active_users'] = is_array($activeUsers) ? count($activeUsers) : 0;
        
        $inactiveUsers = $user->where(['status' => 'inactive']);
        $data['inactive_users'] = is_array($inactiveUsers) ? count($inactiveUsers) : 0;
        
        // Role breakdown
        $systemAdmins = $user->where(['role_id' => 1]);
        $data['system_admins'] = is_array($systemAdmins) ? count($systemAdmins) : 0;
        
        $hrAdmins = $user->where(['role_id' => 2]);
        $data['hr_admins'] = is_array($hrAdmins) ? count($hrAdmins) : 0;
        
        $recruitmentManagers = $user->where(['role_id' => 3]);
        $data['recruitment_managers'] = is_array($recruitmentManagers) ? count($recruitmentManagers) : 0;
        
        $applicants = $user->where(['role_id' => 4]);
        $data['applicants'] = is_array($applicants) ? count($applicants) : 0;
        
        // Recent activity
        $data['recent_logins'] = $accessLog->getAllActivityWithUsers(10);
        
        $failedLogins = $accessLog->getFailedLogins(24);
        $data['failed_logins_today'] = is_array($failedLogins) ? count($failedLogins) : 0;
        
        // System info
        $data['roles'] = $role->findAll();
        $data['current_user'] = Auth::user();
        
        $data['view'] = 'dashboard';
        $this->view('systemadmin', $data);
    }
}