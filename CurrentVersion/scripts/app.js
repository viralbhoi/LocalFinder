document.addEventListener("DOMContentLoaded", () => {
    const logo = document.querySelector("#logo_1");
    const searchIcon = document.querySelector(".fa-search");
    const searchBox = document.querySelector("#search");
    const locationDropdown = document.querySelector("#locate");

    // Logo click → homepage
    if (logo) {
        logo.addEventListener("click", () => {
            window.location.href = "./index.php";
        });
    }

    // Perform search logic
    const performSearch = () => {
        const query = searchBox?.value.trim();
        const location = locationDropdown?.value;

        if (!query) return alert("Please enter a search term.");
        if (!location) return alert("Please select a location.");

        window.location.href = `./search.php?query=${encodeURIComponent(query)}&location=${encodeURIComponent(location)}`;
    };

    if (searchIcon && searchBox) {
        searchIcon.addEventListener("click", performSearch);
        searchBox.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                performSearch();
            }
        });
    }

    // Dropdown toggle logic
    const avatar = document.getElementById("user-avatar");
    const dropdown = document.getElementById("dropdown-content");

    if (avatar && dropdown) {
        avatar.addEventListener("click", () => {
            dropdown.style.display = dropdown.style.display === "flex" ? "none" : "flex";
        });

        window.addEventListener("click", (e) => {
            if (!e.target.closest("#user-profile-container")) {
                dropdown.style.display = "none";
            }
        });
    }

    // Toggle login/register vs profile UI
    const beforeLogin = document.querySelectorAll('.before_login');
    const afterLogin = document.querySelectorAll('.after_login');

    beforeLogin.forEach(el => el.style.display = logged_in ? "none" : "block");
    afterLogin.forEach(el => el.style.display = logged_in ? "flex" : "none");
});
