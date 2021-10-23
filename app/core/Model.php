<?php

namespace App\Core;

use App\Database\DatabaseConnector;

class Model
{
    public $conn;
    protected $table;

    public function __construct($table, $db = null)
    {
        $this->table = $table;
        if (is_null($db)) {
            $db = new DatabaseConnector();
            $this->conn = $db->getConn();
        } else {
            $this->conn = $db;
        }
    }

    public function closeConn()
    {

        $this->conn = null;
    }

    public function getData($data)
    {
        $array = array();
        foreach ($data as $row) {
            array_push($array, $row);
        }

        return $array;
    }

    public function getFirstData($data)
    {
        $array = $this->getData($data);

        return $array[0];
    }

}
