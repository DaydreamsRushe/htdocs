document.addEventListener("DOMContentLoaded", () => {
  /* En la pagina principal solo añadimos un evento para el boton de inicio de sesion */
  document.querySelector("#btn-sesion").addEventListener("click", () => {
    document.location.href = "login.php";
  });
});
