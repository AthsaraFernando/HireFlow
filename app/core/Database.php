<?php

trait Database
{
    private function connect()
    {
        $connection_attempts = [
            ['host' => DB_HOST, 'port' => 8889, 'user' => DB_USER, 'pass' => 'root'],
            ['host' => DB_HOST, 'port' => 8889, 'user' => DB_USER, 'pass' => ''],
            ['host' => DB_HOST, 'port' => 3306, 'user' => DB_USER, 'pass' => ''],
            ['host' => DB_HOST, 'port' => 3306, 'user' => DB_USER, 'pass' => 'root'],
        ];

        $lastException = null;

        foreach ($connection_attempts as $attempt) {
            try {
                $string = 'mysql:host=' . $attempt['host'] . ';port=' . $attempt['port'] . ';dbname=' . DB_NAME;
                return new PDO($string, $attempt['user'], $attempt['pass']);
            } catch (PDOException $exception) {
                $lastException = $exception;
            }
        }

        throw $lastException ?: new PDOException('Unable to connect to the database.');
    }
    public function query($query, $data = [])
    {
        $con = $this->connect();
        $stmt = $con->prepare($query);

        $check = $stmt->execute($data);
        if ($check) {
            if (stripos(trim($query), 'select') === 0) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result ?: [];

            }
            return true;
            // if ($check) {
            //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //     if (is_array($result) && count($result)) {
            //         return $result;
            //     }
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

