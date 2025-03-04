let logged_in = false;

function performSearch() {
    const searchTerm = document.getElementById("search").value.toLowerCase();
    alert(`Searching for: ${searchTerm} (This is just a prototype)`);
    // yet to complete because of not implemented backend support
}

function toggleElementVisibility(elementCollection) {
    const elements = Array.from(elementCollection); 
    elements.forEach(element => {
        if (element) {
            element.style.display = logged_in ? "block" : "none";
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    let before_login = document.getElementsByClassName('before_login');
    let after_login = document.getElementsByClassName('after_login');
    
    if (logged_in) {
        toggleElementVisibility(before_login); // Hide before_login elements
    } else {
        toggleElementVisibility(after_login); // Hide after_login elements
    }

    const searchInput = document.getElementById("search");
    if (searchInput) {
        searchInput.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                performSearch();
                event.preventDefault();
            }
        });
    }
});
