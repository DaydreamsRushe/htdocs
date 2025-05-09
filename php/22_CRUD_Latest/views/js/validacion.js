const regexNombre = /^[a-zA-ZA-y\u00f1\u00d1\u00e7\u00c7\s]{5,30}$/;
const regexUsuario = /^[a-zA-Z0-9]{5,8}$/;
const regexPassword =
  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[*!@#])[A-Za-z\d*!@#]{6,10}$/;
const regexEmail =
  /^[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,9}/;

const validarFormulario = () => {

  const nombre = document.getElementById("nombre").value.trim();
  const usuario = document.getElementById("usuario").value.trim();
  const password = document.getElementById("password").value;
  const email = document.getElementById("email").value.trim();
  const foto = document.querySelector("#foto").files[0];

  if (!regexNombre.test(nombre)) {
    return false;
    // console.log("eeror en el nombre");
  }

  if (!regexUsuario.test(usuario)) {
    return false;
  }

  if (!regexEmail.test(email)) {
    return false;
  }

  if (!regexPassword.test(password)) {
    return false;
  }

  if (foto) {
    const tiposPermitidos = ["image/jpeg", "image/png", "image/gif"];

    if (!tiposPermitidos.includes(foto.type)) {
      return false;
    }

    if (foto.size > 2 * 1024 * 2024) {
      return false;
    }
  }

  return true;
};

const validarCampoTabla = (campo, valor) => {
  switch (campo) {
    case "nombre":
      return regexNombre.test(valor);
    case "usuario":
      return regexUsuario.test(valor);
    case "email":
      return regexEmail.test(valor);
    // case "password":
    //   return regexPassword.test(valor);
    default:
      return true;
  }
};

const restablecerFormulario = () => {
  document.querySelector("#formUsuario").reset();
};
