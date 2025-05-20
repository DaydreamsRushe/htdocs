// Expresiones regulares para validación
const regexNombre = /^[a-zA-ZÀ-ÿ\u00f1\u00d1\u00e7\u00c7\s]{5,30}$/;
const regexUsuario = /^[a-zA-Z0-9]{5,8}$/;
const regexPassword =
  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#*])[a-zA-Z\d!@#*]{6,10}$/;
/* const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; */
const regexEmail =
  /[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,9}/;

const validarFormulario = () => {
  /*   return true; */

  // Obtener los valores de los campos
  const nombre = document.querySelector("#nombre").value.trim();
  const usuario = document.querySelector("#usuario").value.trim();
  const email = document.querySelector("#email").value.trim();
  const password = document.querySelector("#password").value;
  const foto = document.querySelector("#foto").files[0];

  // Validar nombre
  if (!regexNombre.test(nombre)) {
    return false;
  }

  // Validar usuario
  if (!regexUsuario.test(usuario)) {
    return false;
  }

  // Validar email
  if (!regexEmail.test(email)) {
    return false;
  }

  // Validar contraseña
  if (!regexPassword.test(password)) {
    return false;
  }

  // Si se ha subido una foto, validar su tipo y tamaño
  if (foto) {
    // Validar tipo de archivo de la foto
    const tiposPermitidos = ["image/jpeg", "image/png", "image/gif"];
    if (!tiposPermitidos.includes(foto.type)) {
      return false;
    }

    // Validar tamaño de la foto (máximo 2MB)
    if (foto.size > 2 * 1024 * 1024) {
      return false;
    }
  }

  return true;
};

// Función para validar campos en la tabla
const validarCampoTabla = (campo, valor) => {
  /*   return true; */

  switch (campo) {
    case "nombre":
      return regexNombre.test(valor);
    case "usuario":
      return regexUsuario.test(valor);
    case "email":
      return regexEmail.test(valor);
    default:
      return true;
  }
};

// restablecer el formulario
const restablecerFormulario = () => {
  document.querySelector("#formUsuario").reset();
};
