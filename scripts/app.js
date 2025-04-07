document.addEventListener("DOMContentLoaded", function () {
    let logo = document.querySelector("#logo_1");
    let searchIcon = document.querySelector(".fa-search"); 
    let searchBox = document.querySelector("#search");
    let locationDropdown = document.querySelector("#locate");
    let logged_in = false;
    let before_login = document.getElementsByClassName('before_login');
    let after_login = document.getElementsByClassName('after_login');
    function toggleElementVisibility(elementCollection) {
        const elements = Array.from(elementCollection); 
        elements.forEach(element => {
            if (element) {
                element.style.display = logged_in ? "block" : "none";
            }
        });
    }
    if (logged_in) {
        toggleElementVisibility(before_login); // Hide before_login elements
    } else {
        toggleElementVisibility(after_login); // Hide after_login elements
    }
    let currentLocations = [
        "Anand", "Vadodara", "Surat", "Bhavnagar", "Kutch", 
        "Nadiad", "Ahmedabad", "Rajkot", "Gandhinagar", "Jamnagar"
    ];

    if (logo) {
        logo.addEventListener("click", function () {
            window.location.href = "./index.html";
        });
    } else {
        console.error("Logo element not found!");
    }

    if (locationDropdown) {
        locationDropdown.innerHTML = "";
        currentLocations.forEach((city) => {
            let option = document.createElement("option");
            option.value = city;
            option.textContent = city;
            locationDropdown.appendChild(option);
        });
    } else {
        console.error("Location dropdown element not found!");
    }

    function search(){
        let searchQuery = searchBox.value.trim();
        
        if (searchQuery) {
            alert(`Searching for: ${searchQuery}`);
            window.location.href = "./search_result.html?q=" + searchQuery;
        } else {
            alert("Please enter a search term.");
        }
    }

    if (searchIcon && searchBox) {
        searchIcon.addEventListener("click", search);

        searchBox.addEventListener("keypress", (event)=>{
            if(event.key === "Enter"){
                search();
            }
        })
    } else {
        console.error("Search elements not found!");
    }
});