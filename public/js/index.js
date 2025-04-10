const dropdownBtn = document.querySelector(".user.icon-btn");
const logoutRedirector = document.querySelector(".logout-redirector");
const logoutRedirectorForm = document.querySelector(".logout-redirector-form");

dropdownBtn.addEventListener("click", toggleDropdown);

logoutRedirector.addEventListener("click", () => logoutRedirectorForm.submit());

// Toggle dropdown visibility
function toggleDropdown() {
  const dropdown = document.getElementById("myDropdown");
  dropdown.classList.toggle("show");
}

// Close dropdown when clicking outside
window.onclick = function (event) {
  if (!event.target.matches(".user") && !event.target.matches(".fa-user")) {
    const dropdowns = document.getElementsByClassName("dropdown-content");
    for (let i = 0; i < dropdowns.length; i++) {
      const openDropdown = dropdowns[i];
      if (openDropdown.classList.contains("show")) {
        openDropdown.classList.remove("show");
      }
    }
  }
};
