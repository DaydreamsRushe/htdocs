<?php

class ContactForm {
    private $email;
    private $asunto;
    private $contenido;
    private $error;
    private $exito;

    public function __construct() {
        $this->error = "";
        $this->exito = "";
    }

    public function setData($email, $asunto, $contenido) {
        $this->email = $email;
        $this->asunto = $asunto;
        $this->contenido = $contenido;
    }

    private function sanitize($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    public function validate() {
        if (empty($this->email)) {
            $this->error .= "Email es un campo obligatorio. <br/>";
        } else if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->error .= "Correo electrónico no válido.<br/>";
        } else {
            $this->email = $this->sanitize($this->email);
        }

        if (empty($this->asunto)) {
            $this->error .= "Asunto es un campo obligatorio. <br/>";
        } else if (strlen($this->asunto) < 2 || strlen($this->asunto) > 40) {
            $this->error .= "Asunto no se ajusta al largo necesario.<br/>";
        } else {
            $this->asunto = $this->sanitize($this->asunto);
        }

        if (empty($this->contenido)) {
            $this->error .= "Nos interesa el contenido de tu mensaje y es un campo obligatorio. <br/>";
        } else if (strlen($this->contenido) < 10 || strlen($this->contenido) > 200) {
            $this->error .= "Ajusta tu mensaje a un máximo de 200 carácteres.<br/>";
        } else {
            $this->contenido = $this->sanitize($this->contenido);
        }

        return empty($this->error);
    }

    public function send() {
        $to = "oscareroles@gmail.com";
        $cabeceras = "MIME-Version: 1.0 \r\n";
        $cabeceras .= "Content-type: text/html; charset=utf-8 \r\n";
        $cabeceras .= "Reply-To: " . $this->email . "\r\n";

        if (mail($to, $this->asunto, $this->contenido, $cabeceras)) {
            $this->exito = '<div class="success alert-success" role="">Correo enviado CORRECTAMENTE!<br/></div>';
            return true;
        } else {
            $this->error = '<div class="alert alert-danger" role="alert">NO HEMOS PODIDO ENVIAR EL CORREO!<br/></div>';
            return false;
        }
    }

    public function getError() {
        if (!empty($this->error)) {
            return '<div class="alert alert-danger" role="alert">TENEMOS ERRORES EN NUESTRO FORMULARIO!<br/>' . $this->error . '</div>';
        }
        return "";
    }

    public function getExito() {
        return $this->exito;
    }

    public function getData() {
        return [
            'email' => $this->email,
            'asunto' => $this->asunto,
            'contenido' => $this->contenido
        ];
    }
} 