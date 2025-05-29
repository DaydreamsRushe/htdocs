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
  tablaDatos: document.querySelector("#tablaDatos"),
  content: document.querySelector("main"),
};

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
};

const dataManager = {
  /* Mostramos todos los datos por filas de todos los psicologos que se encuentran en nuestra base de datos junto con las especialidades de cada uno */
  async cargarDatos() {
    try {
      /* Pedimos los datos a servidor */
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

  /* Añade los datos en el espacio definido para la tabla */
  mostrarDatos(datos) {
    elementos.tablaDatos.innerHTML = "";

    datos.forEach((dato) => {
      console.log(dato);
      const fila = dataManager.crearFila(dato);
      elementos.tablaDatos.appendChild(fila);
    });
  },

  crearFila(dato) {
    const fila = document.createElement("tr");
    fila.innerHTML = dataManager.generarHTMLFila(dato);

    return fila;
  },

  /*  Genera el HTML de cada fila para los psicologos */
  generarHTMLFila(dato) {
    return `
      <td>${dato.id}</td>
      <td>
        <div class="user-photo-container">
          <img src="${dato.foto || CONSTANTES.FOTO_DEFAULT}" 
               alt="Foto de ${dato.nombre}" 
               class="user-photo"
               onerror="this.src='${CONSTANTES.FOTO_DEFAULT}'">
        </div>
      </td>
      <td class="editable nombre">${dato.nombre}</td>
      <td class="editable email">${dato.email}</td>
      <td class="especialidad editable">
        ${dato.especialidades || "general"}
      </td>
    `;
  },
};

document.addEventListener("DOMContentLoaded", () => {
  /* Definimos el evento para el boton de inicio de sesion */
  document.querySelector("#btn-sesion").addEventListener("click", () => {
    document.location.href = "login.php";
  });

  dataManager.cargarDatos();
});
