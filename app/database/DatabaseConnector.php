<?php

namespace App\Database;

use PDO;
use PDOException;

class DatabaseConnector
{
    private $driver;
    private $host;
    private $user;
    private $pass;
    private $dbName;
    private $charset;
    private $conn;

    public function __construct()
    {
        $this->driver = $_ENV['DB_CONNECTION'];
        $this->host = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USERNAME'];
        $this->pass = $_ENV['DB_PASSWORD'];
        $this->dbName = $_ENV['DB_DATABASE'];
        $this->charset = "utf8";
        $this->options = [
            PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, //make the default fetch be an associative array
        ];

        $this->conn = $this->conexion();
    }

    protected function conexion()
    {
        try {
            $pdo = new PDO("{$this->driver}:host={$this->host};dbname={$this->dbName};charset={$this->charset}", $this->user, $this->pass, $this->options);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getConn()
    {
        return $this->conn;
    }
}
   




    //     namespace Api\Database;

    // use Exception;
    // use mysqli;

    // class DatabaseConnector
    // {

    // private $dbConnection = null;

    // public function __construct()
    // {

    //     $this->dbConnection  = new mysqli(
    //         $_ENV['DB_HOST'],
    //         $_ENV['DB_USERNAME'],
    //         $_ENV['DB_PASSWORD'],
    //         $_ENV['DB_DATABASE'],
    //         $_ENV['DB_PORT']
    //     );

    //     if ($this->dbConnection->connect_error) {
    //         die("Connection failed: " . $this->dbConnection->connect_error);
    //         throw new Exception("DDBB_Err");
    //     }

    //     $this->dbConnection->set_charset("utf8mb4");
    //     //$this->mysqli->query("SET SESSION sql_mode = '';");
    // }

    // public function getDB()
    // {
    //     return $this->dbConnection;
    // }

    // public function closeDB()
    // {
    //     $this->dbConnection->close();
    // }

    // public function getCharset()
    // {
    //     return $this->dbConnection->character_set_name();
    // }
// }
