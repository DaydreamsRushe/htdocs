// Constantes
const API_ENDPOINT = "api.php";

// Funciones básicas
const mostrarModal = (modalId) => {
  const modal = document.querySelector(`#${modalId}`);
  if (modal) modal.style.display = "block";
};

const ocultarModal = (modalId) => {
  const modal = document.querySelector(`#${modalId}`);
  if (modal) modal.style.display = "none";
};

// Crear modales
const crearModales = (userData) => {
  // Modal de perfil
  const perfilModal = `
        <div id="perfilModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Mi Perfil</h2>
                <form id="perfilForm">
                    <input type="hidden" name="id" value="${userData.id}">
                    <div class="form-group">
                        <label>Nombre y Apellidos:</label>
                        <input type="text" name="nombre" value="${
                          userData.nombre || ""
                        }" required>
                    </div>
                    <div class="form-group">
                        <label>Usuario:</label>
                        <input type="text" name="usuario" value="${
                          userData.usuario || ""
                        }" required>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="${
                          userData.email || ""
                        }" required>
                    </div>
                    <div class="form-group">
                        <label>Foto:</label>
                        <input type="file" name="foto" accept="image/*">
                    </div>
                    <div class="form-actions">
                        <button type="submit">Guardar</button>
                        <button type="button" onclick="mostrarModal('passwordModal')">Cambiar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    `;

  // Modal de contraseña
  const passwordModal = `
        <div id="passwordModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Cambiar Contraseña</h2>
                <form id="passwordForm">
                    <input type="hidden" name="id" value="${userData.id}">
                    <div class="form-group">
                        <label>Contraseña Actual:</label>
                        <input type="password" name="currentPassword" required>
                    </div>
                    <div class="form-group">
                        <label>Nueva Contraseña:</label>
                        <input type="password" name="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label>Confirmar Contraseña:</label>
                        <input type="password" name="confirmPassword" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit">Cambiar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    `;

  // Añadir modales al DOM
  document.body.insertAdjacentHTML("beforeend", perfilModal + passwordModal);
};

// Inicializar eventos
const inicializarEventos = () => {
  // Botón de perfil
  const perfilBtn = document.querySelector("#perfilBtn");
  if (perfilBtn) {
    perfilBtn.onclick = () => mostrarModal("perfilModal");
  }

  // Botones de cierre
  document.querySelectorAll(".close").forEach((btn) => {
    btn.onclick = () => {
      ocultarModal("perfilModal");
      ocultarModal("passwordModal");
    };
  });

  // Formulario de perfil
  const perfilForm = document.querySelector("#perfilForm");
  if (perfilForm) {
    perfilForm.onsubmit = async (e) => {
      e.preventDefault();
      const formData = new FormData(perfilForm);
      formData.append("action", "updateProfile");

      try {
        const response = await fetch(API_ENDPOINT, {
          method: "POST",
          body: formData,
        });
        const data = await response.json();

        if (data.success) {
          alert("Perfil actualizado correctamente");
          location.reload();
        } else {
          alert(data.error || "Error al actualizar el perfil");
        }
      } catch (error) {
        alert("Error al actualizar el perfil");
      }
    };
  }

  // Formulario de contraseña
  const passwordForm = document.querySelector("#passwordForm");
  if (passwordForm) {
    passwordForm.onsubmit = async (e) => {
      e.preventDefault();
      const formData = new FormData(passwordForm);
      const newPassword = formData.get("newPassword");
      const confirmPassword = formData.get("confirmPassword");

      if (newPassword !== confirmPassword) {
        alert("Las contraseñas no coinciden");
        return;
      }

      formData.append("action", "changePassword");

      try {
        const response = await fetch(API_ENDPOINT, {
          method: "POST",
          body: formData,
        });
        const data = await response.json();

        if (data.success) {
          alert("Contraseña actualizada correctamente");
          localStorage.removeItem("userData");
          window.location.href = "login.html";
        } else {
          alert(data.error || "Error al cambiar la contraseña");
        }
      } catch (error) {
        alert("Error al cambiar la contraseña");
      }
    };
  }
};

// Iniciar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  const userData = JSON.parse(localStorage.getItem("userData"));
  if (!userData) {
    window.location.href = "login.html";
    return;
  }

  crearModales(userData);
  inicializarEventos();
});
