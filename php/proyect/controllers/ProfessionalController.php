<?php
  require_once 'models/connection.php';
  require_once 'models/profesional.php';
  require_once 'models/especialidad.php';
  require_once 'models/usuario.php';

  /* Esta clase controlara todas las peticiones que se dirijan a la base de datos, además de validaciones de los campos de formularios */
  class ProfessionalController {
    private $db;
    private $usuario;
    private $especialidad;
    /* Definicion de patrones para validaciones */
    private const REGEX = ['nombre' => '/^[a-zA-ZÀ-ÿñÑçÇ\s]{5,30}$/u',
        'usuario' => '/^[a-zA-Z0-9]{5,8}$/',
        'password' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#*])[a-zA-Z\d!@#*]{6,10}$/'
    ];

    /* Constructor de la clase, donde tambien recojemos la conexión a la base de datos, asi como clases de modelos para funciones especificas */
    public function __construct(){
      $connection = new Connection();
      $this->db = $connection->getConnection();
      $this->usuario = new Usuario($this->db);
      $this->especialidad = new Especialidad($this->db);
    }
    
    /* Validacion de campos a partir de un patron REGEX*/
    private function validarCampo($valor, $tipo) {
        return preg_match(self::REGEX[$tipo], $valor);
    }
    /* Validacion de emails */
    private function validarEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /* Funcion generica que confirma que los campos tienen el formato deseado y que no estan vacios, en caso contrario, retorna un mensaje de error */
    private function validarDatosUsuario($data, $esActualizacion = false) {
        $errores = [];

        if (!$esActualizacion && empty($data['password'])) {
            $errores[] = "La contraseña es requerida";
        }

        if (empty($data['nombre']) || !$this->validarCampo($data['nombre'], 'nombre')) {
            $errores[] = "El nombre debe contener solo letras, espacios y caracteres latinos, entre 5 y 30 caracteres";
        }

        if (empty($data['email']) || !$this->validarEmail($data['email'])) {
            $errores[] = "El formato del email no es válido";
        }

        if (!$esActualizacion && !$this->validarCampo($data['password'], 'password')) {
            $errores[] = "La contraseña debe tener entre 6 y 10 caracteres, incluyendo al menos una mayúscula, una minúscula, un número y uno de estos caracteres: !@#*";
        }

        return $errores;
    }

    /* Funcion para crear nuevos usuarios */
    public function create($data) {
        $errores = $this->validarDatosUsuario($data);
        
        if (!empty($errores)) {
            return ["error" => $errores[0]];
        }

        $this->usuario->nombre = $data['nombre'];
        $this->usuario->email = $data['email'];
        $this->usuario->password = password_hash($data['password'], PASSWORD_DEFAULT, ['cost' => 14]);
        $this->usuario->tipo_usuario = $data['tipo_usuario'] ?? 1;
        $this->usuario->foto = $data['foto'] ?? null;

        return $this->usuario->create();
            /* ? ["mensaje" => "Usuario creado correctamente"]
            : ["error" => "No se pudo crear el usuario"] */
    }

    /* Funcion que devuelve los datos de todos los profesionales almacenados en la base de datos, cada uno con sus especialidades  */
    public function index() {
  
      $datos_profesional = $this->usuario->readProfesionals();
      $datos = [];
      /* Por cada profesional, buscamos sus especialidades y se las añadimos como un array */
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

    /* Esta funcion devuelve todos los pacientes que esten asignados a un profesional con id "$id" junto con los diagnosticos a los que este va ligado*/
    public function clients($id){
        $query = "SELECT * FROM paciente p JOIN diagnostico d ON p.id_diagnostico = d.id_diagnostico WHERE user_id in (SELECT id_paciente FROM asignacion WHERE id_profesional = :id)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($clients);
    }

    /* Funcion de validación para login de qualquier usuario */
    public function login($email, $password) {
        /* Validamos los formatos tanto de mail como de password */
        if (!$this->validarEmail($email)) {
            return ['success' => false, 'error' => 'El formato del email no es válido'];
        }

        if (!$this->validarCampo($password, 'password')) {
            return ['success' => false, 'error' => 'La contraseña debe tener entre 6 y 10 caracteres, incluyendo al menos una mayúscula, una minúscula, un número y uno de estos caracteres: !@#*'];
        }
        
        /* Buscamos el primer usuario el email del cual conincida con el indicado en el formulario de login */
        $query = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':email' => $email]);

        /* Si tenemos un resultado, confimamos que el password es correcto (usamos password_verify para comparar con la contraseña almacenada, la cual hemos protegido con hash previamente) */
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
                    'nombre' => $user['usuario'],
                    'foto' => $user['foto']
                ];
                /* Si el usuario y contraseña son correctos, retornamos los datos del usuario mas un dato para indicar exito en el login */
                return [
                    'success' => true,
                    'user' => [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'tipo_usuario' => $user['tipo_usuario'],
                        'nombre' => $user['usuario'],
                        'foto' => $user['foto']
                    ]
                ];
            }
        }
        /* Si el email y password no coinciden con ningun registro, mandamos mensaje de error */
        return ['success' => false, 'error' => 'Credenciales incorrectas'];
    }


  }
?>