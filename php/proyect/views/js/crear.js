const CONSTANTES = {
  API_ENDPOINT: "api.php",
  MAX_FILE_SIZE: 2 * 1024 * 1024, // 2MB
  TIPOS_PERMITIDOS: ["image/jpeg", "image/png", "image/gif"],
  FOTO_DEFAULT: "views/img/default-user.svg",
  TIMEOUT_MENSAJE: 5000,
  FADE_OUT: 500,
};

const TIPOS_USUARIO = {
  CLIENTE: 1,
  PROFESIONAL: 2,
};

const elementos = {
  btnInsertar: document.querySelector("#btnInsertar"),
  btnBorrar: document.querySelector("#btnBorrar"),
  nombre: document.querySelector("#nombre"),
  email: document.querySelector("#email"),
  password: document.querySelector("#password"),
  tipo_usuario: document.querySelector("#tipo_usuario"),
  foto: document.querySelector("#foto"),
  content: document.querySelector(".content-wrapper"),
};

const utilidades = {
  /* Muestra mensajes de error, creando una ventana justo debajo del formulario */
  mostrarMensaje: (mensaje, esError = false) => {
    let mensajeElement = document.querySelector(".mensaje-usuario");
    if (!mensajeElement) {
      mensajeElement = document.createElement("div");
      mensajeElement.className = "mensaje-usuario";
      elementos.content.insertBefore(
        mensajeElement,
        document.querySelector(".table-container")
      );
    }

    mensajeElement.textContent = mensaje;
    mensajeElement.className = `mensaje-usuario ${esError ? "error" : "exito"}`;

    setTimeout(() => {
      mensajeElement.style.opacity = "0";
      setTimeout(() => mensajeElement.remove(), CONSTANTES.FADE_OUT);
    }, CONSTANTES.TIMEOUT_MENSAJE);
  },

  restablecerFormulario: () => {
    elementos.nombre.value = "";
    elementos.email.value = "";
    elementos.password.value = "";
    elementos.tipo_usuario.value = "2";
    elementos.foto.value = "";
  },

  validarArchivo: (file) => {
    if (file.size > CONSTANTES.MAX_FILE_SIZE) {
      utilidades.mostrarMensaje(
        "El archivo es demasiado grande. Máximo 2MB",
        true
      );
      return false;
    }

    if (!CONSTANTES.TIPOS_PERMITIDOS.includes(file.type)) {
      utilidades.mostrarMensaje(
        "Tipo de archivo no permitido. Use JPEG, PNG o GIF",
        true
      );
      return false;
    }

    return true;
  },
};

const dataManager = {
  async insertarDato() {
    const formData = new FormData();
    formData.append("action", "create");
    formData.append("nombre", elementos.nombre.value);
    formData.append("email", elementos.email.value);
    formData.append("password", elementos.password.value);
    formData.append("tipo_usuario", elementos.tipo_usuario.value);

    if (elementos.foto.files.length > 0) {
      if (!utilidades.validarArchivo(elementos.foto.files[0])) {
        return;
      }
      formData.append("foto", elementos.foto.files[0]);
    }

    try {
      const response = await fetch(CONSTANTES.API_ENDPOINT, {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.error) {
        utilidades.mostrarMensaje(result.error, true);
      } else {
        utilidades.mostrarMensaje(result.mensaje);
        utilidades.restablecerFormulario();
      }
    } catch (error) {
      utilidades.mostrarMensaje("Error al insertar: " + error.message, true);
    }
  },
};

document.addEventListener("DOMContentLoaded", () => {
  document.querySelector("#btn-sesion").addEventListener("click", () => {
    document.location.href = "login.php";
  });

  document.querySelector("#formUsuario").addEventListener("submit", (e) => {
    e.preventDefault();
    dataManager.insertarDato();
  });

  const camposFormulario = [
    { elemento: elementos.nombre, id: "nombre" },
    { elemento: elementos.email, id: "email" },
    { elemento: elementos.password, id: "password" },
  ];

  camposFormulario.forEach((campo) => {
    campo.elemento.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        e.preventDefault();
        dataManager.insertarDato();
      }
    });
  });

  elementos.btnBorrar.addEventListener("click", () =>
    utilidades.restablecerFormulario()
  );
});
