document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.querySelector("#loginForm");

  if (localStorage.getItem("adminLoggedIn") === "true") {
    window.location.href = "index.html";
  }

  const regexEmail =
    /^[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,9}/;
  // /^[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)+$/;
  const regexPassword =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[*!@#])[A-Za-z\d*!@#]{6,10}$/;

  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const email = document.querySelector("#email").value;
    const password = document.querySelector("#password").value;

    if (password.length < 6) {
      alert("La contraseña debe tener al menos 6 caracteres");

      if (!regexEmail.test(email)) {
        alert("cliente! La contraseña debe tener al menos 6 caracteres");
        return;
      }

      if (!regexPassword.test(password)) {
        alert("cliente! Contrasena tiene...");
      }
      return;
    }

    const formData = new FormData();
    formData.append("action", "login");
    formData.append("email", email);
    formData.append("password", password);

    fetch("api.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la respuesta del servidor");
        }
        return response.text().then((text) => {
          try {
            return JSON.parse(text);
          } catch (e) {
            throw new Error("respuesta invalida desde el servidor");
          }
        });
      })
      .then((data) => {
        if (data.success) {
          localStorage.setItem("adminLoggedIn", data.tipo_usuario);
          localStorage.setItem("userLoggedIn", data.user);
          window.location.href = "index.html";
        } else {
          alert(data.error || "Credenciales incorrectas");
        }
      })
      .catch((error) => {
        alert("Error al intentar iniciar sesion: " + error.message);
      });
  });
});
