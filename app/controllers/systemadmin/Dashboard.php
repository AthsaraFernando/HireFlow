<?php

class Dashboard extends Controller
{
    public function index()
    {
        
        Auth::requireRole(1);
        $data = [];

        $data['current_user_role'] = Auth::user_role();
        $data['is_system_admin'] = Auth::hasRole(1);
        $data['user_role_name'] = getRoleName(Auth::user_role());

        $user = new User();
        $role = new Role();
        $accessLog = new AccessLog();

        $allUsers = $user->findAll();
        $data['total_users'] = is_array($allUsers) ? count($allUsers) : 0;

        $activeUsers = $user->where(['status' => 'active']);
        $data['active_users'] = is_array($activeUsers) ? count($activeUsers) : 0;

        $applicants = $user->where(['role_id' => 4]);
        $data['applicants'] = is_array($applicants) ? count($applicants) : 0;
        
        $data["recent_registrations"] = $accessLog->getRecentRegistrationsCount();
        $data["pending_applications"] = $accessLog->getPendingApplicationsCount();
        
        $data['recent_logins'] = $accessLog->getAllActivityWithUsers(15);

        $data['roles'] = $role->findAll();
        $data['current_user'] = Auth::user();
        $data['view'] = 'dashboard';
        $this->view('systemadmin', $data);
    }
}