const dropdownBtn = document.querySelector(".user.icon-btn");
const logoutRedirector = document.querySelector(".logout-redirector");
const logoutRedirectorForm = document.querySelector(".logout-redirector-form");
const adminRedirector = document.querySelector(".admin-redirector");
const adminRedirectorForm = document.querySelector(".admin-redirector-form");

dropdownBtn.addEventListener("click", toggleDropdown);

if (logoutRedirector) {
  logoutRedirector.addEventListener("click", () =>
    logoutRedirectorForm.submit()
  );
}

if (adminRedirector) {
  adminRedirector.addEventListener("click", () => adminRedirectorForm.submit());
}

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

function errorBorderCreator(errorMessage) {
  const inputError = document.querySelectorAll(".input-error");

  inputError.forEach((input) => {
    const p = document.createElement("p");
    p.className = "error error-message";
    p.innerText = errorMessage;

    input.style.border = "2px solid #f02b2b";
    input.style.padding = "2px";
    input.after(p);
  });
}
