<?php

trait Database
{
    private function connect()
    {

        $string = "mysql:hostname=" . DB_HOST . ";dbname=" . DB_NAME;
        $con = new PDO($string, DB_USER, DB_PASS);
        return $con;
    }
    public function query($query, $data = [])
    {
        $con = $this->connect();
        $stmt = $con->prepare($query);

        // $logData = [
        //     'query' => $query,
        //     'data' => $data,
        //     'timestamp' => date('Y-m-d H:i:s')
        // ];
        // file_put_contents(
        //     __DIR__ . '/test_log.txt',             // Adjust path if needed
        //     print_r($logData, true) . "\n",         // Human-readable format
        //     FILE_APPEND                             // Don’t overwrite old logs
        // );

        $check = $stmt->execute($data);
        if ($check) {
            if (stripos(trim($query), 'select') === 0) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result ?: [];

            }
            return true;

            // Below code fails for updates because doesnt return true for updates
            // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // if (is_array($result) && count($result)) {
            //     return $result;
            // }
        }
        return false;
    }

    public function get_row($query, $data = [])
    {
        $con = $this->connect();
        $stmt = $con->prepare($query);

        $check = $stmt->execute($data);
        if ($check) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (is_array($result) && count($result)) {
                return $result[0];
            }
        }

        return false;
    }



}

