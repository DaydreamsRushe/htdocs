<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Formulario de Contacto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Contacta con nosotros</h1>
        
        <?php
        function sanitize($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }

        $error = "";
        $exito = "";
        $email = "";
        $asunto = "";
        $contenido = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
            $asunto = isset($_REQUEST['asunto']) ? $_REQUEST['asunto'] : "";
            $contenido = isset($_REQUEST['contenido']) ? $_REQUEST['contenido'] : "";

            if (empty($email)) {
                $error .= "Email es un campo obligatorio. <br/>";
            } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $error .= "Correo electrónico no válido.<br/>";
            } else {
                $email = sanitize($email);
            }

            if (empty($asunto)) {
                $error .= "Asunto es un campo obligatorio. <br/>";
            } else if (strlen($asunto) < 2 || strlen($asunto) > 40) {
                $error .= "Asunto no se ajusta al largo necesario.<br/>";
            } else {
                $asunto = sanitize($asunto);
            }

            if (empty($contenido)) {
                $error .= "Nos interesa el contenido de tu mensaje y es un campo obligatorio. <br/>";
            } else if (strlen($contenido) < 10 || strlen($contenido) > 200) {
                $error .= "Ajusta tu mensaje a un máximo de 200 carácteres.<br/>";
            } else {
                $contenido = sanitize($contenido);
            }

            if ($error != "") {
                $error = '<div class="alert alert-danger" role="alert">TENEMOS ERRORES EN NUESTRO FORMULARIO!<br/>' . $error . '</div>';
            } else {
                $to = "oscareroles@gmail.com";
                $cabeceras = "MIME-Version: 1.0 \r\n";
                $cabeceras .= "Content-type: text/html; charset=utf-8 \r\n";
                $cabeceras .= "Reply-To: " . $email . "\r\n";

                if (mail($to, $asunto, $contenido, $cabeceras)) {
                    $exito = '<div class="success alert-success" role="">Correo enviado CORRECTAMENTE!<br/></div>';
                    $email = "";
                    $asunto = "";
                    $contenido = "";
                } else {
                    $error = '<div class="alert alert-danger" role="alert">NO HEMOS PODIDO ENVIAR EL CORREO!<br/></div>';
                }
            }
        }
        ?>

        <div id="error">
            <?php echo $error; ?>
            <?php echo $exito; ?>
        </div>

        <form method="post" name="firstContact" action="">
            <fieldset class="form-group">
                <label for="email">Dirección de email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                <small id="mostra1" class="text-muted"></small>
            </fieldset>
            <fieldset class="form-group">
                <label for="asunto">Asunto</label>
                <input type="text" class="form-control" id="asunto" name="asunto" value="<?php echo $asunto; ?>">
                <small id="mostra2" class="text-muted"></small>
            </fieldset>
            <fieldset class="form-group">
                <label for="contenido">¿Qué te gustaría preguntarnos?</label>
                <textarea class="form-control" id="contenido" name="contenido" rows="3" minlength="10" maxlength="200"><?php echo $contenido; ?></textarea>
                <small id="mostra6" class="text-muted"></small>
            </fieldset>
            <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Enviar</button>
            <button type="button" name="borrar" id="borrar" class="btn btn-primary">Borrar formulario</button>
        </form>
    </div>

    <script>
    const error = document.querySelector("#error");
    const m=[document.querySelector("#mostra1"),document.querySelector("#mostra2"),document.querySelector("#mostra6")]
     
    const formu = document.firstContact;
    const ptremail = /^[a-z0-9_-]+([.][a-z0-9_-]+)*@[a-z0-9_]+([.][a-z0-9_]+)*[.][a-z]{2,9}$/;
    const ptrasunto = /^[A-Za-zÀ-ÿ-\u00f1\u00d1\s]{5,40}$/;
    const ptrcontent = /[A-Za-zÀ-ÿ-\u00f1\u00d1\s]{10,250}$/;
    const form=[formu.email,formu.asunto,formu.contenido];

    formu.addEventListener("submit", (e) => {
        const mymail = mail(), myasunto = asunt(),mycontent = content();
        if (!mymail || !myasunto || !mycontent) {
            e.preventDefault();
            error.innerHTML ="ERRORUM   No se ha podido enviar el formulario. Por favor, revisa que todos los campos estén rellenados correctamente.";
            error.style.color = "#FF0000";
            return false;
        } else {
            formu.submit();
            return true; 
        }
    });

    const avisoReset = () => {
        const reset = confirm(
            "ATENCIÓN!!!!!!!\nSi confirmas, se borraran todos los datos del formulario"
        );
        reset ? location.reload(true) : false;
    };

    const mail = () => {
        let correo = form[0].value;
        if (!correo.match(ptremail)) return false; return true;
    };

    const asunt = () => {
        let asunto = form[1].value;
        if (!asunto.match(ptrasunto)) return false; return true;
    };

    const content = () => {
        let content = form[2].value;
        if (!content.match(ptrcontent)) return false; return true;
    };

    const pasaValor = (event) => {
        let result;
        switch (event.target.name) {
            case "email":
                result = mail();
                if (result) {
                    m[0].innerHTML = ". Email correcto";
                    m[0].style.color = "#068B3E";
                    form[0].style.border = "solid 2px green";
                } else {
                    m[0].innerHTML = ". Email no válido. se esperaba una (@) y un (.)";
                    m[0].style.color = "#FF0000";
                    form[0].style.border = "solid 2px red";
                }
                break;
            case "asunto":
                result = asunt();
                if (result) {
                    m[1].innerHTML = ". Asunto dentro de parámetros";
                    m[1].style.color = "#068B3E";
                    form[1].style.border = "solid 2px green";
                } else {
                    m[1].innerHTML = ". Asunto no válido. SE SIENTEEEEE";
                    m[1].style.color = "#FF0000";
                    form[1].style.border = "solid 2px red";
                }
                break;
            case "contenido":
                result = content();
                if (result) {
                    m[2].innerHTML = ". Contenido válido";
                    m[2].style.color = "#068B3E";
                    form[2].style.border = "solid 2px green";
                } else {
                    m[2].innerHTML = ". Contenido no válido. SE SIENTEEEEE";
                    m[2].style.color = "#FF0000";
                    form[2].style.border = "solid 2px red";
                }
                break;
        }
    };

    const listeners = [formu.email,formu.asunto,formu.contenido];

    for (const listener of listeners)
        listener.addEventListener("keyup", pasaValor);

    formu.borrar.addEventListener("click", avisoReset); 
    </script>
</body>
</html> 