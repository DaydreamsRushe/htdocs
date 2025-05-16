document.addEventListener("DOMContentLoaded", () => {
  if (
    !localStorage.getItem("adminLoggedIn") ||
    localStorage.getItem("adminLoggedIn") === 0
  ) {
    window.location.href = "login.html";
  }

  document.querySelector("#logoutBtn").addEventListener("click", () => {
    localStorage.removeItem("adminLoggedIn");
    localStorage.removeItem("userLoggedIn");
    window.location.href = "login.html";
  });
});
