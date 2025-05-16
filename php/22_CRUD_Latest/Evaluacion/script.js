//Lo primero de todo, almacenamos en constantes los campos para:
//boton de crear nuevo registro
const btnInsertar = document.querySelector("#btnInsertar");
//boton de borrar los campos del formulario
const btnBorrar = document.querySelector("#btnBorrar");
//campo de formulario nombre, usuario, email, password, tipo_usuario y foto
const nombre = document.querySelector("#nombre");
const usuario = document.querySelector("#usuario");
const email = document.querySelector("#email");
const password = document.querySelector("#password");
const tipo_usuario = document.querySelector("#tipo_usuario");
const foto = document.querySelector("#foto");
//El campo donde se mostrara la tabla con todos los registros de la BBDD
const tablaDatos = document.querySelector("#tablaDatos");
//una variable para indicar si se esta editando un campo o no
let editandoEnCurso = false;
const content = document.querySelector(".content-wrapper");

//Funcion para mostrar tanto mensajes de error como mensajes de confirmacion cuando se realiza una funcion correctamente. El atributo esError indicara si este mensaje es un error o no
const mostrarMensaje = (mensaje, esError = false) => {
  // Crear el elemento de mensaje si no existe
  let mensajeElement = document.querySelector(".mensaje-usuario");
  if (!mensajeElement) {
    mensajeElement = document.createElement("div");
    mensajeElement.className = "mensaje-usuario";
    content.insertBefore(
      mensajeElement,
      document.querySelector(".table-container")
    );
  }
  //Introducimos el mensaje en el campo creado
  mensajeElement.textContent = mensaje;
  //le añadimos una clase dependiendo de si es un error o no.
  mensajeElement.className = `mensaje-usuario ${esError ? "error" : "exito"}`;

  //El mensaje se mostrara temporalmente durante 5 segundos y luego ira desapareciendo en medio segundo, cambiando su transparencia a 0 i finalmente desaparecer.
  setTimeout(() => {
    mensajeElement.style.opacity = "0";
    setTimeout(() => {
      mensajeElement.remove();
    }, 500);
  }, 5000);
};

//Al cargar la pagina, se mostraran los datos de la tabla y se inicializara los eventos
document.addEventListener("DOMContentLoaded", () => {
  cargarDatos();
  inicializarEventos();
});

//Esta funcion inicializa todos los eventos
const inicializarEventos = () => {
  //Evento para añadir los datos indicados en el formulario como nuevo registro
  document.querySelector("#formUsuario").addEventListener("submit", (e) => {
    e.preventDefault();
    insertarDato();
  });
  //Evento para todos los campos del formulario
  const camposFormulario = [
    { elemento: nombre, id: "nombre" },
    { elemento: usuario, id: "usuario" },
    { elemento: email, id: "email" },
    { elemento: password, id: "password" },
  ];
  //Estos eventos se activaran al presionar la tecla "Enter". Al hacerlo, se procedera a la accion de creacion de un nuevo registro
  camposFormulario.forEach((campo) => {
    campo.elemento.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        e.preventDefault();
        insertarDato();
      }
    });
  });

  //Evento del boton borrar para limpiar el formulario
  btnBorrar.addEventListener("click", restablecerFormulario);
};

//Esta función recoje los datos de nuestra base de datos y llama a la función que los muestra
const cargarDatos = async () => {
  try {
    const response = await fetch("api.php");
    const datos = await response.json();
    mostrarDatos(datos);
  } catch (error) {
    //Si falla al intentar recojer los datos, muestra un mensaje de error
    mostrarMensaje("Error al cargar los datos: " + error.message, true);
  }
};

//Esta función monta la estructura de cada registro de la base de datos que ha recibido como atributo
const mostrarDatos = (datos) => {
  //creamos una nueva fila en la tabla para cada dato recibido
  tablaDatos.innerHTML = "";
  datos.forEach((dato) => {
    const fila = document.createElement("tr");
    //Montamos la estructura con un campo para la id, para la foto (la cual sera la foto por defecto si no se ha añadido ninguna), el nombre, el nombre de usuario, el email y el tipo de usuario. Finalmente se añade un boton para borrar el registro y otro para editar sus campos.
    fila.innerHTML = `
            <td>${dato.id}</td>
            <td>
              <div class="user-photo-container">
                <img src="${dato.foto || "views/img/default-user.svg"}" 
                     alt="Foto de ${dato.nombre_apellidos}" 
                     class="user-photo"
                     onerror="this.src='views/img/default-user.svg'">
                <button class="btn-foto" data-id="${
                  dato.id
                }" title="Cambiar foto">📷</button>
              </div>
            </td>
            <td class="editable">${dato.nombre_apellidos}</td>
            <td class="editable">${dato.usuario}</td>
            <td class="editable">${dato.email}</td>
            <td class="tipo-usuario editable" data-tipo="${
              dato.tipo_usuario
            }">${dato.tipo_usuario === 1 ? "Editor" : "Registrado"}</td>
            <td>
              <button class="btn-borrar">Borrar</button>
              <button class="btn-guardar">Editar</button>
            </td>
        `;
    //Creamos un evento para el boton de borrar del registro
    const btnBorrar = fila.querySelector(".btn-borrar");
    btnBorrar.addEventListener("click", () => borrarDato(dato.id));

    //Creamos evento para el boton de edicion, o de guardado de edicion, dependiendo de si hay una edicion en curso
    const btnGuardar = fila.querySelector(".btn-guardar");
    btnGuardar.addEventListener("click", () => {
      if (btnGuardar.classList.contains("guardando")) {
        guardarCambios(dato.id, btnGuardar);
      } else {
        activarEdicion(fila);
      }
    });

    //Crea un evento para cambiar la foto, sin cambiar ninguno de los otros campos
    const btnFoto = fila.querySelector(".btn-foto");
    btnFoto.addEventListener("click", () => cambiarFoto(dato.id));
    //Añadimos esta estructura a la tabla
    tablaDatos.appendChild(fila);
  });
};

//Esta función sirve para cambiar la foto de los registros sin tener que activar la edición de este
const cambiarFoto = (id) => {
  //convierte el campo de la foto en un input que acepta archivos y las guarda en la carpeta de imagenes
  const input = document.createElement("input");
  input.type = "file";
  input.accept = "image/*";

  input.onchange = async (e) => {
    //el input es de tipo file, al cambiar seleccionamos el primer elemento
    const file = e.target.files[0];
    if (file) {
      // Validamos tamaño del archivo (máximo 2MB)
      if (file.size > 2 * 1024 * 1024) {
        mostrarMensaje("El archivo es demasiado grande. Máximo 2MB", true);
        return;
      }

      // Validar tipo de archivo, solo aceptaremos .jpeg, .png y .gif
      const tiposPermitidos = ["image/jpeg", "image/png", "image/gif"];
      if (!tiposPermitidos.includes(file.type)) {
        mostrarMensaje(
          "Tipo de archivo no permitido. Use JPEG, PNG o GIF",
          true
        );
        return;
      }

      //Creamos un FormData con solo la nueva foto y el id del registro, mas la accion de editar la foto
      const formData = new FormData();
      formData.append("foto", file);
      formData.append("id", id);
      formData.append("action", "update_foto");

      //Conectamos con el backend para que este realice el cambio en la base de datos
      try {
        const response = await fetch("api.php", {
          method: "POST",
          body: formData,
        });

        const resultado = await response.json();
        if (resultado.error) {
          mostrarMensaje(resultado.error, true);
        } else {
          mostrarMensaje("Foto actualizada correctamente");
          cargarDatos();
        }
      } catch (error) {
        mostrarMensaje("Error al actualizar la foto: " + error.message, true);
      }
    }
  };

  input.click();
};

//Esta funcion cuenta la cantidad de editores que hay en la tabla
const contarEditores = () => {
  const filas = document.querySelectorAll("#tablaDatos tr");
  let contador = 0;
  filas.forEach((fila) => {
    //miraremos uno por uno en la tabla los campos "tipo_usuario" de todos los registros y contaremos cuales son Editores
    const tipoUsuario = fila.querySelector(".tipo-usuario");
    if (tipoUsuario && tipoUsuario.textContent.trim() === "Editor") {
      contador++;
    }
  });
  //devuelve un numero con la cantidad de editores que hay en la tabla
  return contador;
};

//En esta funcion, usaremos la funcion anterior para saber si el limite de editores deseado se ha sobrepasado despues de una edicion o una inserción
const validarLimiteEditores = (nuevoTipo) => {
  const editoresActuales = contarEditores();
  if (nuevoTipo === "1" && editoresActuales >= 3) {
    mostrarMensaje(
      "No se pueden tener más de 3 editores. Convierta algún editor a tipo Registrado primero.",
      true
    );
    return false;
  }
  return true;
};

//Esta función activa un registro para edición
const activarEdicion = (fila) => {
  //si ya tenemos un registro editandose, no podemos editar otro, y lo indicamos con un error
  if (editandoEnCurso) {
    alert(
      "Por favor, guarde los cambios actuales antes de editar otro registro"
    );
    return;
  }
  editandoEnCurso = true;

  //convertimos los campos en editables
  const celdasEditables = fila.querySelectorAll(".editable");
  celdasEditables.forEach((celda) => {
    const valorActual = celda.textContent;
    celda.innerHTML = `<input type="text" value="${valorActual}" class="edit-input">`;
  });

  //Manejamos la celda del tipo usuario
  const celdaTipoUsuario = fila.querySelector(".tipo-usuario");
  const tipoUsuarioActual = celdaTipoUsuario.getAttribute("data-tipo") || "2";

  //Convertimos la celda de tipo usuario en select
  const selectHTML = `
        <select class="edit-input">
            <option value="2" ${
              tipoUsuarioActual === "2" ? "selected" : ""
            }>Registrado</option>
            <option value="1" ${
              tipoUsuarioActual === "1" ? "selected" : ""
            }>Editor</option>
        </select>
    `;
  celdaTipoUsuario.innerHTML = selectHTML;
  // Cambiamos el botón a Guardar
  const btnGuardar = fila.querySelector(".btn-guardar");
  btnGuardar.textContent = "Guardar";
  btnGuardar.classList.add("guardando");

  // Agregamos evento Enter a todos los inputs de la fila
  const inputs = fila.querySelectorAll(".edit-input");
  inputs.forEach((input) => {
    input.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        e.preventDefault(); // Prevenimos el comportamiento por defecto
        btnGuardar.click();
      }
    });
  });

  // Enfocamos el primer input
  const primerInput = fila.querySelector(".edit-input");
  if (primerInput) {
    primerInput.focus();
  }
};

//ESTA FUNCION SE HA MODIFICADO RESPECTO DE LA ORIGINAL
//Esta funcion confirma los cambios introducidos en el regitro que se ha activado anteriormente para edicion. A diferencia de la original aquí se validaran todos los valores de los campos para que tengan el formato correcto. De esta forma, evitamos que un registro se pueda modificar con formatos erroneos, despues de su inserción correcta.
const guardarCambios = async (id, boton) => {
  //Busca todos los campos que se han activado para edicion del registro del cual se ha apretado el boton de "Guardar"
  const fila = boton.closest("tr");
  const inputs = fila.querySelectorAll(".edit-input");
  //en la variable valores se almacenara la información de los nuevos valores del registro editado, despues de la validacion de cada uno
  const valores = {};

  //en el siguiente bucle se recojen el nombre de cada campo editable y el nuevo valor de este, introducido por el usuario antes de confirmar el guardado de datos
  for (const input of inputs) {
    const campo = input.closest("td").classList[0];
    const valor = input.value.trim();

    //cada valor del campo se valida a partir de la nueva funcion "validarCampoTabla"
    if (!validarCampoTabla(campo, valor)) {
      //se mostrara el mensaje en rojo indicando el primer de los campos (siguiendo su orden dentro del HTML) que tenga un formato erroneo
      mostrarMensaje(
        `El campo ${campo} no cumple con el formato requerido`,
        true
      );
      //si se encuentra un error se sale de la funcion y no se acaba de confirmar el cambio
      return;
    }
    //si no se ha encontrado error, se almacena el nuevo valor en la variable "valores" asociado al nombre de campo que le corresponda
    valores[campo] = valor;
  }

  //Por ultimo, guardamos en una constante a parte el valor del tipo de usuario, y comprobando en el caso de que sea un tipo EDITOR, que no sobrepasa el limite de editores deseado. Si este sobrepasa, se sale de la funcion con error.
  const tipoUsuario = fila.querySelector(".tipo-usuario select");
  if (tipoUsuario && !validarLimiteEditores(tipoUsuario.value)) {
    return;
  }

  //Una vez validado todos los valores correctamente, crea un FormData para almacenar todos los valores
  const formData = new FormData();
  formData.append("id", id);
  formData.append("nombre", valores.nombre);
  formData.append("usuario", valores.usuario);
  formData.append("email", valores.email);
  formData.append(
    "tipo_usuario",
    tipoUsuario ? tipoUsuario.value : valores.tipo_usuario
  );
  //añadiendo la acción = update para indicar a los archivos php que se trata de una edicion
  formData.append("action", "update");

  //ya con el FormData recojido, enviamos la información al backend(api.php) para que realice la edicion en la base de datos
  try {
    const response = await fetch("api.php", {
      method: "POST",
      body: formData,
    });

    //Esperamos una respuesta json del backend una vez termine la edicion
    const resultado = await response.json();
    //si el json contiene un campo de error, mostraremos este por pantalla para poder identificar la causa. Si esta todo correcto, se avisara al usuario de que se ha actualizado correctamente y se terminara la edicion del registro seleccionado
    if (resultado.error) {
      mostrarMensaje(resultado.error, true);
    } else {
      mostrarMensaje("Usuario actualizado correctamente");
      editandoEnCurso = false;
      cargarDatos();
    }
    //Si hay algun problema con la conexion con la api.php, enviaremos un mensaje con el error recibido
  } catch (error) {
    mostrarMensaje("Error al actualizar el usuario: " + error.message, true);
  }
};

const insertarDato = async () => {
  // Validar el formulario antes de proceder
  if (!validarFormulario()) {
    mostrarMensaje("Por favor, complete correctamente todos los campos", true);
    return;
  }

  //Guardamos en un objeto FormData toda la informacion introducida para registrar un nuevo usuario
  const formData = new FormData(document.querySelector("#formUsuario"));
  //añadiendo la accion de "create" para indicarle al backend que queremos introducir un nuevo registro
  formData.append("action", "create");
  //Conectamos de la misma forma que se aria como para editar registro
  try {
    const response = await fetch("api.php", {
      method: "POST",
      body: formData,
    });

    const resultado = await response.json();
    if (resultado.error) {
      mostrarMensaje(resultado.error, true);
    } else {
      mostrarMensaje("Usuario insertado correctamente");
      restablecerFormulario();
      cargarDatos();
    }
  } catch (error) {
    mostrarMensaje("Error al insertar el usuario: " + error.message, true);
  }
};

//Esta funcion borrara el registro seleccionado de la base de datos
const borrarDato = async (id) => {
  //Preguntamos al usuario antes de nada si de verdad quiere borrar el registro, si la respuesta es que no, salimos sin hacer cambios, si la respuesta es que si, continuamos.
  if (confirm("¿Está seguro de que desea borrar este registro?")) {
    try {
      const response = await fetch("api.php", {
        method: "POST",
        //indicamos que los datos a tratar se enviaran/recibiran en formato JSON
        headers: {
          "Content-Type": "application/json",
        },
        //solo enviamos la accion "delete" y el id del registro, dado que es lo unico que la base de datos necesita, ya que todos los registros tiene id unico
        body: JSON.stringify({
          action: "delete",
          id: id,
        }),
      });

      //esperamos a la respuesta en json y la almacenamos
      const resultado = await response.json();

      if (response.ok) {
        //si recibimos la respuesta correctamente, volvemos a cargar los registros de la BBDD
        cargarDatos();

        //si el resultado es correcto, mostramos mensaje de confirmación
        if (resultado.mensaje) {
          mostrarMensaje(resultado.mensaje);
          //si es erroneo, mostramos mensaje de error
        } else if (resultado.error) {
          mostrarMensaje(resultado.error, true);
        }
      } else {
        //si no recibimos la respuesta correctamente, mostramos un error en rojo
        mostrarMensaje(resultado.error || "Error al eliminar el usuario", true);
      }
    } catch (error) {
      //Tambien mostramos mensaje de error si la conexion con el backend falla
      mostrarMensaje("Error al eliminar el usuario: " + error.message, true);
    }
  }
};
