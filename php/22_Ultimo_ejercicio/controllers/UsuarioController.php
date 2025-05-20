<?php
require_once 'models/Connection.php';
require_once 'models/Usuario.php';

class UsuarioController {
    private $db;
    private $usuario;
    private const REGEX = [
        'nombre' => '/^[a-zA-ZÀ-ÿñÑçÇ\s]{5,30}$/u',
        'usuario' => '/^[a-zA-Z0-9]{5,8}$/',
        'password' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#*])[a-zA-Z\d!@#*]{6,10}$/'
    ];
    private const MAX_EDITORES = 3;

    public function __construct() {
        $connection = new Connection();
        $this->db = $connection->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    // Métodos de validación
    private function validarCampo($valor, $tipo) {
        return preg_match(self::REGEX[$tipo], $valor);
    }

    private function validarEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function contarEditores() {
        $query = "SELECT COUNT(*) as total FROM datos_usuarios WHERE tipo_usuario = 1";
        return $this->db->query($query)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    private function validarLimiteEditores($nuevoTipo, $idActual = null) {
        if ($nuevoTipo != 1) return true;
        
        $editoresActuales = $this->contarEditores();
        
        if ($idActual) {
            $query = "SELECT tipo_usuario FROM datos_usuarios WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $idActual]);
            $usuarioActual = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuarioActual['tipo_usuario'] == 1) return true;
        }
        
        return $editoresActuales < self::MAX_EDITORES;
    }

    private function validarDatosUsuario($data, $esActualizacion = false) {
        $errores = [];

        if (!$esActualizacion && empty($data['password'])) {
            $errores[] = "La contraseña es requerida";
        }

        if (empty($data['nombre_apellidos']) || !$this->validarCampo($data['nombre_apellidos'], 'nombre')) {
            $errores[] = "El nombre debe contener solo letras, espacios y caracteres latinos, entre 5 y 30 caracteres";
        }

        if (empty($data['usuario']) || !$this->validarCampo($data['usuario'], 'usuario')) {
            $errores[] = "El usuario debe contener solo letras y números, entre 5 y 8 caracteres";
        }

        if (empty($data['email']) || !$this->validarEmail($data['email'])) {
            $errores[] = "El formato del email no es válido";
        }

        if (!$esActualizacion && !$this->validarCampo($data['password'], 'password')) {
            $errores[] = "La contraseña debe tener entre 6 y 10 caracteres, incluyendo al menos una mayúscula, una minúscula, un número y uno de estos caracteres: !@#*";
        }

        return $errores;
    }

    // Métodos públicos
    public function index() {
        return json_encode($this->usuario->read());
    }

    public function create($data) {
        $errores = $this->validarDatosUsuario($data);
        
        if (!empty($errores)) {
            return ["error" => $errores[0]];
        }

        if (!$this->validarLimiteEditores($data['tipo_usuario'] ?? 2)) {
            return ["error" => "No se pueden tener más de " . self::MAX_EDITORES . " editores. Convierta algún editor a tipo Registrado primero."];
        }

        $this->usuario->nombre_apellidos = $data['nombre_apellidos'];
        $this->usuario->usuario = $data['usuario'];
        $this->usuario->email = $data['email'];
        $this->usuario->password = password_hash($data['password'], PASSWORD_DEFAULT, ['cost' => 14]);
        $this->usuario->tipo_usuario = $data['tipo_usuario'] ?? 2;
        $this->usuario->foto = $data['foto'] ?? null;

        return $this->usuario->create() 
            ? ["mensaje" => "Usuario creado correctamente"]
            : ["error" => "No se pudo crear el usuario"];
    }

    public function update($data) {
        if (empty($data['id'])) {
            return ["error" => "ID es requerido"];
        }

        $errores = $this->validarDatosUsuario($data, true);
        
        if (!empty($errores)) {
            return ["error" => $errores[0]];
        }

        // Verificar si el usuario existe
        $query = "SELECT tipo_usuario FROM datos_usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $data['id']]);
        $usuarioActual = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuarioActual) {
            return ["error" => "Usuario no encontrado"];
        }

        if (isset($data['tipo_usuario']) && !$this->validarLimiteEditores($data['tipo_usuario'], $data['id'])) {
            return ["error" => "No se pueden tener más de " . self::MAX_EDITORES . " editores. Convierta algún editor a tipo Registrado primero."];
        }

        $this->usuario->id = $data['id'];
        $this->usuario->nombre_apellidos = $data['nombre_apellidos'];
        $this->usuario->usuario = $data['usuario'];
        $this->usuario->email = $data['email'];
        
        if (isset($data['tipo_usuario'])) {
            $this->usuario->tipo_usuario = $data['tipo_usuario'];
        }

        return $this->usuario->update()
            ? ["mensaje" => "Usuario actualizado correctamente"]
            : ["error" => "No se pudo actualizar el usuario"];
    }

    public function delete($data) {
        $this->usuario->id = $data['id'];
        return $this->usuario->delete()
            ? ["mensaje" => "Usuario eliminado correctamente"]
            : ["error" => "No se pudo eliminar el usuario"];
    }

    public function updateFoto($id, $fotoPath) {
        $this->usuario->id = $id;
        $this->usuario->foto = $fotoPath;

        return $this->usuario->updateFoto()
            ? ['success' => true, 'mensaje' => 'Foto actualizada correctamente']
            : ['success' => false, 'error' => 'No se pudo actualizar la foto'];
    }

    public function login($email, $password) {
        if (!$this->validarEmail($email)) {
            return ['success' => false, 'error' => 'El formato del email no es válido'];
        }

        if (!$this->validarCampo($password, 'password')) {
            return ['success' => false, 'error' => 'La contraseña debe tener entre 6 y 10 caracteres, incluyendo al menos una mayúscula, una minúscula, un número y uno de estos caracteres: !@#*'];
        }

        $query = "SELECT * FROM datos_usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':email' => $email]);

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                $_SESSION['userData'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'tipo_usuario' => $user['tipo_usuario'],
                    'nombre' => $user['nombre_apellidos']
                ];

                return [
                    'success' => true,
                    'user' => [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'tipo_usuario' => $user['tipo_usuario'],
                        'nombre_apellidos' => $user['nombre_apellidos'],
                        'usuario' => $user['usuario']
                    ]
                ];
            }
        }
        return ['success' => false, 'error' => 'Credenciales incorrectas'];
    }

    public function updateProfile($data) {
        $query = "SELECT * FROM datos_usuarios WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $data['id']]);

        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'error' => 'Usuario no encontrado'];
        }

        $query = "UPDATE datos_usuarios SET nombre_apellidos = :nombre, email = :email, usuario = :usuario";
        $params = [
            ':nombre' => $data['nombre_apellidos'],
            ':email' => $data['email'],
            ':usuario' => $data['usuario'],
            ':id' => $data['id']
        ];

        if (isset($data['foto'])) {
            $query .= ", foto = :foto";
            $params[':foto'] = $data['foto'];
        }

        $query .= " WHERE id = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute($params)
            ? ['success' => true, 'mensaje' => 'Perfil actualizado correctamente']
            : ['success' => false, 'error' => 'No se pudo actualizar el perfil'];
    }

    public function changePassword($id, $currentPassword, $newPassword) {
        if (!$this->validarCampo($newPassword, 'password')) {
            return ['success' => false, 'error' => 'La nueva contraseña debe tener entre 6 y 10 caracteres, incluyendo al menos una mayúscula, una minúscula, un número y uno de estos caracteres: !@#*'];
        }

        $query = "SELECT password FROM datos_usuarios WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return ['success' => false, 'error' => 'La contraseña actual es incorrecta'];
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT, ['cost' => 14]);
        $query = "UPDATE datos_usuarios SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([':password' => $hashedPassword, ':id' => $id])
            ? ['success' => true, 'mensaje' => 'Contraseña actualizada correctamente']
            : ['success' => false, 'error' => 'No se pudo actualizar la contraseña'];
    }

    public function handleFileUpload($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($file['type'], $allowedTypes)) {
            return ['error' => 'Tipo de archivo no permitido. Use JPEG, PNG o GIF'];
        }

        if ($file['size'] > $maxSize) {
            return ['error' => 'El archivo es demasiado grande. Máximo 2MB'];
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid() . '.' . $extension;
        $target_file = 'pictures/' . $newFileName;

        return move_uploaded_file($file['tmp_name'], $target_file)
            ? "pictures/" . basename($target_file)
            : ['error' => 'Error al subir el archivo'];
    }
}
?> 