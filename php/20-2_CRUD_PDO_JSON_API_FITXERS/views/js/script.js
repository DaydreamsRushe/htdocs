const btnInsertar = document.querySelector("#btnInsertar");
const btnBorrar = document.querySelector("#btnBorrar");
const nombre = document.querySelector("#nombre");
const usuario = document.querySelector("#usuario");
const email = document.querySelector("#email");
const password = document.querySelector("#password");
const tipo_usuario = document.querySelector("#tipo_usuario");
//capturar input foto
const foto = document.querySelector("#foto");
const tablaDatos = document.querySelector("#tablaDatos");
let editandoEnCurso = false;
const content = document.querySelector(".content-wrapper"); //prevenir muestra de mensajes

// mostrando mensajes al usuario
const mostrarMensaje = (mensaje, esError = false) => {
  // Crear el elemento de mensaje si no existe
  let mensajeElement = document.querySelector(".mensaje-usuario");
  if (!mensajeElement) {
    mensajeElement = document.createElement("div");
    mensajeElement.className = "mensaje-usuario";
    content.insertBefore(
      mensajeElement,
      document.querySelector(".table-container")
    );
  }
  // Configuro el mensaje
  mensajeElement.textContent = mensaje;
  mensajeElement.className = `mensaje-usuario ${esError ? "error" : "exito"}`;
  // Oculto el mensaje después de 5 segundos
  setTimeout(() => {
    mensajeElement.style.opacity = "0";
    setTimeout(() => {
      mensajeElement.remove();
    }, 500);
  }, 5000);
};

// Listener para cargar los datos al iniciar la página
document.addEventListener("DOMContentLoaded", () => {
  cargarDatos();
  inicializarEventos();
});

// Inicializamos todos los eventos
const inicializarEventos = () => {
  // Evento para el botón de insertar
  btnInsertar.addEventListener("click", insertarDato);

  // Eventos para todos los campos del formulario
  const camposFormulario = [
    { elemento: nombre, id: "nombre" },
    { elemento: usuario, id: "usuario" },
    { elemento: email, id: "email" },
    { elemento: password, id: "password" },
  ];

  camposFormulario.forEach((campo) => {
    campo.elemento.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        insertarDato();
      }
    });
  });

  btnBorrar.addEventListener("click", () => {
    nombre.value = "";
    usuario.value = "";
    email.value = "";
    password.value = "";
    tipo_usuario.value = "2";
    foto.value = "";
  });
};

// Traemos los datos desde el servidor
const cargarDatos = async () => {
  try {
    const response = await fetch("api.php");
    const datos = await response.json();
    mostrarDatos(datos);
  } catch (error) {
    mostrarMensaje("Error al cargar los datos: " + error.message, true);
  }
};

// Mostrar los datos en la tabla
const mostrarDatos = (datos) => {
  tablaDatos.innerHTML = "";
  datos.forEach((dato) => {
    const fila = document.createElement("tr");
    fila.innerHTML = `
            <td>${dato.id}</td>
            <td>
              <div class="user-photo-container">
                <img src="${dato.foto || "views/img/default-user.svg"}" 
                     alt="Foto de ${dato.nombre_apellidos}" 
                     class="user-photo"
                     onerror="this.src='views/img/default-user.svg'">
                <button class="btn-foto" data-id="${
                  dato.id
                }" title="Cambiar foto">&#128247;</button>
              </div>
            </td>
            <td class="editable">${dato.nombre_apellidos}</td>
            <td class="editable">${dato.usuario}</td>
            <td class="editable">${dato.email}</td>
            <td>${dato.tipo_usuario === 1 ? "Editor" : "Registrado"}</td>
            <td>
              <button class="btn-borrar">Borrar</button>
              <button class="btn-guardar">Editar</button>
            </td>
        `;

    const btnBorrar = fila.querySelector(".btn-borrar");
    btnBorrar.addEventListener("click", () => borrarDato(dato.id));

    const btnGuardar = fila.querySelector(".btn-guardar");
    btnGuardar.addEventListener("click", () => {
      if (btnGuardar.classList.contains("guardando")) {
        guardarCambios(dato.id, btnGuardar);
      } else {
        activarEdicion(fila);
      }
    });
    //Capturar la edición de la foto del usuario llamando a su función
    const btnFoto = fila.querySelector(".btn-foto");
    btnFoto.addEventListener("click", () => cambiarFoto(dato.id));

    tablaDatos.appendChild(fila);
  });
};

// Función para cambiar la foto de un usuario
const cambiarFoto = (id) => {
  const input = document.createElement("input");
  input.type = "file";
  input.accept = "image/*";

  input.onchange = async (e) => {
    //el input es de tipo file, al cambiar seleccionamos el primer elemento
    const file = e.target.files[0];
    if (file) {
      // Validamos tamaño del archivo (máximo 2MB)
      if (file.size > 2 * 1024 * 1024) {
        mostrarMensaje("El archivo es demasiado grande. Máximo 2MB", true);
        return;
      }

      // Validar tipo de archivo
      const tiposPermitidos = ["image/jpeg", "image/png", "image/gif"];
      if (!tiposPermitidos.includes(file.type)) {
        mostrarMensaje(
          "Tipo de archivo no permitido. Use JPEG, PNG o GIF",
          true
        );
        return;
      }
      const formData = new FormData();
      formData.append("foto", file);
      formData.append("id", id);
      formData.append("action", "update_foto");
      try {
        const response = await fetch("api.php", {
          method: "POST",
          body: formData,
        });
        const resultado = await response.json();
        if (resultado.error) {
          mostrarMensaje(resultado.error, true);
        } else {
          mostrarMensaje("Foto actualizada correctamente");
          cargarDatos();
        }
      } catch (error) {
        mostrarMensaje("Error al actualizar la foto: " + error.message, true);
      }
    }
  };
  input.click();
};

// Activamos la edición de una fila
const activarEdicion = (fila) => {
  if (editandoEnCurso) {
    alert(
      "Por favor, guarde los cambios actuales antes de editar otro registro"
    );
    return;
  }

  editandoEnCurso = true;
  const celdasEditables = fila.querySelectorAll(".editable");

  celdasEditables.forEach((celda) => {
    const valorActual = celda.textContent;
    celda.innerHTML = `<input type="text" value="${valorActual}" class="edit-input">`;
  });

  // Cambiamos el botón a Guardar
  const btnGuardar = fila.querySelector(".btn-guardar");
  btnGuardar.textContent = "Guardar";
  btnGuardar.classList.add("guardando");

  // Agregamos evento Enter a todos los inputs de la fila
  const inputs = fila.querySelectorAll(".edit-input");
  inputs.forEach((input) => {
    input.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        e.preventDefault(); // Prevenimos el comportamiento por defecto
        btnGuardar.click();
      }
    });
  });

  // Enfocamos el primer input
  const primerInput = fila.querySelector(".edit-input");
  if (primerInput) {
    primerInput.focus();
  }
};

// Guardamos los cambios
const guardarCambios = async (id, boton) => {
  if (!boton.classList.contains("guardando")) {
    return;
  }

  const fila = boton.closest("tr");
  const celdas = fila.querySelectorAll("td");
  const nombre_apellidos =
    celdas[2].querySelector("input")?.value || celdas[2].textContent;
  const usuario =
    celdas[3].querySelector("input")?.value || celdas[3].textContent;
  const email =
    celdas[4].querySelector("input")?.value || celdas[4].textContent;

  try {
    const response = await fetch("api.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        action: "update",
        id: id,
        nombre_apellidos: nombre_apellidos,
        usuario: usuario,
        email: email,
      }),
    });

    const resultado = await response.json();

    // Verificamos tanto el código de estado HTTP como el contenido de la respuesta
    if (response.status >= 400 || resultado.error) {
      // Mostrar mensaje de error
      mostrarMensaje(resultado.error || "Error al actualizar el usuario", true);
    } else {
      // Convertimos los inputs de nuevo a texto
      celdas[2].textContent = nombre_apellidos;
      celdas[3].textContent = usuario;
      celdas[4].textContent = email;

      // Restauramos el botón a Editar
      boton.textContent = "Editar";
      boton.classList.remove("guardando");
      editandoEnCurso = false;

      // Mostrar mensaje de éxito
      mostrarMensaje(resultado.mensaje || "Usuario actualizado correctamente");
    }
  } catch (error) {
    mostrarMensaje("Error al actualizar el usuario: " + error.message, true);
  }
};

// Función para insertar un nuevo dato
const insertarDato = async () => {
  if (!nombre.value || !usuario.value || !email.value || !password.value) {
    mostrarMensaje("Por favor, complete todos los campos", true);
    return;
  }
  const formData = new FormData();
  formData.append("action", "create");
  formData.append("nombre", nombre.value);
  formData.append("usuario", usuario.value);
  formData.append("email", email.value);
  formData.append("password", password.value);
  formData.append("tipo_usuario", tipo_usuario.value);
  if (foto.files[0]) {
    formData.append("foto", foto.files[0]);
  }

  try {
    const response = await fetch("api.php", {
      method: "POST",
      body: formData,
    });
    const resultado = await response.json();
    // Verificamos tanto el código de estado HTTP como el contenido de la respuesta
    if (response.status >= 400 || resultado.error) {
      // Mostrar mensaje de error
      mostrarMensaje(resultado.error || "Error al crear el usuario", true);
    } else {
      // Limpiar campos y actualizar tabla solo si no hay error
      nombre.value = "";
      usuario.value = "";
      email.value = "";
      password.value = "";
      tipo_usuario.value = "2";
      foto.value = "";
      cargarDatos();

      // Mostrar mensaje de éxito
      mostrarMensaje(resultado.mensaje || "Usuario creado correctamente");
    }
  } catch (error) {
    mostrarMensaje("Error al crear el usuario: " + error.message, true);
  }
};

// Función para borrar un dato
const borrarDato = async (id) => {
  if (confirm("¿Está seguro de que desea borrar este registro?")) {
    try {
      const response = await fetch("api.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          action: "delete",
          id: id,
        }),
      });

      const resultado = await response.json();

      if (response.ok) {
        cargarDatos();

        // Mostrar mensaje de éxito o error según la respuesta
        if (resultado.mensaje) {
          mostrarMensaje(resultado.mensaje);
        } else if (resultado.error) {
          mostrarMensaje(resultado.error, true);
        }
      } else {
        // Mostrar mensaje de error
        mostrarMensaje(resultado.error || "Error al eliminar el usuario", true);
      }
    } catch (error) {
      mostrarMensaje("Error al eliminar el usuario: " + error.message, true);
    }
  }
};
