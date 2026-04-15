<?php

class Announcement
{
    use Model;

    protected $table = 'announcements';
    protected $allowedColumns = [
        'title',
        'message',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty(trim($data['title'] ?? ''))) {
            $this->errors['title'] = 'Title is required';
        }

        if (empty(trim($data['message'] ?? ''))) {
            $this->errors['message'] = 'Message is required';
        }

        return empty($this->errors);
    }

    public function getAllWithAuthor()
    {
        $query = "SELECT a.*, u.full_name AS author_name
                  FROM announcements a
                  LEFT JOIN users u ON u.id = a.created_by
                  ORDER BY a.created_at DESC";

        return $this->query($query, []) ?: [];
    }

    public function getById($id)
    {
        $id = (int) $id;
        if ($id <= 0) {
            return false;
        }

        $query = "SELECT * FROM announcements WHERE id = :id LIMIT 1";
        $rows = $this->query($query, ['id' => $id]);

        return !empty($rows) ? $rows[0] : false;
    }
}
