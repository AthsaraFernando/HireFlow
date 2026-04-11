<?php

class SystemStats
{
    use Model;

    public function getDatabaseSize($databaseName)
    {
        $query = "
            SELECT SUM(data_length + index_length) AS size
            FROM information_schema.tables
            WHERE table_schema = ?
        ";

        $result = $this->query($query, [$databaseName]);
        return $result ? (int) $result[0]['size'] : 0;
    }

    public function formatBytes($bytes)
    {
        if ($bytes <= 0)
            return '0 B';

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = floor(log($bytes, 1024));
        return round($bytes / (1024 ** $power), 2) . ' ' . $units[$power];
    }
}
