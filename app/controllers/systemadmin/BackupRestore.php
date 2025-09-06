<?php

class BackupRestore extends Controller
{
    public function index()
    {
        // Require System Admin role (role_id = 1)
        Auth::requireRole(1);
        
        // Sample data - in real implementation this would come from filesystem/database
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        
        if ($_POST) {
            // Handle backup/restore operations
            $data['success'] = 'Backup operation completed successfully!';
        }
        
        $this->view('systemadmin/backup-restore', $data);
    }
}
