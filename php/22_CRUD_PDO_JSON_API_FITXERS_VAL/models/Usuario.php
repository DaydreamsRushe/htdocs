<?php

class Usuario {
    private $conn;
    private $table_name = "datos_usuarios";

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

    // Obtener todos los usuarios
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE tipo_usuario !=3 ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    // Crear usuario
    public function create() {
        // Primero obtener el último ID
        $query_last_id = "SELECT MAX(id) as last_id FROM " . $this->table_name;
        $stmt_last_id = $this->conn->prepare($query_last_id);
        $stmt_last_id->execute();
        $row = $stmt_last_id->fetch(PDO::FETCH_ASSOC);
        $next_id = ($row['last_id'] > 0) ? $row['last_id'] + 1 : 1;
        
        $query = "INSERT INTO " . $this->table_name . " (id, nombre_apellidos, usuario, email, password, tipo_usuario, foto) VALUES (:id, :nombre_apellidos, :usuario, :email, :password, :tipo_usuario, :foto)";

        $stmt = $this->conn->prepare($query);

        // Asegurarnos de que la foto sea null si no se proporciona
        if (empty($this->foto)) {
            $this->foto = null;
        }

        $stmt->bindParam(":id", $next_id);
        $stmt->bindParam(":nombre_apellidos", $this->nombre_apellidos);
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":tipo_usuario", $this->tipo_usuario);
        $stmt->bindParam(":foto", $this->foto);

        try {
            if($stmt->execute()) {
                return ["mensaje" => "Usuario creado correctamente", "id" => $next_id];
            }
            return ["error" => "Error al crear el usuario"];
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Error de duplicado
                return ["error" => "El email ya está registrado"];
            }
            return ["error" => "Error en la base de datos: " . $e->getMessage()];
        }
    }

    // Actualizar usuario
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                 SET nombre_apellidos = :nombre_apellidos, 
                     usuario = :usuario, 
                     email = :email";
        
        // Solo actualizar password si se proporciona uno nuevo
        if(!empty($this->password)) {
            $query .= ", password = :password";
        }
        
        // Solo actualizar tipo_usuario si se proporciona uno nuevo
        if(isset($this->tipo_usuario)) {
            $query .= ", tipo_usuario = :tipo_usuario";
        }

        // Solo actualizar foto si se proporciona una nueva
        if(isset($this->foto)) {
            $query .= ", foto = :foto";
        }
        
        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nombre_apellidos", $this->nombre_apellidos);
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->bindParam(":email", $this->email);
        
        if(!empty($this->password)) {
            $stmt->bindParam(":password", $this->password);
        }
        
        if(isset($this->tipo_usuario)) {
            $stmt->bindParam(":tipo_usuario", $this->tipo_usuario);
        }

        if(isset($this->foto)) {
            $stmt->bindParam(":foto", $this->foto);
        }

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Actualizar solo la foto
    public function updateFoto() {

         //Primero obtenemos la informacion de la foto del usuario
        $query_foto = "SELECT foto FROM " . $this->table_name . " WHERE id = :id";
        $stmt_foto = $this->conn->prepare($query_foto);
        $stmt_foto->bindParam(":id", $this->id);
        $stmt_foto->execute();
        $foto_data = $stmt_foto->fetch(PDO::FETCH_ASSOC);

        //Si el usuario tiene una foto personalizada (no es la imagen por defecto, la eliminamos)
        if($foto_data && $foto_data['foto'] !== 'img/default-user.svg'){
          $foto_path = $foto_data['foto'];
          if(file_exists($foto_path)){
            unlink($foto_path);
          }
        }

        $query = "UPDATE " . $this->table_name . " SET foto = :foto WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":foto", $this->foto);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar usuario
    public function delete() {
        //Primero obtenemos la informacion de la foto del usuario
        $query_foto = "SELECT foto FROM " . $this->table_name . " WHERE id = :id";
        $stmt_foto = $this->conn->prepare($query_foto);
        $stmt_foto->bindParam(":id", $this->id);
        $stmt_foto->execute();
        $foto_data = $stmt_foto->fetch(PDO::FETCH_ASSOC);

        //Si el usuario tiene una foto personalizada (no es la imagen por defecto, la eliminamos)
        if($foto_data && $foto_data['foto'] !== 'img/default-user.svg'){
          $foto_path = $foto_data['foto'];
          if(file_exists($foto_path)){
            unlink($foto_path);
          }
        }

        //Luego eliminamos el registro
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);      
        // Vincular el parámetro
        $stmt->bindParam(":id", $this->id);       
        $stmt->execute();

        // Luego actualizamos los IDs restantes
        $sql = "SET @count = 0";
        $this->conn->exec($sql);
        
        $sql = "UPDATE " . $this->table_name . " SET id = (@count := @count + 1) ORDER BY id";
        $this->conn->exec($sql);

        return true;
    }
}
