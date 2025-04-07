forgotForm.addEventListener("submit", function (event) {
    let username = document.querySelector("#name").value.trim();

    let usernameRegex = /^[a-zA-Z0-9_]{5,15}$/;

    if (!usernameRegex.test(username)) {
        alert("Invalid username. Must be 5-15 characters long and can contain letters, numbers, and underscores.");
        event.preventDefault();
        return;
    }

    alert("If the username exists, a password reset link will be sent.");
});