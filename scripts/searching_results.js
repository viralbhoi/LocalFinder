document.addEventListener('DOMContentLoaded', function() {
    // Get the query string from the current URL
    const queryString = window.location.search;

    // Create a URLSearchParams object
    const urlParams = new URLSearchParams(queryString);

    // Get the value of the 'q' parameter
    let product = urlParams.get('q');
    if(!product) {
        document.write("Unauthenticated user access denied");
    }
    // Update the page title with the product name
    document.getElementById("name").innerHTML += " For " + product;

    document.querySelectorAll('.product').forEach(productContainer => {
        const picElement = productContainer.querySelector('.pic');
        if (picElement) {
            picElement.addEventListener('click', function(event) {
                // Using product from query parameter
                window.location.href = `./sampleProductPage.html?product=${product}`;
            });
        }
    });
});
