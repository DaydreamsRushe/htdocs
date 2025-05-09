<?php
require_once 'models/Connection.php';
require_once 'models/Usuario.php';

class UsuarioController {
    private $db;
    private $usuario;

    public function __construct() {
        $connection = new Connection();
        $this->db = $connection->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    private function validarNombre($nombre){
      $regex = '/^[a-zA-ZÀ-ýñÑçÇ\s]{5,30}$/u';
      return preg_match($regex, $nombre);
    }

    private function validarUsuario($usuario){
      $regex = '/^[a-zA-Z0-9]{5,8}$/';
      return preg_match($regex, $usuario);
    }


    private function validarPaswword($password){
      $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#*])[a-zA-Z\d!@#*]{6,10}$/';
      return preg_match($regex, $password);
    }

    //metodo para contar editores
    private function contarEditores(){
      $query = "SELECT COUNT(*) as total FROM datos_usuarios WHERE tipo_usuario = 1";
      $stmt =$this->db->prepare($query);
      $stmt->execute();
      $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
      return $resultado['total'];
    }

    //metodo para validar limite de editores
  private function validarLimiteEditores($nuevoTipo, $idActual = null) {
    if ($nuevoTipo == 1) {
        $editoresActuales = $this->contarEditores();

        if ($idActual) {
            $query = "SELECT tipo_usuario FROM datos_usuarios WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $idActual);
            $stmt->execute();
            $usuarioActual = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si el usuario actual ya es editor, no contamos su cambio
            if ($usuarioActual['tipo_usuario'] == 1) {
                return true;
            }
        }

        if ($editoresActuales >= 3) {
            return false;
        }
    }
    return true;
  }


    public function index() {
      $usuarios =$this->usuario->read();
      return json_encode($usuarios);
    }

    public function create($data) {

        //Validar datos requeridos
        if(empty($data['nombre_apellidos']) || empty($data['usuario']) || empty($data['email']) || empty($data['password'])){
          return['error' => 'Todos los campos son requeridos'];
        }

        //Validar limite editores
        if(!$this->validarLimiteEditores($data['tipo_usuario'] ?? 2)){
          return ["error" => "No se pueden tener mas de 3 editores. Convierta algun editor a tipo Registrado primero"];
        }
        
        if(!$this->validarNombre($data['nombre_apellidos'])){
          return ["error" => "El nombre debe contener solo letras, espacios y caracteres latinos, entre 5 y 30 caracteres"];
        }

        if(!$this->validarUsuario($data['usuario'])){
          return ["error" => "El usuario debe contener solo letras y números, entre 5 y 8 caracteres"];
        }

        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
          return ['error' => 'El fomrato del email no es válido'];
        }
         if(!$this->validarPassword($data['password'])){
          return ['error' => 'La contraseña debe tener entre 6 y 10 caracteres, incluyendo al menos una mayuscula una minuscula, un numero y uno de estos caracteres !@#*'];
         }

      
        // Asignar valores
        $this->usuario->nombre_apellidos = $data['nombre_apellidos']; //ARREGLARLO
        $this->usuario->usuario = $data['usuario'];
        $this->usuario->email = $data['email'];
        $this->usuario->password = password_hash($data['password'], PASSWORD_DEFAULT,["cost" => 14]);
        $this->usuario->tipo_usuario = $data['tipo_usuario']; // Por defecto es usuario registrado
        $this->usuario->foto = $data['foto'] ?? null; // Asignar la foto si existe

        if($this->usuario->create()) {
            return ["mensaje" => "Usuario creado correctamente"];
        }
        return ["error" => "No se pudo crear el usuario"];
    }

    public function update($data) {
        if(empty($data['id'])) {
            return ["error" => "ID es requerido"];
        }

        
        if(!$this->validarLimiteEditores($data['tipo_usuario'] ?? 2, $data['id'])){
          return ["error" => "No se pueden tener mas de 3 editores. Convierta algun editor a tipo Registrado primero"];
        }

        if(!$this->validarNombre($data['nombre_apellidos'])){
          return ["error" => "El nombre debe contener solo letras, espacios y caracteres latinos, entre 5 y 30 caracteres"];
        }

        if(!$this->validarUsuario($data['usuario'])){
          return ["error" => "El usuario debe contener solo letras y números, entre 5 y 8 caracteres"];
        }

        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
          return ['error' => 'El fomrato del email no es válido'];
        }

        $this->usuario->id = $data['id'];
        $this->usuario->nombre_apellidos = $data['nombre_apellidos'];
        $this->usuario->usuario = $data['usuario'];
        $this->usuario->email = $data['email'];
        
        if(isset($data['tipo_usuario'])) {
            $this->usuario->tipo_usuario = $data['tipo_usuario'];
        }

        if($this->usuario->update()) {
            return ["mensaje" => "Usuario actualizado correctamente"];
        }
        return ["error" => "No se pudo actualizar el usuario"];
    }

    public function delete($data) {
        $this->usuario->id = $data['id'];

        if ($this->usuario->delete()) {
            return ["mensaje" => "Usuario eliminado correctamente"];
        }
        return ["error" => "No se pudo eliminar el usuario"];
    }

    public function updateFoto($id, $fotoPath) {
        $this->usuario->id = $id;
        $this->usuario->foto = $fotoPath;

        if($this->usuario->updateFoto()) {
            return ["mensaje" => "Foto actualizada correctamente"];
        }
        return ["error" => "No se pudo actualizar la foto"];
    }



    public function login($email, $password) {

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
          return ['success' => false, 'error' => 'El formato del mail no es valido'];
        }
        if(!$this->validarPaswword($password)){
          return ['success' => false, 'error' => 'El password no es valido'];
        }
        $query = "SELECT * FROM datos_usuarios WHERE email = :email AND tipo_usuario = 3 LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['adminLoggedIn'] = true;  
                 $_SESSION['adminEmail'] = $email;  
                return ['success' => true];
            }
        }
    
        return ['success' => false, 'error' => 'Credenciales incorrectas'];
    }
}
?> 