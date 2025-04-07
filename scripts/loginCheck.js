document.getElementById("login_form").addEventListener("submit", function (event) {
    if (!validateForm(event)) {
      event.preventDefault(); 
    }
  });

document.addEventListener("DOMContentLoaded", function () {
    let loginForm = document.querySelector("form[name='login_form']");

    loginForm.addEventListener("submit", function (event) {
        let username = document.querySelector("#name").value.trim();
        let password = document.querySelector("#pass1").value.trim();
        let usernameRegex = /^[a-zA-Z0-9_]{3,15}$/;
        let passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        if (!usernameRegex.test(username)) {
            alert("Invalid username. Must be 3-15 characters long and can contain letters, numbers, and underscores.");
            event.preventDefault();
            return;
        }

        if (!passwordRegex.test(password)) {
            alert("Invalid password. Must be at least 8 characters long and contain at least one letter and one number.");
            event.preventDefault();
            return;
        }
        //yet not implemented data fetching and checking
        alert("Login successful!");
    });
});