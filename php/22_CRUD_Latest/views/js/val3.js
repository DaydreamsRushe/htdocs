document.addEventListener("DOMContentLoaded", () => {
    const formulario = document.querySelector("#formUsuario");
    const btnBorrar = document.querySelector("#btnBorrar");
  
    formulario.addEventListener("submit", function (e) {
      if (!validarFormulario()) {
        e.preventDefault();
      }
    });
  
    btnBorrar.addEventListener("click", restablecerFormulario);
  
    // const campos = ["nombre", "usuario", "email", "password", "foto"];
    const campos = ["nombre", "usuario", "email", "password", "foto"];
    campos.forEach(id => {
      const campo = document.querySelector(`#${id}`);
      campo.addEventListener(id === "foto" ? "change" : "input", () => {
        validarCampoIndividual(campo);
      });
    });
  });
  
  function validarFormulario() {
    const campos = [
      document.querySelector("#nombre"),
      document.querySelector("#usuario"),
      document.querySelector("#email"),
      document.querySelector("#password"),
      document.querySelector("#foto"),
    ];
  
    let valido = true;
    limpiarErrores();
  
    campos.forEach(campo => {
      if (!validarCampoIndividual(campo)) {
        valido = false;
      }
    });
  
    return valido;
  }
  
  function validarCampoIndividual(campo) {
    const emailRegex = /^[a-z0-9_-]+([.][a-z0-9_-]+)*@[a-z0-9_]+([.][a-z0-9_]+)*[.][a-z]{2,9}$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#*!])[a-zA-Z\d!@#*]{6,10}$/;
    const nombreyUsuarioRegex = /^[a-zA-Z\u00f1\u00d1\u00e7\u00c7\s]$/;
    const valor = campo.value.trim();
    const id = campo.id;
  
    let mensaje = "";
  
    switch (id) {
      case "nombre":
        if (!valor) mensaje = "El nombre es obligatorio";
        else if (valor.length < 5 || valor.length > 30) mensaje = "El nombre debe tener entre 5 y 30 caracteres, una o mas Mayusculas, no puede contener numeros";
        // else if (!nombreyUsuarioRegex.test(valor)) mensaje = "El nombre contiene caracteres inválidos xx";
        break;
      case "usuario":
        if (!valor) mensaje = "El usuario es obligatorio";
        else if (valor.length < 5 || valor.length >8) mensaje = "El usuario debe tener entre 5 y 8 caracteres, puede contener numeros y letras";
        break;
      case "email":
        if (!valor) mensaje = "El email es obligatorio";
        else if (!emailRegex.test(valor)) mensaje = "Correo electrónico inválido";
        break;
      case "password":
        if (!valor) mensaje = "La contraseña es obligatoria";
        else if (!passwordRegex.test(valor)) {
          mensaje = "La contraseña debe contener: mínimo 8 caracteres, 1 mayúscula, 1 número y 1 símbolo (@#*!)";
        }
        break;
      case "foto":
        if (campo.files.length > 0) {
          const file = campo.files[0];
          const tiposPermitidos = ["image/jpeg", "image/png", "image/gif"];
          if (!tiposPermitidos.includes(file.type)) mensaje = "Formato de imagen no permitido";
          else if (file.size > 2 * 1024 * 1024) mensaje = "Imagen mayor a 2MB";
        }
        break;
    }
  
    mostrarOMostrarError(campo, mensaje);
    return mensaje === "";
  }
  
  function mostrarOMostrarError(campo, mensaje) {
    eliminarError(campo);
    if (mensaje) {
      const error = document.createElement("div");
      error.className = "error-mensaje";
      error.textContent = mensaje;
      campo.parentNode.appendChild(error);
      campo.classList.add("input-error");
    } else {
      campo.classList.remove("input-error");
    }
  }
  
  function eliminarError(campo) {
    const error = campo.parentNode.querySelector(".error-mensaje");
    if (error) error.remove();
  }
  
  function limpiarErrores() {
    document.querySelectorAll(".error-mensaje").forEach(el => el.remove());
    document.querySelectorAll(".input-error").forEach(el => el.classList.remove("input-error"));
  }
  
  function restablecerFormulario() {
    document.querySelector("#formulario").reset();
    document.querySelector("#tipo_usuario").value = "2";
    limpiarErrores();
  
  }
  