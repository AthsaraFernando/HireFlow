<?php

trait Database
{
    private function connect()
    {
        $string = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
        return new PDO($string, DB_USER, DB_PASS);
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

