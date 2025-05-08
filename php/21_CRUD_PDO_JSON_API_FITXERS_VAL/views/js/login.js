document.addEventListener("DOMContentLoaded", () => {
  const loginform = document.querySelector("#loginForm");
  //verificamos si ya esta logueado en localstorage
  if (localStorage.getItem("adminLoggedIn") === "true") {
    window.location.href = "index.html";
  }

  loginform.addEventListener("submit", (e) => {
    e.preventDefault();
    const email = document.querySelector("#email").value;
    const password = document.querySelector("#password").value;

    //Validacion basica
    if (password.length < 6) {
      alert("La contraseña debe tener al menos 6 caracteres");
      return;
    }

    //Crear FormData y agregar los datos
    const formData = new FormData();
    formData.append("action", "login");
    formData.append("email", email);
    formData.append("password", password);

    //Enviar datos al servidor
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
            throw new Error("Respuesta invalidada del servidor");
          }
        });
      })
      .then((data) => {
        if (data.success) {
          localStorage.setItem("adminLoggedIn", "true");
          window.location.href = "index.html";
        } else {
          alert(data.error || "Credenciales incorrectas");
        }
      })
      .catch((error) => {
        alert("Error al intentar iniciar la sesion " + error.message);
      });
  });
});
