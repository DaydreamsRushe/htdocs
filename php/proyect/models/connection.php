<?php

require_once 'config/config.php';
/* Clase con funciones para conectarnos a la base de datos y así poder hacer peticiones a partir de PDO */
class Connection {
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,DB_USER,DB_PASS
            );
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
}
