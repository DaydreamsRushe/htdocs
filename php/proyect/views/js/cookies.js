// Gestión de cookies
const CookieManager = {
  // Tipos de cookies que usamos
  cookieTypes: {
    necesarias: {
      name: "cookies_necesarias",
      description: "Cookies esenciales para el funcionamiento del sitio",
      required: true,
    },
    analiticas: {
      name: "cookies_analiticas",
      description: "Cookies para análisis de uso del sitio",
      required: false,
    },
    personalizacion: {
      name: "cookies_personalizacion",
      description: "Cookies para personalizar la experiencia del usuario",
      required: false,
    },
  },

  // Inicializar el gestor de cookies
  init() {
    if (!this.getCookie("cookies_aceptadas")) {
      this.mostrarBanner();
    }
  },

  // Mostrar el banner de cookies
  mostrarBanner() {
    const banner = document.createElement("div");
    banner.id = "cookie-banner";
    banner.innerHTML = `
            <div class="cookie-content">
                <h3>Política de Cookies</h3>
                <p>Utilizamos cookies para mejorar tu experiencia. Algunas son necesarias para el funcionamiento del sitio.</p>
                <div class="cookie-options">
                    <div class="cookie-option">
                        <input type="checkbox" id="cookies_necesarias" checked disabled>
                        <label for="cookies_necesarias">Necesarias (Siempre activas)</label>
                    </div>
                    <div class="cookie-option">
                        <input type="checkbox" id="cookies_analiticas">
                        <label for="cookies_analiticas">Analíticas</label>
                    </div>
                    <div class="cookie-option">
                        <input type="checkbox" id="cookies_personalizacion">
                        <label for="cookies_personalizacion">Personalización</label>
                    </div>
                </div>
                <div class="cookie-buttons">
                    <button id="aceptar-todas">Aceptar todas</button>
                    <button id="aceptar-seleccionadas">Aceptar seleccionadas</button>
                    <button id="rechazar-todas">Rechazar todas</button>
                </div>
            </div>
        `;
    document.body.appendChild(banner);

    // Event listeners para los botones
    document
      .querySelector("#aceptar-todas")
      .addEventListener("click", () => this.aceptarTodas());
    document
      .querySelector("#aceptar-seleccionadas")
      .addEventListener("click", () => this.aceptarSeleccionadas());
    document
      .querySelector("#rechazar-todas")
      .addEventListener("click", () => this.rechazarTodas());
  },

  // Aceptar todas las cookies
  aceptarTodas() {
    Object.keys(this.cookieTypes).forEach((type) => {
      this.setCookie(this.cookieTypes[type].name, "true", 365);
    });
    this.setCookie("cookies_aceptadas", "true", 365);
    this.ocultarBanner();
  },

  // Aceptar solo las cookies seleccionadas
  aceptarSeleccionadas() {
    Object.keys(this.cookieTypes).forEach((type) => {
      const checkbox = document.querySelector(
        `#${this.cookieTypes[type].name}`
      );
      if (checkbox && checkbox.checked) {
        this.setCookie(this.cookieTypes[type].name, "true", 365);
      } else {
        this.setCookie(this.cookieTypes[type].name, "false", 365);
      }
    });
    this.setCookie("cookies_aceptadas", "true", 365);
    this.ocultarBanner();
  },

  // Rechazar todas las cookies excepto las necesarias
  rechazarTodas() {
    Object.keys(this.cookieTypes).forEach((type) => {
      if (!this.cookieTypes[type].required) {
        this.setCookie(this.cookieTypes[type].name, "false", 365);
      }
    });
    this.setCookie("cookies_aceptadas", "true", 365);
    this.ocultarBanner();
  },

  // Ocultar el banner
  ocultarBanner() {
    const banner = document.querySelector("#cookie-banner");
    if (banner) {
      banner.remove();
    }
  },

  // Establecer una cookie
  setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
  },

  // Obtener una cookie
  getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(";");
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) === " ") c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  },
};

// Inicializar el gestor de cookies cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  CookieManager.init();
});
