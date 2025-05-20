// Constantes para tipos de usuario
const USER_TYPES = { ADMIN: 3, EDITOR: 1, REGISTRADO: 2 };

// Constantes para mensajes
const MENSAJES_BIENVENIDA = {
  [USER_TYPES.EDITOR]: (nombre) => `
    <h2>Bienvenido ${nombre}</h2>
    <p>Como Editor, puedes gestionar los usuarios registrados y tu propio perfil.</p>
  `,
  [USER_TYPES.REGISTRADO]: (nombre) => `
    <h2>Bienvenido ${nombre}</h2>
    <p>Esta es tu página privada. Puedes gestionar tu perfil usando el botón "Mi Perfil".</p>
  `,
};

// Función para crear mensaje de bienvenida
const createMBienvenida = (message) => {
  const mensajeBienvenida = document.createElement("div");
  mensajeBienvenida.className = "mensaje-bienvenida";
  mensajeBienvenida.innerHTML = message;
  return mensajeBienvenida;
};

// Función para manejar la redirección
const redirectToLogin = () => {
  window.location.href = "login.html";
};

// Verificar sesión al cargar la página
document.addEventListener("DOMContentLoaded", () => {
  let userData;
  try {
    userData = JSON.parse(localStorage.getItem("userData"));
  } catch (error) {
    console.error("Error al parsear userData:", error);
    redirectToLogin();
    return;
  }

  if (!userData) {
    redirectToLogin();
    return;
  }

  // Obtener referencias a elementos del DOM una sola vez
  const elements = {
    formContainer: document.querySelector(".form-container"),
    tableContainer: document.querySelector(".table-container"),
    perfilBtn: document.querySelector("#perfilBtn"),
    main: document.querySelector("main"),
  };

  // Asegurarse de que el botón de perfil siempre esté visible
  if (elements.perfilBtn) {
    elements.perfilBtn.style.display = "inline-block";
  }

  // Configurar visibilidad según tipo de usuario
  switch (userData.tipo_usuario) {
    case USER_TYPES.ADMIN:
      if (elements.formContainer)
        elements.formContainer.style.display = "block";
      if (elements.tableContainer)
        elements.tableContainer.style.display = "block";
      break;

    case USER_TYPES.EDITOR:
      if (elements.formContainer) elements.formContainer.style.display = "none";
      if (elements.tableContainer)
        elements.tableContainer.style.display = "block";
      if (elements.main) {
        elements.main.insertBefore(
          createMBienvenida(
            MENSAJES_BIENVENIDA[USER_TYPES.EDITOR](userData.nombre)
          ),
          elements.main.firstChild
        );
      }
      break;

    case USER_TYPES.REGISTRADO:
      if (elements.formContainer) elements.formContainer.style.display = "none";
      if (elements.tableContainer)
        elements.tableContainer.style.display = "none";
      if (elements.main) {
        elements.main.appendChild(
          createMBienvenida(
            MENSAJES_BIENVENIDA[USER_TYPES.REGISTRADO](userData.nombre)
          )
        );
      }
      break;
  }

  // Manejar logout
  document.querySelector("#logoutBtn")?.addEventListener("click", () => {
    localStorage.removeItem("userData");
    redirectToLogin();
  });
});
