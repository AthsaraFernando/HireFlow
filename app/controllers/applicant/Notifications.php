<?php

/**
 * Notifications Controller
 * Handles applicant notifications
 */
class Notifications extends Controller
{
    use ApplicantBaseTrait;

    private function sendJson(array $payload)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload);
    }

    private function handleMarkRead($user_id)
    {
        $notification_id = (int)($_POST['notification_id'] ?? 0);
        if ($notification_id <= 0) {
            $this->sendJson(['success' => false, 'message' => 'Invalid notification id']);
            return;
        }

        $notificationModel = new Notification();
        $ok = $notificationModel->markAsReadForUser($notification_id, $user_id);
        $unreadCount = (int)$notificationModel->getUnreadCount($user_id);

        $this->sendJson([
            'success' => $ok !== false,
            'unread_count' => $unreadCount
        ]);
    }

    private function handleDelete($user_id)
    {
        $notification_id = (int)($_POST['notification_id'] ?? 0);
        if ($notification_id <= 0) {
            $this->sendJson(['success' => false, 'message' => 'Invalid notification id']);
            return;
        }

        $notificationModel = new Notification();
        $ok = $notificationModel->deleteForUser($notification_id, $user_id);
        $unreadCount = (int)$notificationModel->getUnreadCount($user_id);

        $this->sendJson([
            'success' => $ok !== false,
            'unread_count' => $unreadCount
        ]);
    }

    private function handleFeed($user_id)
    {
        $notificationModel = new Notification();
        $notifications = $this->buildApplicantNotificationFeed($user_id, 50);

        $this->sendJson([
            'success' => true,
            'count' => count($notifications),
            'unread_count' => (int)$notificationModel->getUnreadCount($user_id),
            'notifications' => $notifications
        ]);
    }

    public function index()
    {
        Auth::requireRole(4);
        
        $notificationModel = new Notification();
        $user_id = Auth::user_id();
        $notifications = $this->buildApplicantNotificationFeed($user_id, 50);

        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'mark-read' && isset($_POST['notification_id'])) {
                $this->handleMarkRead($user_id);
                return;
            }

            if ($_POST['action'] === 'delete' && isset($_POST['notification_id'])) {
                $this->handleDelete($user_id);
                return;
            }

            if ($_POST['action'] === 'feed') {
                $this->handleFeed($user_id);
                return;
            }
        }
        
        $data = [];
        $data['user'] = $this->getUserData($user_id);
        $data['notifications'] = $notifications;
        $data['unread_count'] = (int)$notificationModel->getUnreadCount($user_id);
        $data['total_count'] = count($notifications);

        $this->view('applicant/notifications', $data);
    }

    public function feed()
    {
        Auth::requireRole(4);
        $this->handleFeed(Auth::user_id());
    }

    public function markRead()
    {
        Auth::requireRole(4);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJson(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $this->handleMarkRead(Auth::user_id());
    }

    public function delete()
    {
        Auth::requireRole(4);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJson(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $this->handleDelete(Auth::user_id());
    }
}
