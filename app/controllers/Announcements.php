<?php

class Announcements extends Controller
{
    public function index()
    {
        Auth::requireLogin();

        $announcementModel = new Announcement();
        $data = [];
        $data['errors'] = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !Auth::verifyCSRFToken($_POST['csrf_token'])) {
                $data['errors']['general'] = 'Invalid request. Please try again.';
            } else {
                $action = $_POST['action'] ?? '';

                if (in_array($action, ['create', 'update', 'delete'], true)) {
                    Auth::requireRole(1);
                    $this->handleAdminAction($action, $announcementModel, $data);
                }
            }
        }

        $editAnnouncement = null;
        if (Auth::isSystemAdmin() && isset($_GET['edit'])) {
            $editAnnouncement = $announcementModel->getById((int) $_GET['edit']);
        }

        $data['announcements'] = $announcementModel->getAllWithAuthor();
        $data['is_system_admin'] = Auth::isSystemAdmin();
        $data['edit_announcement'] = $editAnnouncement;
        $data['csrf_token'] = Auth::generateCSRFToken();
        $data['flash_message'] = $_SESSION['announcement_flash'] ?? '';
        unset($_SESSION['announcement_flash']);
        $data['page_title'] = 'Announcements';

        $this->view('announcements', $data);
    }

    private function handleAdminAction($action, $announcementModel, &$data)
    {
        switch ($action) {
            case 'create':
                $payload = [
                    'title' => trim($_POST['title'] ?? ''),
                    'message' => trim($_POST['message'] ?? ''),
                    'created_by' => Auth::user_id(),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if (!$announcementModel->validate($payload)) {
                    $data['errors'] = $announcementModel->errors;
                    return;
                }

                $insertedId = $announcementModel->insert($payload);
                if ($insertedId) {
                    AccessLog::log('announcement_created', 'Created announcement ID: ' . $insertedId);
                    $_SESSION['announcement_flash'] = 'Announcement created successfully.';
                    redirect('announcements');
                    exit();
                }

                $data['errors']['general'] = 'Failed to create announcement.';
                return;

            case 'update':
                $announcementId = (int) ($_POST['announcement_id'] ?? 0);
                if ($announcementId <= 0) {
                    $data['errors']['general'] = 'Invalid announcement ID.';
                    return;
                }

                $payload = [
                    'title' => trim($_POST['title'] ?? ''),
                    'message' => trim($_POST['message'] ?? ''),
                    'updated_by' => Auth::user_id(),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!$announcementModel->validate($payload)) {
                    $data['errors'] = $announcementModel->errors;
                    return;
                }

                if ($announcementModel->update($announcementId, $payload)) {
                    AccessLog::log('announcement_updated', 'Updated announcement ID: ' . $announcementId);
                    $_SESSION['announcement_flash'] = 'Announcement updated successfully.';
                    redirect('announcements');
                    exit();
                }

                $data['errors']['general'] = 'Failed to update announcement.';
                return;

            case 'delete':
                $announcementId = (int) ($_POST['announcement_id'] ?? 0);
                if ($announcementId <= 0) {
                    $data['errors']['general'] = 'Invalid announcement ID.';
                    return;
                }

                if ($announcementModel->delete($announcementId)) {
                    AccessLog::log('announcement_deleted', 'Deleted announcement ID: ' . $announcementId);
                    $_SESSION['announcement_flash'] = 'Announcement deleted successfully.';
                    redirect('announcements');
                    exit();
                }

                $data['errors']['general'] = 'Failed to delete announcement.';
                return;
        }
    }
}
