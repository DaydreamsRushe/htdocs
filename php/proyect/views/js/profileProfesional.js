const CONSTANTES = {
  API_ENDPOINT: "api.php",
  MAX_FILE_SIZE: 2 * 1024 * 1024, // 2MB
  TIPOS_PERMITIDOS: ["image/jpeg", "image/png", "image/gif"],
  FOTO_DEFAULT: "views/img/default-user.svg",
  TIMEOUT_MENSAJE: 5000,
  FADE_OUT: 500,
  USERDATA: JSON.parse(localStorage["userData"]),
};

const elementos = {
  personalData: document.querySelector("#personal-container"),
  pacientes: document.querySelector("#tablaClient"),
};

const dataManager = {
  cargarDatosPersonales() {
    elementos.personalData.innerHTML = dataManager.crearHTMLPersonal();
  },

  crearEventosFila(fila, dato) {
    /* Programamos los botones que se ven desde el panel de clientes asignados en la pagina de perfil de un profesional */
    const btnDiagnosticar = fila.querySelector(".btn-diagnosticar");
    btnDiagnosticar.addEventListener("click", () =>
      dataManager.diagnostico(fila.querySelector(".diagnostico"))
    );

    const btnMedicar = fila.querySelector(".btn-medicamento");
    btnMedicar.addEventListener("click", () =>
      dataManager.medicar(
        fila.querySelector(".diagnostico").value,
        fila.querySelector(".medicamento")
      )
    );
  },

  diagnostico($campoDiagnostico) {},

  medicar($diagnostico, $campoMedicamento) {},

  crearcliente(dato) {
    const fila = document.createElement("tr");
    fila.innerHTML = dataManager.generarHTMLclient(dato);
    dataManager.crearEventosFila(fila, dato);

    return fila;
  },

  cargarPacientes() {
    elementos.pacientes.innerHTML = "";
    fetch("api.php", {
      method: "POST",
      body: (() => {
        const formData = new FormData();
        formData.append("action", "client-list");
        formData.append("id", CONSTANTES.USERDATA["id"]);
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
      .then((datos) => {
        datos.forEach((dato) => {
          console.log(dato);
          const fila = dataManager.crearcliente(dato);
          elementos.pacientes.appendChild(fila);
        });
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Error al reunir pacientes: " + error.message);
      });
  },

  crearHTMLPersonal() {
    return `
        <h3>Datos personales</h3>
        <div class="user-photo-container">
          <img src="${CONSTANTES.USERDATA["foto"] || CONSTANTES.FOTO_DEFAULT}" 
               alt="Foto de ${CONSTANTES.USERDATA["nombre"]}" 
               class="user-photo"
               onerror="this.src='${CONSTANTES.FOTO_DEFAULT}'">
        </div>
      <p class="editable nombre">${CONSTANTES.USERDATA["nombre"]}</p>
      <p class="editable email">${CONSTANTES.USERDATA["email"]}</p>
    `;
  },

  generarHTMLclient(dato) {
    return `
      <td>${dato.user_id}</td>
      <td class="editable nombre">${dato.nombre_paciente}</td>
      <td class="editable diagnostico">${dato.nombre_dolencia}</td>
      <td class="editable medicamento">${dato.farmaco}</td>
      <td class="editable acciones">
        <button class="btn-diagnosticar">Diagnosticar</button>
        <button class="btn-medicamento">Medicamento</button>
      </td>
    `;
  },
};

document.addEventListener("DOMContentLoaded", () => {
  document.querySelector("#btn-cerrar").addEventListener("click", () => {
    localStorage.removeItem("userData");
    window.location.href = "index.php";
  });

  dataManager.cargarDatosPersonales();
  dataManager.cargarPacientes();
});
