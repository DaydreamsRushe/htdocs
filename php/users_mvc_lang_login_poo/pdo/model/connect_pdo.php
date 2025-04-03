<?php

class DatabasePDO {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $bd = "users2025";
    private $connection;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->bd};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->connection = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function checkConnection() {
        try {
            $this->connection->query('SELECT 1');
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
} 