document.addEventListener("DOMContentLoaded", () => {
  document.querySelector("#btn-cerrar").addEventListener("click", () => {
    localStorage.removeItem("userData");
    redirectToLogin();
  });
});

