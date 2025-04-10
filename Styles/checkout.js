document.addEventListener("DOMContentLoaded", function () {
    // DOM Elements
    const cartItemsContainer = document.getElementById("cart-items");
    const totalPriceElement = document.getElementById("total-price");

    // Helper Functions
    function updateTotalPrice() {
        let total = 0;
        document.querySelectorAll(".cart-item").forEach(cartItem => {
            const price = parseFloat(cartItem.getAttribute("data-price"));
            const quantity = parseInt(cartItem.querySelector(".quantity-value").textContent);
            total += price * quantity;
        });
        totalPriceElement.textContent = total.toFixed(2);
    }

    function updateCartStorage(productId, newQty) {
        cart = cart.map(item => item.id === productId ? { ...item, quantity: newQty } : item);
        sessionStorage.setItem("cart", JSON.stringify(cart));
    }

    function attachQuantityHandlers() {
        const quantityControls = document.querySelectorAll(".quantity-controls");

        quantityControls.forEach((control) => {
            const decrement = control.querySelector(".decrement");
            const increment = control.querySelector(".increment");
            const quantityValue = control.querySelector(".quantity-value");

            decrement.addEventListener("click", () => {
                let quantity = parseInt(quantityValue.textContent);
                if (quantity > 1) {
                    quantityValue.textContent = --quantity;
                    updateCartStorage(control.closest(".cart-item").dataset.id, quantity);
                    updateTotalPrice();
                }
            });

            increment.addEventListener("click", () => {
                let quantity = parseInt(quantityValue.textContent);
                quantityValue.textContent = ++quantity;
                updateCartStorage(control.closest(".cart-item").dataset.id, quantity);
                updateTotalPrice();
            });
        });
    }

    // Cart Initialization
    let cart = JSON.parse(sessionStorage.getItem("cart")) || [];

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = "<p>Your cart is empty.</p>";
        return;
    }

    // Load Cart Products
    const productIds = cart.map(item => item.id);

    fetch("get_cart_products.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ ids: productIds })
    })
    .then(response => response.json())
    .then(products => {
        let total = 0;

        products.forEach(product => {
            const cartItem = cart.find(i => i.id === product.id.toString());
            const quantity = cartItem ? cartItem.quantity : 1;
            const subtotal = quantity * parseFloat(product.price);
            total += subtotal;

            const cartHtml = `
                <div class="cart-item" data-id="${product.id}" data-price="${product.price}">
                    <img src="${product.image}" alt="${product.name}" />
                    <div class="item-details">
                        <h2>${product.name}</h2>
                        <p>Price: $${product.price}</p>
                        <div class="quantity-controls">
                            <button class="quantity-btn decrement">-</button>
                            <span class="quantity-value">${quantity}</span>
                            <button class="quantity-btn increment">+</button>
                        </div>
                    </div>
                </div>
            `;
            cartItemsContainer.insertAdjacentHTML("beforeend", cartHtml);
        });

        totalPriceElement.textContent = total.toFixed(2);
        attachQuantityHandlers();
    });

    // Confirmation Functions
    window.showConfirmation = function () {
        document.querySelector(".cart-container").classList.add("hidden");
        document.getElementById("confirmation-section").classList.remove("hidden");
        document.getElementById("final-total").textContent = totalPriceElement.textContent;
    };

    // Checkout Handler
    document.getElementById("checkoutBtn").addEventListener("click", () => {
        const cart = JSON.parse(sessionStorage.getItem("cart")) || [];
        const location = document.getElementById("location").value.trim();

        if (cart.length === 0) {
            alert("Your cart is empty!");
            return;
        }

        if (!location) {
            alert("Please enter your delivery location.");
            return;
        }

        console.log("Cart data before placing order:", cart);
        console.log("Location data:", location);

        fetch("place_order.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ items: cart, location: location })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Order placed successfully! Order ID: " + data.order_id);
                sessionStorage.removeItem("cart");
                window.location.href = "thank_you.php";
            } else {
                alert("Order failed: " + data.message);
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
            alert("An error occurred while placing the order.");
        });
    });
});
