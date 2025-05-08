const loginForm = document.querySelector('#loginForm');
let errorEmailLogin = document.querySelector("#errorEmailLogin");
let errorPasswordLogin = document.querySelector("#errorPasswordLogin");
const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,9}$/;
const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#*])[a-zA-Z\d!@#*]{6,10}$/
document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.querySelector("#loginForm");

  if (localStorage.getItem("adminLoggedIn") === "true") {
    window.location.href = "index.html";
  }

  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    if (!validacionLogin()) return;

    let email = document.querySelector("#email").value;
    let password = document.querySelector("#password").value;


    //crear formdata y agregar datos
    const formData = new FormData();
    formData.append("action", "login");
    formData.append("email", email);
    formData.append("password", password);

    //enviar datos al servidor

    fetch("api.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la respuesta del servidor");
        }
        return response.text().then((text) => {
          console.log("Texto recibido del servidor:", text);
          try {
            return JSON.parse(text);
          } catch (e) {
            throw new Error("Respuesta invalida desde el servidor");
          }
        });
      })
      .then((data) => {
        if (data.success) {
          localStorage.setItem("adminLoggedIn", 'true');
          window.location.href = "index.html";
        }
      })
      .catch((error) => {
        alert("Error al intentar iniciar sesion: " + error.message);
      });
  });
});

const validacionLogin = () => {
  if (validacionEmailLogin() && validarPasswordLogin()) {
    console.log("formulario correcto");
    return true;
  } else {
    return false;
  }
}

const validacionEmailLogin = () => {

  let email = loginForm.email.value;

  if (email.trim() === "") {
    errorEmailLogin.style.color = 'red';

    return false;
  }
  else if (!email.match(emailRegex)) {
    errorEmailLogin.style.color = 'red';

    return false;
  } else {
    errorEmailLogin.style.color = 'green';
    return true;

  }

}


const validarPasswordLogin = () => {
  let password = loginForm.password.value;

  if (password.trim() === "") {
    errorPasswordLogin.style.color = 'red';

    return false;
  }
  else if (password.length > 20) {
    errorPasswordLogin.style.color = 'red';

    return false;
  } else {
    errorPasswordLogin.style.color = 'green';
    return true;
  }
}
