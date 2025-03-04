document.addEventListener("DOMContentLoaded", function () {
    let logo = document.querySelector("#logo_1");
    let searchIcon = document.querySelector(".fa-search"); 
    let searchBox = document.querySelector("#search");
    let locationDropdown = document.querySelector("#locate");

    let currentLocations = [
        "Anand", "Vadodara", "Surat", "Bhavnagar", "Kutch", 
        "Nadiad", "Ahmedabad", "Rajkot", "Gandhinagar", "Jamnagar"
    ];

    if (logo) {
        logo.addEventListener("click", function () {
            window.location.href = "/index.html";
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