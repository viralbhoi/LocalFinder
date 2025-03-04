let cartIcon = document.querySelector("#shopping-cart");
let cart = document.querySelector("#cart-content");
let cartClose = document.querySelector("#close");
let addToCartBtn = document.querySelectorAll("#Add-to-cart");
console.log(addToCartBtn);

cartIcon.addEventListener("click", () => {
    cart.classList.add("active");
});

cartClose.addEventListener("click", () => {
    cart.classList.remove("active");
});

addToCartBtn.forEach((button) => {
    button.addEventListener("click", (event) => {
        let productBox = event.target.closest("#product-box");
        addToCart(productBox);
    });
});

function addToCart(productBox) {
    let imageSrc = document.querySelector("#product-image").src;
    let productTitle = document.querySelector("#product-name").textContent;
    let productPrice = document.querySelector("#product-price").textContent;

    let elem = document.createElement("div");

    let cart_content = document.querySelector(".cart-elem");
    let cartItems = document.querySelectorAll(".cart-product-title");
    console.log(cartItems);

    for (let item of cartItems) {
        console.log("item =", item.textContent);
        console.log(productTitle);
        console.log(productTitle == item.textContent);
        if (item.textContent == productTitle) {
            alert("This item is already in cart");
            return;
        }
    }

    elem.classList.add("cart-box");

    elem.innerHTML = `
  <img src="${imageSrc}" class="cart-img">
  <div class="cart-detail">
    <h2 class="cart-product-title">${productTitle}</h2>
    <span class="cart-price">$${productPrice}</span>
    <div id="qty-select">
      <button id="qty-minus">-</button>
      <span id="qty">1</span>
      <button id="qty-plus">+</button>
    </div>
    </div>
    <i class="fa fa-trash" aria-hidden="true" id="deleteBtn"></i>
  `;

    cart_content.appendChild(elem);

    elem.querySelector("#deleteBtn").addEventListener("click", () => {
        elem.remove();
        updateTotal();
    });

    elem.querySelector("#qty-select").addEventListener("click", (event) => {
        let itemCountBox = elem.querySelector("#qty");
        let decBtn = elem.querySelector("#qty-minus");

        let quantitiy = itemCountBox.textContent;

        if (event.target.id === "qty-minus" && quantitiy > 1) {
            quantitiy--;
            if (quantitiy == 1) {
                decBtn.style.background = "#ccc";
            }
        } else if (event.target.id === "qty-plus") {
            quantitiy++;
            decBtn.style.background = "#333";
        }

        itemCountBox.textContent = quantitiy;
        updateTotal();
    });

    updateTotal();
}



function updateTotal() {
  let totalPrice = document.querySelector("#total-price");
  let elems = document.querySelectorAll(".cart-box");

  let total = 0;

  elems.forEach((elem) =>{
    let priceElem = elem.querySelector(".cart-price");
    let price = priceElem.textContent.replace('$','');
    let quantitiyElem = elem.querySelector("#qty");
    let quantitiy = quantitiyElem.textContent;

    total += price * quantitiy;
  })

  totalPrice.textContent = `$${total}`; 
}
