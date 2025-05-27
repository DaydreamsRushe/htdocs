<?php

/* Clase para las funciones especificas para la tabla de usuarios */
class Usuario{
    private $conn;
    private const TABLE_NAME = "usuario";
    private const DEFAULT_PHOTO = 'img/default-user.svg';

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $tipo_usuario;
    public $foto;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readProfesionals(){
      $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE tipo_usuario = 2 ORDER BY id;";
      return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Creación de un nuevo usuario a partir de los datos introducidos al crear la clase */
    public function create() {
        try {
            $next_id = $this->getNextId();
            $params = [
                ':id' => $next_id,
                ':usuario' => $this->nombre,
                ':email' => $this->email,
                ':password' => $this->password,
                ':tipo_usuario' => $this->tipo_usuario,
                ':foto' => $this->foto ?? null
            ];

            $query = "INSERT INTO " . self::TABLE_NAME . " 
                     (id, usuario, email, password, tipo_usuario, foto) 
                     VALUES (:id, :usuario, :email, :password, :tipo_usuario, :foto)";

            $stmt = $this->conn->prepare($query);
            
            if ($stmt->execute($params)) {

                try {
                  $params2 = [
                    ':id' => $next_id,
                    ':usuario' => $this->nombre,
                  ];
                  
                  /* Dependiendo del tipo de usuario que se trate, queremos añadirlo en la tabla de la subclase adecuada */
                  if ($this->tipo_usuario == 2)
                  {
                    $query2 = "INSERT INTO profesional (user_id, nombre_profesional) VALUES (:id, :usuario)";
                  }else{
                    $query2 = "INSERT INTO paciente (user_id, nombre_paciente) VALUES (:id, :usuario)";
                  }
                  
                  $stmt2 = $this->conn->prepare($query2);

                  if ($stmt2->execute($params2)) {
                    return ["mensaje" => "Usuario creado correctamente", "id" => $next_id];
                  }
                  /* SI NO SE INSERTA EN LA SEGUNDA TABLA TENEMOS QUE BORRARLA DE LA PRIMERA */
                  $query3 = "DELETE FROM " . self::TABLE_NAME . " WHERE id = :id)";
                  $stmt3 = $this->conn->prepare($query3);
                  $stmt3->execute([':id' => $next_id]);

                } catch (PDOException $e) {
                    return $e->getCode() == 23000 
                      ? ["error" => "El email ya está registrado"]
                      : ["error" => "Error en la base de datos: " . $e->getMessage()];
                }
            }
            return ["error" => "Error al crear el usuario"];
        } catch (PDOException $e) {
            return $e->getCode() == 23000 
                ? ["error" => "El email ya está registrado"]
                : ["error" => "Error en la base de datos: " . $e->getMessage()];
        }
    }

    /* Funcion para encontrar el ultimo id y devolver este +1 para creacion de nuevos usuarios */
    private function getNextId() {
        $query = "SELECT MAX(id) as last_id FROM " . self::TABLE_NAME;
        $result = $this->conn->query($query)->fetch(PDO::FETCH_ASSOC);
        return ($result['last_id'] > 0) ? $result['last_id'] + 1 : 1;
    }

}

?>