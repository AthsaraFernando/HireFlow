<?php

class Notification
{
    use Model;
    protected $table = 'notifications';
    protected $allowedColumns = [
        'user_id',
        'title',
        'message',
        'type'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['user_id'])) {
            $this->errors['user_id'] = "User ID is required";
        }

        if (empty($data['title'])) {
            $this->errors['title'] = "Notification title is required";
        }

        if (empty($data['message'])) {
            $this->errors['message'] = "Notification message is required";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getUserNotifications($user_id, $limit = 10)
    {
        $query = "SELECT * FROM notifications 
                  WHERE user_id = ? 
                  ORDER BY created_at DESC 
                  LIMIT ?";
        
        return $this->query($query, [$user_id, $limit]);
    }

    public function markAsRead($notification_id)
    {
        $query = "UPDATE notifications 
                  SET is_read = 1, read_at = NOW() 
                  WHERE id = ?";
        
        return $this->query($query, [$notification_id]);
    }

    public function getUnreadCount($user_id)
    {
        $query = "SELECT COUNT(*) as count FROM notifications 
                  WHERE user_id = ? AND is_read = 0";
        
        $result = $this->query($query, [$user_id]);
        return $result[0]->count ?? 0;
    }
}
