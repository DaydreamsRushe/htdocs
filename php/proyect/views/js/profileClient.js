/* Solamente definimos el cierre de sesion donde borraremos las variables de sesion que teniamos almacenadas */
document.addEventListener("DOMContentLoaded", () => {
  document.querySelector("#btn-cerrar").addEventListener("click", () => {
    localStorage.removeItem("userData");
    window.location.href = "index.php";
  });
});
