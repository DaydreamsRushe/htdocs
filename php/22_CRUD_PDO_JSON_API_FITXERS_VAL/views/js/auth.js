document.addEventListener("DOMContentLoaded", () => {
  //SESION CARGAR PAGINA
  /*   fetch('api.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ action: 'check_session' })
    })
      .then(res => res.json())
      .then(data => {
        if (!data.authenticated) {
          localStorage.removeItem("adminLoggedIn");
          window.location.href = "login.html";
        }
      })
      .catch(err => {
        console.error('Error verificando sesión:', err);
        window.location.href = "login.html";
      }); */
    
  //logout
  document.querySelector("#logoutBtn").addEventListener("click", () => {
    localStorage.removeItem("adminLoggedIn");
    window.location.href = "login.html";
  });
});