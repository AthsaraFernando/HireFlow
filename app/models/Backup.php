<?php

class Backup
{
    use Model;
    protected $table = 'db_backups';
    protected $allowedColumns = [
        'backup_name',
        'file_path',
        'file_size',
        'status',
        'created_at',
        'restored_at',
    ];


    public static function log($backupName, $backupPath, $fileSize, $status = 'success')
    {
        $backup = new self();

        $data = [
            'backup_name' => $backupName,
            'file_path' => $backupPath,
            'file_size' => $fileSize,
            'status' => $status ?? 'unknown',
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $backup->insert($data);
    }


    public function fetchLogs()
    {
        $result = $this->query("SELECT * FROM {$this->table}");
        return $result ?: [];
    }

    public function markAsRestored($id)
    {
        $query = "UPDATE {$this->table} SET restored_at = NOW() where id = '$id'";
        return $this->query($query);
    }

    public function backupFrequency()
    {
        $query = "SELECT DATE_FORMAT(created_at, '%b %Y') AS instance, COUNT(*) AS monthly_backup_count
                  FROM db_backups
                  GROUP BY instance
                  ORDER BY MIN(created_at)";

        $result = $this->query($query);
        return $result ?: [];


    }

    public function restoreFrequency()
    {
        $query = "SELECT DATE_FORMAT(created_at, '%b %Y') AS instance, COUNT(*) AS monthly_restore_count
                  FROM db_backups
                  WHERE restored_at IS NOT NULL
                  GROUP BY instance
                  ORDER BY MIN(created_at)";

        $result = $this->query($query);
        return $result ?: [];


    }



}
