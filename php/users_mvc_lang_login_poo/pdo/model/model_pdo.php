<?php
require_once "connect_pdo.php";

class UserPDO {
    private $db;

    public function __construct() {
        $conexion = new DatabasePDO(); //creamos una nueva instancia de la clase DatabasePDO
        $this->db = $conexion->getConnection(); //obtenemos la conexión a la base de datos
    }

    public function login($usuario, $password) {
        if (empty($usuario) || empty($password)) {  //si el usuario o la contraseña estan vacios, devolvemos false y null
            return [false, null];
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios2 WHERE usuario = :usuario"); //preparamos la consulta para evitar SQLInjection
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR); //bindParam para evitar la eposición de los parámetros
            $stmt->execute();//ejecutamos la consulta
            $user_data = $stmt->fetch();//obtenemos los datos del usuario
            
            if ($user_data && password_verify($password, $user_data['password'])) {//verificamos si el usuario existe y la contraseña es correcta   
                return [true, $user_data];//si es correcto, devolvemos true y los datos del usuario
            }
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());//si hay un error, lo registramos  
        }
        
        return [false, null];//si hay un error, devolvemos false y null en datos del usuario
    }

    public function register($usuario, $email, $password) {
        if (empty($usuario) || empty($email) || empty($password)) {//si el usuario, el email o la contraseña estan vacios, devolvemos null y false
            return [null, false];
        }

        try {
            // Verificar si existe usuario o email
            $stmt = $this->db->prepare("SELECT * FROM usuarios2 WHERE usuario = :usuario OR email = :email");//preparamos la consulta para evitar SQLInjection
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);//bindParam para evitar la eposición de los parámetros
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);//bindParam para evitar la eposición de los parámetros
            $stmt->execute();//ejecutamos la consulta
              if ($stmt->rowCount() > 0) {
                return [null, false];
            }

            // Verificar si la contraseña ya existe
            $stmt = $this->db->prepare("SELECT password FROM usuarios2");//preparamos la consulta para evitar SQLInjection
            $stmt->execute();//ejecutamos la consulta
            while ($row = $stmt->fetch()) {//mientras haya filas, comprobamos si la contraseña ya existe
                if (password_verify($password, $row['password'])) {//si la contraseña ya existe, devolvemos null y false
                    return [null, false];
                }
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);//hasheamos la contraseña
            $stmt = $this->db->prepare("INSERT INTO usuarios2 VALUES (NULL, :usuario, :email, :password)");//preparamos la consulta para evitar SQLInjection
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);//bindParam para evitar la eposición de los parámetros
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);//bindParam para evitar la eposición de los parámetros
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);//bindParam para evitar la eposición de los parámetros
            $result = $stmt->execute();//ejecutamos la consulta
            
            if ($result) {//si la consulta se ha ejecutado correctamente, devolvemos los datos del usuario y true
                $stmt = $this->db->prepare("SELECT * FROM usuarios2");//preparamos la consulta para evitar SQLInjection
                $stmt->execute();//ejecutamos la consulta
                $myrows = $stmt->fetchAll();//obtenemos los datos del usuario
                return [$myrows, true];//devolvemos los datos del usuario y true
            }
        } catch (PDOException $e) {
            error_log("Error en registro: " . $e->getMessage());//si hay un error, lo registramos  
        }
        
        return [null, false];//si hay un error, devolvemos null y false
    }

    public function getUserById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios2 WHERE id = :id"); //preparamos la consulta para evitar SQLInjection 
            $stmt->execute(['id' => $id]);//ejecutamos la consulta
            return $stmt->fetch();//devolvemos los datos del usuario
        } catch (PDOException $e) {
            error_log("Error al obtener usuario: " . $e->getMessage());//si hay un error, lo registramos  
            return null;//si hay un error, devolvemos null
        }
    }

    // Métodos de prueba
    public function testConnection() {
        try {
            $this->db->query('SELECT 1');
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function testTableExists() {
        try {
            $stmt = $this->db->query("SHOW TABLES LIKE 'usuarios2'");
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function testUserExists($usuario) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios2 WHERE usuario = :usuario");
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
} 