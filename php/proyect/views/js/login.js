/* Al cargar la pagina */
document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.querySelector("#loginForm");

  // Verificamos si ya está logueado
  const userData = JSON.parse(localStorage.getItem("userData"));
  if (userData) {
    tip_user = JSON.parse(localStorage["userData"])["tipo_usuario"];
    /* Si ya esta logueado, lo enviamos a la pagina que le pertoca por tipo de usuario */
    if (tip_user === 2) {
      window.location.href = "profileProfesional.php";
    } else if (tip_user === 1) {
      window.location.href = "profileClient.php";
    }
  }

  // Expresiones regulares para validación
  const regexEmail =
    /[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,9}/;
  const regexPassword =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#*])[a-zA-Z\d!@#*]{6,10}$/;

  /* Evento para el boton de inicio de sesion del formulario */
  loginForm.addEventListener("submit", function (e) {
    /* previene que la tecla presionada active una accion no deseada */
    e.preventDefault();

    const email = document.querySelector("#email").value;
    const password = document.querySelector("#password").value;

    // Validar email
    if (!regexEmail.test(email)) {
      alert("Por favor, ingrese un email válido");
      return;
    }

    // Validar contraseña
    if (!regexPassword.test(password)) {
      console.log(password);
      alert(
        "La contraseña debe tener entre 6 y 10 caracteres, incluyendo al menos una mayúscula, una minúscula, un número y uno de estos caracteres: !@#*"
      );
      return;
    }

    // Enviar datos al servidor
    fetch("api.php", {
      method: "POST",
      body: (() => {
        const formData = new FormData();
        formData.append("action", "login");
        formData.append("email", email);
        formData.append("password", password);
        return formData;
      })(),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la respuesta del servidor");
        }
        return response.text().then((text) => {
          try {
            return JSON.parse(text);
          } catch (e) {
            console.error("Error al parsear JSON:", text);
            throw new Error("Respuesta inválida del servidor");
          }
        });
      })
      .then((data) => {
        if (data.success) {
          // Guardar datos del usuario en localStorage
          localStorage.setItem(
            "userData",
            JSON.stringify({
              id: data.user.id,
              email: data.user.email,
              tipo_usuario: data.user.tipo_usuario,
              nombre: data.user.nombre,
              foto: data.user.foto,
            })
          );
          tip_user = JSON.parse(localStorage["userData"])["tipo_usuario"];
          if (tip_user === 2) {
            window.location.href = "profileProfesional.php";
          } else if (tip_user === 1) {
            window.location.href = "profileClient.php";
          }
        } else {
          alert(data.error || "Credenciales incorrectas");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Error al intentar iniciar sesión: " + error.message);
      });
  });
});
