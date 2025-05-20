<?php

class Usuario {
    private $conn;
    private const TABLE_NAME = "datos_usuarios";
    private const DEFAULT_PHOTO = 'img/default-user.svg';

    public $id;
    public $nombre_apellidos;
    public $usuario;
    public $email;
    public $password;
    public $tipo_usuario;
    public $foto;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE tipo_usuario != 3 ORDER BY id";
        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        try {
            $next_id = $this->getNextId();
            $params = [
                ':id' => $next_id,
                ':nombre_apellidos' => $this->nombre_apellidos,
                ':usuario' => $this->usuario,
                ':email' => $this->email,
                ':password' => $this->password,
                ':tipo_usuario' => $this->tipo_usuario,
                ':foto' => $this->foto ?? null
            ];

            $query = "INSERT INTO " . self::TABLE_NAME . " 
                     (id, nombre_apellidos, usuario, email, password, tipo_usuario, foto) 
                     VALUES (:id, :nombre_apellidos, :usuario, :email, :password, :tipo_usuario, :foto)";

            $stmt = $this->conn->prepare($query);
            
            if ($stmt->execute($params)) {
                return ["mensaje" => "Usuario creado correctamente", "id" => $next_id];
            }
            return ["error" => "Error al crear el usuario"];
        } catch (PDOException $e) {
            return $e->getCode() == 23000 
                ? ["error" => "El email ya está registrado"]
                : ["error" => "Error en la base de datos: " . $e->getMessage()];
        }
    }

    public function update() {
        try {
            $updates = [
                'nombre_apellidos = :nombre_apellidos',
                'usuario = :usuario',
                'email = :email'
            ];

            $params = [
                ':id' => $this->id,
                ':nombre_apellidos' => $this->nombre_apellidos,
                ':usuario' => $this->usuario,
                ':email' => $this->email
            ];

            if (isset($this->tipo_usuario)) {
                $updates[] = 'tipo_usuario = :tipo_usuario';
                $params[':tipo_usuario'] = $this->tipo_usuario;
            }

            if (isset($this->foto)) {
                $updates[] = 'foto = :foto';
                $params[':foto'] = $this->foto;
            }

            $query = "UPDATE " . self::TABLE_NAME . " SET " . implode(', ', $updates) . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error al actualizar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function updateFoto() {
        try {
            if (!$this->usuarioExists()) {
                return false;
            }

            $query = "UPDATE " . self::TABLE_NAME . " SET foto = :foto WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            
            return $stmt->execute([
                ':id' => $this->id,
                ':foto' => $this->foto
            ]);
        } catch (PDOException $e) {
            error_log("Error al actualizar foto: " . $e->getMessage());
            return false;
        }
    }

    public function delete() {
        try {
            $this->conn->beginTransaction();

            // Eliminar foto si existe y no es la predeterminada
            $this->deleteUserPhoto();

            // Eliminar usuario
            $query = "DELETE FROM " . self::TABLE_NAME . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':id' => $this->id]);

            // Reordenar IDs
            $this->reorderIds();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error al eliminar usuario: " . $e->getMessage());
            return false;
        }
    }

    private function getNextId() {
        $query = "SELECT MAX(id) as last_id FROM " . self::TABLE_NAME;
        $result = $this->conn->query($query)->fetch(PDO::FETCH_ASSOC);
        return ($result['last_id'] > 0) ? $result['last_id'] + 1 : 1;
    }

    private function usuarioExists() {
        $query = "SELECT id FROM " . self::TABLE_NAME . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $this->id]);
        return $stmt->rowCount() > 0;
    }

    private function deleteUserPhoto() {
        $query = "SELECT foto FROM " . self::TABLE_NAME . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $this->id]);
        $foto_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($foto_data && $foto_data['foto'] && $foto_data['foto'] !== self::DEFAULT_PHOTO) {
            $foto_path = $foto_data['foto'];
            if (file_exists($foto_path)) {
                unlink($foto_path);
            }
        }
    }

    private function reorderIds() {
        $this->conn->exec("SET @count = 0");
        $this->conn->exec("UPDATE " . self::TABLE_NAME . " SET id = (@count := @count + 1) ORDER BY id");
    }
}
