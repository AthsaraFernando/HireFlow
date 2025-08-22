<?php

trait Model
{
    use Database;
    protected $limit = 10;
    protected $offset = 0;
    protected $order_type = "asc";
    protected $order_column = 'id';
    public $errors = [];


    public function findAll()
    {

        $query = "select * from $this->table order by $this->order_column $this->order_type limit $this->limit offset $this->offset ";
        return $this->query($query);

    }
    public function where($data, $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "select * from $this->table where ";

        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . " && ";
        }
        foreach ($keys_not as $key) {
            $query .= $key . "!=:" . $key . " && ";
        }

        $query = trim($query, " && ");
        $query .= " order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);

        return $this->query($query, $data);

    }
    public function first($data, $data_not)
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "select * from $this->table where ";

        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . " && ";
        }
        foreach ($keys_not as $key) {
            $query .= $key . "!=:" . $key . " && ";
        }

        $query = trim($query, " && ");
        $query .= " limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);

        $result = $this->query($query, $data);
        if ($result) {
            return $result[0];
        }
        return false;
    }



    public function insert($data)
    {
        // Removing non-allowed data before preparing the query
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        // show($data);

        $keys = array_keys($data);
        $query = "insert into $this->table (" . implode(",", $keys) . ") values (:" . implode(",:", $keys) . ")";
        // echo $query;
        $result = $this->query($query, $data);

        return false;


    }

    public function update($id, $data, $id_column = 'id')
    {
        // Removing non-allowed data before preparing the query
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        if (empty($data)) {
            return false;
        }

        $keys = array_keys($data);
        $query = "update $this->table set ";

        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . ", ";
        }

        $query = trim($query, ", ");
        $query .= " where $id_column = :$id_column";

        // return $query;

        $data[$id_column] = $id;
        return $this->query($query, $data);
    }



    public function delete($id, $id_column = 'id')
    {
        // $data[$id_column] = $id;
        // $query = "update $this->table where $id_column = :$id_column";

        // $data = [$id_column => $id];
        $data[$id_column] = $id;
        $query = "DELETE FROM $this->table WHERE $id_column = :$id_column";
        // echo $query;

        // $logData = [
        //     'data' => $data,
        //     'timestamp' => date('Y-m-d H:i:s')
        // ];
        // file_put_contents(
        //     __DIR__ . '/test_log.txt',             // Adjust path if needed
        //     print_r($logData, true) . "\n",         // Human-readable format
        //     FILE_APPEND                             // Don’t overwrite old logs
        // );

        return $this->query($query, $data);
    }
}