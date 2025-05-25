<?php
  require_once 'models/connection.php';
  require_once 'models/profesional.php';
  require_once 'models/especialidad.php';
  require_once 'models/usuario.php';

  class ProfessionalController {
    private $db;
    private $usuario;
    private $especialidad;
    private const REGEX = ['nombre' => '/^[a-zA-ZÀ-ÿñÑçÇ\s]{5,30}$/u',
        'usuario' => '/^[a-zA-Z0-9]{5,8}$/',
        'password' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#*])[a-zA-Z\d!@#*]{6,10}$/'
    ];
    public function __construct(){
      $connection = new Connection();
      $this->db = $connection->getConnection();
      $this->usuario = new Usuario($this->db);
      $this->especialidad = new Especialidad($this->db);
    }
    
    public function index() {
  
      $datos_profesional = $this->usuario->readProfesionals();
      $datos = [];
      foreach ($datos_profesional as $profesional) {
        $d = ["id" => $profesional["id"], "nombre" => $profesional["usuario"], "email" => $profesional["email"] , "foto" => $profesional["foto"], "especialidades" => []];
        $e = [];
        foreach ($this->especialidad->read($d["id"]) as $especial) {
          array_push($e, $especial["especialidad"]);
        }
        $d["especialidades"] = $e; 
        array_push($datos, $d);
      };
      return json_encode($datos);
    }


    private function validarCampo($valor, $tipo) {
        return preg_match(self::REGEX[$tipo], $valor);
    }

    private function validarEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


    public function login($email, $password) {
        if (!$this->validarEmail($email)) {
            return ['success' => false, 'error' => 'El formato del email no es válido'];
        }

        if (!$this->validarCampo($password, 'password')) {
            return ['success' => false, 'error' => 'La contraseña debe tener entre 6 y 10 caracteres, incluyendo al menos una mayúscula, una minúscula, un número y uno de estos caracteres: !@#*'];
        }

        $query = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
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
                    'nombre' => $user['usuario']
                ];

                return [
                    'success' => true,
                    'user' => [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'tipo_usuario' => $user['tipo_usuario'],
                        'nombre' => $user['usuario']
                    ]
                ];
            }
        }
        return ['success' => false, 'error' => 'Credenciales incorrectas'];
    }


  }
?>