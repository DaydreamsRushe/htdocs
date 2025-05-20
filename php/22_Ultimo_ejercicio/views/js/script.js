// Constantes
const CONSTANTES = {
  API_ENDPOINT: "api.php",
  MAX_FILE_SIZE: 2 * 1024 * 1024, // 2MB
  TIPOS_PERMITIDOS: ["image/jpeg", "image/png", "image/gif"],
  FOTO_DEFAULT: "views/img/default-user.svg",
  TIMEOUT_MENSAJE: 5000,
  FADE_OUT: 500,
};

// Configuración de tipos de usuario
const TIPOS_USUARIO = {
  EDITOR: 1,
  REGISTRADO: 2,
  ADMIN: 3,
};

// Estado global
const estado = {
  editandoEnCurso: false,
  userData: JSON.parse(localStorage.getItem("userData")),
};

// Referencias a elementos del DOM
const elementos = {
  btnInsertar: document.querySelector("#btnInsertar"),
  btnBorrar: document.querySelector("#btnBorrar"),
  nombre: document.querySelector("#nombre"),
  usuario: document.querySelector("#usuario"),
  email: document.querySelector("#email"),
  password: document.querySelector("#password"),
  tipo_usuario: document.querySelector("#tipo_usuario"),
  foto: document.querySelector("#foto"),
  tablaDatos: document.querySelector("#tablaDatos"),
  content: document.querySelector(".content-wrapper"),
};

// Funciones de utilidad
const utilidades = {
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
    elementos.usuario.value = "";
    elementos.email.value = "";
    elementos.password.value = "";
    elementos.tipo_usuario.value = "2";
    elementos.foto.value = "";
    estado.editandoEnCurso = false;
    elementos.btnInsertar.textContent = "Insertar";
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

// Funciones de manejo de datos
const dataManager = {
  async cargarDatos() {
    try {
      const response = await fetch(CONSTANTES.API_ENDPOINT);
      const datos = await response.json();
      dataManager.mostrarDatos(datos);
    } catch (error) {
      utilidades.mostrarMensaje(
        "Error al cargar los datos: " + error.message,
        true
      );
    }
  },

  filtrarDatos(datos) {
    if (!estado.userData) return datos;

    if (estado.userData.tipo_usuario === TIPOS_USUARIO.EDITOR) {
      return datos.filter(
        (dato) =>
          (dato.tipo_usuario === TIPOS_USUARIO.REGISTRADO ||
            dato.tipo_usuario === TIPOS_USUARIO.EDITOR) &&
          dato.id !== estado.userData.id
      );
    }

    return datos;
  },

  mostrarDatos(datos) {
    elementos.tablaDatos.innerHTML = "";
    let datosFiltrados = dataManager.filtrarDatos(datos);
    datosFiltrados.sort((a, b) => a.id - b.id);

    datosFiltrados.forEach((dato) => {
      const fila = dataManager.crearFila(dato);
      elementos.tablaDatos.appendChild(fila);
    });
  },

  crearFila(dato) {
    const fila = document.createElement("tr");
    const esUsuarioActual = estado.userData && dato.id == estado.userData.id;
    const mostrarBotones =
      dataManager.determinarMostrarBotones(esUsuarioActual);
    const mostrarBotonFoto =
      dataManager.determinarMostrarBotonFoto(esUsuarioActual);

    fila.innerHTML = dataManager.generarHTMLFila(
      dato,
      mostrarBotones,
      mostrarBotonFoto
    );
    dataManager.agregarEventosFila(fila, dato, mostrarBotones);

    return fila;
  },

  determinarMostrarBotones(esUsuarioActual) {
    if (!estado.userData) return false;
    if (estado.userData.tipo_usuario === TIPOS_USUARIO.ADMIN) return true;
    return (
      estado.userData.tipo_usuario === TIPOS_USUARIO.EDITOR && !esUsuarioActual
    );
  },

  determinarMostrarBotonFoto(esUsuarioActual) {
    if (!estado.userData) return false;
    if (estado.userData.tipo_usuario === TIPOS_USUARIO.ADMIN) return true;
    if (
      estado.userData.tipo_usuario === TIPOS_USUARIO.EDITOR &&
      !esUsuarioActual
    )
      return true;
    return esUsuarioActual;
  },

  generarHTMLFila(dato, mostrarBotones, mostrarBotonFoto) {
    return `
      <td>${dato.id}</td>
      <td>
        <div class="user-photo-container">
          <img src="${dato.foto || CONSTANTES.FOTO_DEFAULT}" 
               alt="Foto de ${dato.nombre_apellidos}" 
               class="user-photo"
               onerror="this.src='${CONSTANTES.FOTO_DEFAULT}'">
          <button class="btn-foto" data-id="${dato.id}" 
                  title="Cambiar foto" 
                  ${
                    !mostrarBotonFoto ? 'style="display:none;"' : ""
                  }>📷</button>
        </div>
      </td>
      <td class="editable nombre">${dato.nombre_apellidos}</td>
      <td class="editable usuario">${dato.usuario}</td>
      <td class="editable email">${dato.email}</td>
      <td class="tipo-usuario editable" data-tipo="${dato.tipo_usuario}">
        ${dato.tipo_usuario === TIPOS_USUARIO.EDITOR ? "Editor" : "Registrado"}
      </td>
      <td>
        ${
          mostrarBotones
            ? `
          <button class="btn-borrar">Borrar</button>
          <button class="btn-guardar">Editar</button>
        `
            : ""
        }
      </td>
    `;
  },

  agregarEventosFila(fila, dato, mostrarBotones) {
    if (mostrarBotones) {
      const btnBorrar = fila.querySelector(".btn-borrar");
      btnBorrar.addEventListener("click", () =>
        dataManager.borrarDato(dato.id)
      );

      const btnGuardar = fila.querySelector(".btn-guardar");
      btnGuardar.addEventListener("click", () => {
        if (btnGuardar.classList.contains("guardando")) {
          dataManager.guardarCambios(dato.id, btnGuardar);
        } else {
          dataManager.activarEdicion(fila);
        }
      });
    }

    const btnFoto = fila.querySelector(".btn-foto");
    if (btnFoto) {
      btnFoto.addEventListener("click", () => dataManager.cambiarFoto(dato.id));
    }
  },

  activarEdicion(fila) {
    if (estado.editandoEnCurso) return;

    const celdas = fila.querySelectorAll(".editable");
    celdas.forEach((celda) => {
      const valor = celda.textContent;
      const tipo = celda.dataset.tipo;

      if (tipo) {
        celda.innerHTML = `
          <select class="edit-input">
            <option value="1" ${tipo === "1" ? "selected" : ""}>Editor</option>
            <option value="2" ${
              tipo === "2" ? "selected" : ""
            }>Registrado</option>
          </select>
        `;
      } else {
        celda.innerHTML = `<input type="text" class="edit-input" value="${valor}">`;
      }
    });

    const btnGuardar = fila.querySelector(".btn-guardar");
    btnGuardar.textContent = "Guardar";
    btnGuardar.classList.add("guardando");
    estado.editandoEnCurso = true;
  },

  async cambiarFoto(id) {
    const input = document.createElement("input");
    input.type = "file";
    input.accept = "image/*";

    input.onchange = async (e) => {
      const file = e.target.files[0];
      if (!file) return;

      if (!utilidades.validarArchivo(file)) return;

      const formData = new FormData();
      formData.append("foto", file);
      formData.append("id", id);
      formData.append("action", "update_foto");

      try {
        const response = await fetch(CONSTANTES.API_ENDPOINT, {
          method: "POST",
          body: formData,
        });

        const resultado = await response.json();
        if (resultado.error) {
          utilidades.mostrarMensaje(resultado.error, true);
        } else {
          utilidades.mostrarMensaje("Foto actualizada correctamente");
          dataManager.cargarDatos();
        }
      } catch (error) {
        utilidades.mostrarMensaje("Error al actualizar la foto", true);
      }
    };

    input.click();
  },

  async guardarCambios(id, boton) {
    const fila = boton.closest("tr");
    const inputs = fila.querySelectorAll(".edit-input");

    const data = {
      action: "update",
      id: id,
      nombre_apellidos: inputs[0].value,
      usuario: inputs[1].value,
      email: inputs[2].value,
    };

    // Solo incluir tipo_usuario si el usuario es admin o editor
    if (
      estado.userData.tipo_usuario === TIPOS_USUARIO.ADMIN ||
      estado.userData.tipo_usuario === TIPOS_USUARIO.EDITOR
    ) {
      data.tipo_usuario = inputs[3].value;
    }

    try {
      const response = await fetch(CONSTANTES.API_ENDPOINT, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      });

      const result = await response.json();

      if (result.error) {
        utilidades.mostrarMensaje(result.error, true);
      } else {
        utilidades.mostrarMensaje(result.mensaje);
        await dataManager.cargarDatos();
      }
    } catch (error) {
      utilidades.mostrarMensaje("Error al actualizar: " + error.message, true);
    }
  },

  async borrarDato(id) {
    if (!confirm("¿Está seguro de que desea borrar este registro?")) return;

    const formData = new FormData();
    formData.append("action", "delete");
    formData.append("id", id);

    try {
      const response = await fetch(CONSTANTES.API_ENDPOINT, {
        method: "POST",
        body: formData,
      });

      const resultado = await response.json();
      if (resultado.error) {
        utilidades.mostrarMensaje(resultado.error, true);
      } else {
        utilidades.mostrarMensaje("Registro borrado correctamente");
        dataManager.cargarDatos();
      }
    } catch (error) {
      utilidades.mostrarMensaje("Error al borrar el registro", true);
    }
  },

  async insertarDato() {
    const formData = new FormData();
    formData.append("action", "create");
    formData.append("nombre", elementos.nombre.value);
    formData.append("usuario", elementos.usuario.value);
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
        await dataManager.cargarDatos();
      }
    } catch (error) {
      utilidades.mostrarMensaje("Error al insertar: " + error.message, true);
    }
  },
};

// Inicialización
document.addEventListener("DOMContentLoaded", () => {
  // Inicializar eventos
  document.querySelector("#formUsuario").addEventListener("submit", (e) => {
    e.preventDefault();
    dataManager.insertarDato();
  });

  const camposFormulario = [
    { elemento: elementos.nombre, id: "nombre" },
    { elemento: elementos.usuario, id: "usuario" },
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

  // Cargar datos iniciales
  dataManager.cargarDatos();
});
