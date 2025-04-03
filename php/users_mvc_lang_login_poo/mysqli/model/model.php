<?php
require_once "connect.php";

class User {
    private $db;

    public function __construct() {
        $conexion = new Database();
        $this->db = $conexion->getConnection();
    }

    public function login($usuario, $password) {
        if (empty($usuario) || empty($password)) {
            return [false, null];
        }

        $selectQuery = "SELECT * FROM usuarios2 WHERE usuario='$usuario'";
        $result = $this->db->query($selectQuery);
        
        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            if (password_verify($password, $user_data['password'])) {
                return [true, $user_data];
            }
        }
        
        return [false, null];
    }

    public function register($usuario, $email, $password) {
        if (empty($usuario) || empty($email) || empty($password)) {
            return [null, false];
        }

        $myrows = [];

        // Verificar si existe usuario o email
        $selectQuery = "SELECT * FROM usuarios2 WHERE usuario='$usuario' OR email='$email'";
        $result = $this->db->query($selectQuery);
        if ($result->num_rows > 0) {
            return [null, false];
        }

        // Verificar si la contraseña ya existe
        $selectPasswordQuery = "SELECT password FROM usuarios2";
        $result = $this->db->query($selectPasswordQuery);
        while ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                return [null, false];
            }
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        $insertQuery = "INSERT INTO usuarios2 VALUES (NULL,'$usuario','$email','$hashed_password')";
        $result = $this->db->query($insertQuery);
        
        if ($result) {
            $selectallQuery = "SELECT * FROM usuarios2";
            $result = $this->db->query($selectallQuery);
            while ($row = $result->fetch_assoc()) {
                $myrows[] = $row;
            }
            return [$myrows, true];
        } else {
            return [null, false];
        }
    }

    public function getUserById($id) {
        $selectQuery = "SELECT * FROM usuarios2 WHERE id='$id'";
        $result = $this->db->query($selectQuery);
        return $result->fetch_assoc();
    }

    // Métodos de prueba
    /* public function testConnection() {
        return $this->db->ping();
    }

    public function testTableExists() {
        $result = $this->db->query("SHOW TABLES LIKE 'usuarios2'");
        return $result->num_rows > 0;
    }

    public function testUserExists($usuario) {
        $selectQuery = "SELECT * FROM usuarios2 WHERE usuario='$usuario'";
        $result = $this->db->query($selectQuery);
        return $result->num_rows > 0;
    } */
}
