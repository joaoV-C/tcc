const dropdownBtn = document.querySelector(".user.icon-btn");
const logoutRedirector = document.querySelector(".logout-redirector");
const logoutRedirectorForm = document.querySelector(".logout-redirector-form");
const adminRedirector = document.querySelector(".admin-redirector");
const adminRedirectorForm = document.querySelector(".admin-redirector-form");

const menuBtn = document.querySelector(".bars-menu-btn");

menuBtn.addEventListener("click", toggleMenuDropdown);
function toggleMenuDropdown() {
  const nav = document.querySelector(".navbar");
  nav.classList.toggle("show");
  console.log("alo");
}

dropdownBtn.addEventListener("click", toggleDropdown);
// Toggle dropdown visibility
function toggleDropdown() {
  const dropdown = document.getElementById("myDropdown");
  dropdown.classList.toggle("show");
}

if (logoutRedirector) {
  logoutRedirector.addEventListener("click", () =>
    logoutRedirectorForm.submit()
  );
}

if (adminRedirector) {
  adminRedirector.addEventListener("click", () => adminRedirectorForm.submit());
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

function emptyInputErrorDisplay(errorMessage) {
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

function priceInputErrorDisplay(priceErrorMessage) {
  const priceInput = document.querySelector(".price-input");

  const p = document.createElement("p");
  p.className = "error error-message";
  p.innerText = priceErrorMessage;

  priceInput.style.border = "2px solid #f02b2b";
  priceInput.style.padding = "2px";
  priceInput.after(p);
}

function bothErrorsDisplay(errorMessage, priceErrorMessage) {
  emptyInputErrorDisplay(errorMessage);
  priceInputErrorDisplay(priceErrorMessage);
}
