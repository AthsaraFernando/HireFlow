<?php

class JobpostingModel
{
    use Model;
    
    protected $table = 'job_postings';
    protected $allowedColumns = ['title', 'company', 'location', 'salary', 'department', 'deadline', 'description', 'status'];

    public function getStats()
    {
        $total = $this->query("SELECT COUNT(*) as count FROM {$this->table}")[0]['count'] ?? 0;
        $active = $this->query("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'Open'")[0]['count'] ?? 0;
        $thisWeek = $this->query("SELECT COUNT(*) as count FROM {$this->table} WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")[0]['count'] ?? 0;
        $pending = $this->query("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'Draft'")[0]['count'] ?? 0;

        return [
            'total' => $total,
            'active' => $active,
            'thisWeek' => $thisWeek,
            'pending' => $pending
        ];
    }

    public function getJobPostings($limit = null, $offset = 0, $status = null)
    {
        $query = "SELECT * FROM {$this->table}";
        $params = [];
        
        if ($status) {
            $query .= " WHERE status = :status";
            $params['status'] = $status;
        }
        
        $query .= " ORDER BY created_at DESC";
        
        if ($limit) {
            $query .= " LIMIT :limit OFFSET :offset";
            $params['limit'] = $limit;
            $params['offset'] = $offset;
        }
        
        return $this->query($query, $params);
    }
}
?>
