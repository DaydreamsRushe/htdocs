<?php

class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $bd = "users2025";
    private $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->bd);
        
        if ($this->connection->connect_errno) {
            die('Error de connexión (' . $this->connection->connect_errno . ') ' . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function checkConnection() {
        if ($this->connection->ping()) {
            return true;
        }
        return false;
    }
}
