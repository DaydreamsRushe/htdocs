//validacion Oscar

const regexNombre = /^[A-ZÀ]{1}[a-zA-ZÀ-ÿ\u00f1\u00d1\u00c7\s]{5,30}$/; //con caraceteres latinos

const regexUsuario = /^[a-zA-Z0-9]{5,8}$/;

const regexPassword =
  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#*])[a-zA-Z\d!@#*]{6,10}$/;

const emailRegex = /^[a-zA-Z0-9_]+@[a-zA-Z0-9_]+\.[a-zA-Z]{2,9}$/;

/* window.erroresValidacion = {
  errorNombre: document.querySelector("#errorNombre"),
  errorUsuario: document.querySelector("#errorUsuario"),
  errorEmail: document.querySelector("#errorEmail"),
  errorPassword: document.querySelector("#errorPassword"),
  errorTipo: document.querySelector("#errorTipo"),
  errorFoto: document.querySelector("#errorFoto"),
}; */

const validarFomularioLogin = () => {
  console.log("hola");

  const nombre = document.querySelector("#nombre").value.trim();
  const usuario = document.querySelector("#usuario").value.trim();
  const email = document.querySelector("#email").value.trim();
  const password = document.querySelector("#password").value;
  const foto = document.querySelector("#foto").files[0];

  if (!regexNombre.test(nombre)) {
    console.log("validando nombre");
    return false;
  }

  if (!regexUsuario.test(usuario)) {
    console.log("validando usuario");
    return false;
  }

  if (!emailRegex.test(email)) {
    console.log("validando email");
    return false;
  }

  if (!regexPassword.test(password)) {
    console.log("validando password");
    return false;
  }

  if (foto) {
    const tipoPermitidos = ["image/jpg", "image/png", "image/gif"];
    console.log("validando foto");
    if (!tipoPermitidos.includes(foto.type)) {
      return false;
    }

    if (foto.size > 2 * 1024 * 1024) {
      return false;
    }
  }

  return true;
};

const validarCampoTabla = (campo, valor) => {
  console.log("validando tabla");
  switch (campo) {
    case "nombre":
      return regexNombre.test(valor);
    case "usuario":
      return regexUsuario.test(valor);
    /* case "password":
      return !regexPassword.match(valor); */
    case "email":
      return emailRegex.test(valor);
    default:
      return true;
  }
};

const restablecerFormulario = () => {
  document.querySelector("#formUsuario").reset();
};
