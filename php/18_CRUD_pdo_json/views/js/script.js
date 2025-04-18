const btnInsertar = document.querySelector("#btnInsertar");
const nombre = document.querySelector("#nombre");
const apellido = document.querySelector("#apellido");
const tablaDatos = document.querySelector("#tablaDatos");
let editadndoEnCurso = false; //Variable para la edicion en curso

//Listener para cargar los datos al iniciar la pagina
document.addEventListener("DOMContentLoaded", () => {
  cargarDatos();
  inicializarEventos();
});

//Inicializaremos todos los eventos
const inicializarEventos = () => {
  //evento para el boton insertar
  btnInsertar.addEventListener("click", insertarDato);
  nombre.addEventListener("keypress", (e) => {
    if (e.key === "Enter") insertarDato();
  });
  apellido.addEventListener("keypress", (e) => {
    if (e.key === "Enter") insertarDato();
  });
};

//traemos los datos desde el servidor
const cargarDatos = async () => {
  try {
    const response = await fetch("api.php");
    const datos = await response.json();
    mostrarDatos(datos);
  } catch (error) {
    console.log("Errorum al cargar los datos:");
  }
};

//Mostrar datos en la tabla
const mostrarDatos = (datos) => {
  tablaDatos.innerHTML = "";
  datos.forEach((dato) => {
    const fila = document.createElement("tr");
    fila.innerHTML = `
      <td>${dato.id}</td>
      <td class="editable">${dato.Nombres}</td>
      <td class="editable">${dato.Apellidos}</td>
      <td><button class="btn-borrar">Borrar</button></td>
      <td><button class="btn-guardar">Editar</button></td>
      `;

    //Agregamos eventos a los elementos de la fila
    /* const celdasEditables = fila.querySelectorAll(".editable");
    celdasEditables.forEach((celda) => {
      celda.addEventListener("click", () => activarEdicion(celda));
    }); */
    const btnBorrar = fila.querySelector(".btn-borrar");
    btnBorrar.addEventListener("click", () => borrarDato(dato.id));

    const btnGuardar = fila.querySelector(".btn-guardar");
    btnGuardar.addEventListener("click", () => {
      if (btnGuardar.classList.contains("guardando")) {
        guardarCambios(dato.id, btnGuardar);
      } else {
        activarEdicion(fila);
      }
    });
    tablaDatos.appendChild(fila);
  });
};

//Activamos la edicion de una fila
const activarEdicion = (fila) => {
  if (editadndoEnCurso) {
    alert("Por favor guarde los cambios antes de editar othro registro");
    return;
  }
  editadndoEnCurso = true;
  const celdasEditables = fila.querySelectorAll(".editable");
  celdasEditables.forEach((celda) => {
    const valorActual = celda.textContent;
    celda.innerHTML = `<input type="text" value="${valorActual}" class="edit-input">`;
  });

  //Cambiamos el boton a Guardar
  const btnGuardar = fila.querySelector(".btn-guardar");
  btnGuardar.textContent = "Guardar";
  btnGuardar.classList.add("guardando");

  //agregamos evento ENTER a todos los inputs de la fila
  const inputs = fila.querySelectorAll(".edit-input");
  inputs.forEach((input) => {
    input.addEventListener("keypress", (e) => {
      if (e.key == "Enter") {
        e.preventDefault(); //prevenimos el comportamiento por defecto
        btnGuardar.click();
      }
    });
  });

  //enfocamos el primer input
  const primerInput = fila.querySelector(".edit-input");
  if (primerInput) {
    primerInput.focus();
  }
};

//Guardamos los cambios
const guardarCambios = async (id, boton) => {
  if (!boton.classList.contains("guardando")) {
    return;
  }

  const fila = boton.closest("tr"); //recorro el elemento y sus padres hasta encontrar el que concuerda con el selector
  const nombre =
    fila.querySelector("td:nth-child(2) input")?.value ||
    fila.querySelector("td:nth-child(2)").textContent;
  const apellido =
    fila.querySelector("td:nth-child(3) input")?.value ||
    fila.querySelector("td:nth-child(3)").textContent;

  try {
    const response = await fetch("api.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        action: "update",
        id: id,
        nombre: nombre,
        apellido: apellido,
      }),
    });

    if (response.ok) {
      //converimaos los inputs de nuevo a texto
      nombre.value = "";
      apellido.value = "";
      cargarDatos();

      //Restauramos el boton a editar
      boton.textContent = "Editar";
      boton.classList.remove("guardando");
      editadndoEnCurso = false;
    }
  } catch (error) {
    console.error("Errorum al actualizar el dato", error);
  }
};

//Funcion de insertar un nuevo Usuario
const insertarDato = async () => {
  const nom = nombre.value;
  const ap = apellido.value;

  if (!nom || !ap) {
    alert("Por favor, complete todos los campos");
    return;
  }

  try {
    const response = await fetch("api.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        action: "create",
        nombre: nom,
        apellido: ap,
      }),
    });

    if (response.ok) {
      nombre.value = "";
      apellido.value = "";
      cargarDatos();
    }
  } catch (error) {
    console.error("Errorum al insetar el dato:", error);
  }
};

//funacion para borrar un dato
const borrarDato = async (id) => {
  if (confirm("¿Esta seguro de que desea borrar este registro?")) {
    try {
      const response = await fetch("api.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          action: "delete",
          id: id,
        }),
      });

      if (response.ok) {
        cargarDatos();
      }
    } catch (error) {
      console.error("ERRORUM al borrar el dato:", error);
    }
  }
};
