const btnInsertar = document.querySelector("#btnInsertar");
const nombre = document.querySelector("#nombre");
const apellido = document.querySelector("#apellido");
const tablaDatos = document.querySelector("#tablaDatos");

//Listener para cargar los datos al iniciar la pagina
document.addEventListener("DOMContentLoaded", () => {
  cargarDatos();
  inicializarEventos();
});

//Inicializaremos todos los eventos
const inicializarEventos = () => {
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
    console.error("Errorum al cargar los datos:", error);
  }
};

//Mostrar datos en la tabla
const mostrarDatos = (datos) => {
  tablaDatos.innerHTML = "";

  console.log(datos);
  datos.forEach((dato) => {
    const fila = document.createElement("tr");
    fila.innerHTML = `
      <td>${dato.id}</td>
      <td class="editable">${dato.Nombres}</td>
      <td class="editable">${dato.Apellidos}</td>
      <td class="bot"><button class="btn-borrar">Borrar</button></td>
      <td class="bot"><button class="btn-guardar">Editar</button></td>
      `;

    //Agregamos eventos a los elementos de la fila
    const celdasEditables = fila.querySelectorAll(".editable");
    celdasEditables.forEach((celda) => {
      celda.addEventListener("click", () => activarEdicion(celda));
    });
    const btnBorrar = fila.querySelector(".btn-borrar");
    btnBorrar.addEventListener("click", () => borrarDato(datos.id));

    const btnGuardar = fila.querySelector(".btn-guardar");
    btnGuardar.addEventListener("click", () =>
      guardarCambios(datos.id, btnGuardar)
    );

    tablaDatos.appendChild(fila);
  });
};

//Activamos la edicion de una celda
const activarEdicion = (celda) => {
  const valorActual = celda.textContext;
  celda.innerHTML = `<input type="text" value="${valorActual}" class="edit-input">`;

  const input = celda.querySelector("input");
  input.focus;

  input.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      const btnGuardar = celda.closest("tr").querySelector(".btn-guardar");
      btnGuardar.click();
    }
  });
};

//Guardamos los cambios
const guardarCambios = async (id, boton) => {
  const fila = boton.closest("tr"); //recorro el elemento y sus padres hasta encontrar el que concuerda con el selector
  const nombre = fila.querySelector("td:nth-child(2) input").value;
  const apellido = fila.querySelector("td:nth-child(3) input").value;

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
      fila.querySelector("td:nth-child(2)").textContext = nombre;
      fila.querySelector("td:nth-child(3)").textContext = apellido;
    }
  } catch (error) {
    console.error("Errorum al actualizar el dato", error);
  }
};

const insertarDato = async () => {
  const nombre = document.querySelector("#nombre").value;
  const apellido = document.querySelector("#apellido").value;

  if (!nombre || !apellido) {
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
        nombre: nombre,
        apellido: apellido,
      }),
    });
    if (response.ok) {
      document.querySelector("#nombre").value = "";
      document.querySelector("#apellido").value = "";
      cargarDatos();
    }
  } catch (error) {
    console.error("Errorum al insetar el dato:", error);
  }
};

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
