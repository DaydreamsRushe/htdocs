document.addEventListener("DOMContentLoaded", () => {
  //SESION CARGAR PAGINA
  if (sessionStorage.getItem("adminLoggedIn") !== "true") {
    window.location.href = "login.html";
  }

  //logout
  document.querySelector("#logoutBtn").addEventListener("click", () => {
    sessionStorage.removeItem("adminLoggedIn");
    window.location.href = "login.html";
  });
});
