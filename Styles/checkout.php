<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://khalti.com/static/khalti-checkout.js"></script>
</head>

<body>
    <nav>
        <div class="left">
            <ul>
                <li><a href="men.php">MEN</a></li>
                <li><a href="women.php">WOMEN</a></li>
                <li><a href="kid.php">KIDS</a></li>
            </ul>
        </div>
        <div class="middle">
            <a href="index.php"><img src="./assets/styles_logo.png" alt="Logo" /></a>
        </div>
        <div class="right">
            <ul>
                <li><i class="fa-solid fa-magnifying-glass"></i></li>
                <li><a href="checkout.php" class="fa-solid fa-cart-shopping"></a></li>
                <li class="user-icon">
                    <i class="fa-solid fa-user" onclick="toggleUserMenu()"></i>
                    <div class="user-menu" id="userMenu">
                        <?php if (isset($_SESSION['email'])): ?>
                        <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                        <form method="post" action="logout.php">
                            <button type="submit">Logout</button>
                        </form>
                        <?php else: ?>
                        <a href="login.php">Login</a>
                        <a href="regisstylehp">Register</a>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="cart-container">
        <h1>My Cart</h1>
        <div id="cart-items"></div>
        <p id="empty-cart-message">Your cart is empty!</p>
        <div class="checkout-section">
            <h2>Total: $<span id="total-price">0.00</span></h2>
            <div class="input-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" required />
            </div>
            <div class="input-group">
                <label for="location">Delivery Address:</label>
                <input type="text" id="location" required />
            </div>
            <div class="pMethod">
                <h2>Select Payment Option</h2>
                <button id="cod-button" value="COD">Place Order (Cash on Delivery)</button>
                <button id="khalti-button" value="Khalti">Pay with Khalti</button>
            </div>
            <div class="button-group">
                <a href="men.php" class="checkout-btn">Continue Shopping</a>
                <a href="#" class="checkout-btn" onclick="clearCart()">Clear Cart</a>
            </div>
        </div>
    </div>

    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>We are dedicated to providing quality fashion products while maintaining sustainable practices and ethical standards.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="men.php">Men's Collection</a></li>
                    <li><a href="women.php">Women's Collection</a></li>
                    <li><a href="kid.php">Kid's Collection</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: info@styles.com</p>
                <p>Phone: 9869081558</p>
                <p>Address: Kathmandu, Nepal</p>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <style>
    /* Global Styles */
    body {
        background-color: #f8f6f4;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    nav {
        padding: 10px 20px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 15px;
    }

    nav ul li a {
        text-decoration: none;
        color: #5a4336;
        font-weight: bold;
    }

    nav .user-menu {
        background: #fff;
        border: 1px solid #ccc;
        position: absolute;
        right: 0;
        top: 100%;
        display: none;
        border-radius: 8px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        padding: 10px;
    }

    nav .user-icon:hover .user-menu {
        display: block;
    }

    /* Cart Container */
    .cart-container {
        max-width: 60%;
        margin: 60px auto;
        background-color: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
        color: #5a4336;
    }

    .cart-container h1 {
        text-align: center;
        color: #8a6f5e;
        font-size: 48px;
        margin-bottom: 40px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        border-bottom: 1px solid #e2d6cb;
        padding-bottom: 15px;
    }

    .cart-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 25px;
    }

    .item-details h2 {
        margin: 0;
        color: #5a4336;
        font-size: 20px;
    }

    .item-details p {
        margin: 6px 0;
        color: #7d7066;
        font-size: 18px;
    }

    .quantity-controls {
        display: flex;
        gap: 10px;
        margin-top: 8px;
    }

    .quantity-btn {
        background-color: #fff;
        border: 2px solid #8a6f5e;
        color: #8a6f5e;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .quantity-btn:hover {
        background-color: #8a6f5e;
        color: white;
    }

    /* Checkout Section */
    .checkout-section {
        margin-top: 40px;
    }

    .checkout-section h2 {
        color: #5a4336;
        font-size: 26px;
        margin-bottom: 20px;
    }

    .input-group {
        margin: 20px 0;
    }

    .input-group label {
        font-weight: 600;
        display: block;
        color: #5a4336;
        margin-bottom: 6px;
        font-size: 16px;
    }

    .input-group input {
        width: 100%;
        max-width: 300px;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #d4c2b0;
        border-radius: 5px;
        background-color: #f4f1ee;
        color: #444;
    }

    .button-group {
        margin-top: 20px;
        text-align: center;
    }

    .checkout-btn {
        background-color: transparent;
        color: #8a6f5e;
        padding: 10px 20px;
        border: 2px solid #8a6f5e;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.3s ease, color 0.3s ease;
        margin: 10px;
        display: inline-block;
    }

    .checkout-btn:hover {
        background-color: #8a6f5e;
        color: #fff;
    }

    #empty-cart-message {
        text-align: center;
        color: #ff4d4d;
        font-size: 16px;
        margin-top: 20px;
    }

    /* Payment Options */
    .pMethod {
        text-align: center;
        margin: 20px 0;
    }

    .pMethod h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .pMethod button {
        padding: 10px 20px;
        font-size: 16px;
        border: 1px solid transparent;
        border-radius: 5px;
        cursor: pointer;
        margin: 10px;
        transition: background-color 0.3s, transform 0.2s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    #cod-button {
        background-color: #8a6f5e;
        color: #fff;
    }

    #cod-button:hover {
        background-color: #73584d;
    }

    #cod-button:active {
        transform: translateY(2px);
    }

    #khalti-button {
        background-color:#73584d;
        color: #fff;
    }

    #khalti-button:hover {
        background-color: #8a6f5e;
    }

    #khalti-button:active {
        transform: translateY(2px);
    }

    .site-footer {
        background-color: #f6f7f0;
        color: #7c6755;
        padding: 40px 0 20px;
        margin-top: 70px;
        border-top: 1px solid #7c6755;
        padding: 20px 0 10px;
        margin-top: 35px;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 40px;
        padding: 0 20px;
    }

    .footer-section {
        flex: 1;
        min-width: 250px;
    }

    .footer-section h3 {
        color: #4a7259;
        font-size: 20px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .footer-section p {
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .footer-section ul li a {
        color: #7c6755;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-section ul li a:hover {
        color: #4a7259;
    }

    .social-icons {
        display: flex;
        gap: 15px;
    }
    </style>

    <script>
    // ===== Cart Management =====
    const cart = JSON.parse(sessionStorage.getItem("cart") || "[]");
    const cartContainer = document.getElementById("cart-items");
    const emptyMessage = document.getElementById("empty-cart-message");
    const totalPriceEl = document.getElementById("total-price");
    let total = 0;

    function renderCart() {
        cartContainer.innerHTML = "";
        total = 0;
        if (cart.length === 0) {
            emptyMessage.style.display = "block";
            return;
        }
        emptyMessage.style.display = "none";
        cart.forEach((item, index) => {
            const subtotal = item.price * item.quantity;
            total += subtotal;
            const cartItem = document.createElement("div");
            cartItem.className = "cart-item";
            cartItem.innerHTML = `
          <img src="${item.image}" alt="${item.name}" />
          <div class="item-details">
            <h2>${item.name}</h2>
            <p>$${item.price.toFixed(2)} x ${item.quantity}</p>
            <div class="quantity-controls">
              <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
              <span class="quantity-value">${item.quantity}</span>
              <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
            </div>
          </div>`;
            cartContainer.appendChild(cartItem);
        });
        totalPriceEl.innerText = total.toFixed(2);
    }

    function updateQuantity(index, change) {
        cart[index].quantity += change;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        sessionStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
    }

    function clearCart() {
        sessionStorage.removeItem("cart");
        location.reload();
    }

    console.log("Cart before submitting:", cart);
    renderCart();

    // ===== Payment Processing Functions =====
    function placeOrderCOD() {
        const phone = document.getElementById("phone").value.trim();
        const locationVal = document.getElementById("location").value.trim();
        if (!phone || !locationVal || cart.length === 0) {
            alert("Please fill all details and ensure your cart is not empty.");
            return;
        }
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "place_order.php";
        const inputs = {
            phone_number: phone,
            customer_address: locationVal,
            total_amount: total.toFixed(2),
            payment_method: "COD",
            cart_data: JSON.stringify(cart)
        };
        for (const key in inputs) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = inputs[key];
            form.appendChild(input);
        }
        document.body.appendChild(form);
        form.submit();
    }

    // ===== Khalti Payment Integration =====
    var khaltiConfig = {
        publicKey: "test_public_key",
        productIdentity: "order_12345",
        productName: "Test Product",
        productUrl: "http://localhost/test-product",
        paymentPreference: [
            "KHALTI",
            "EBANKING",
            "MOBILE_BANKING",
            "CONNECT_IPS",
            "SCT"
        ],
        eventHandler: {
            onSuccess: function(payload) {
                console.log("Khalti Payment Successful", payload);
                alert("Khalti Payment Successful! Redirecting to confirmation.");
                placeOrderCOD();
            },
            onError: function(error) {
                console.log("Khalti Payment Error", error);
                alert("Khalti Payment Error. Please try again.");
            },
            onClose: function() {
                console.log("Khalti checkout widget is closed.");
            }
        }
    };
    var khaltiCheckout = new KhaltiCheckout(khaltiConfig);

    // ===== Payment Button Event Listeners =====
    document.getElementById("cod-button").addEventListener("click", function() {
        console.log("Selected Payment Method: COD");
        placeOrderCOD();
    });
    document.getElementById("khalti-button").addEventListener("click", function() {
        console.log("Selected Payment Method: Khalti");
        const phone = document.getElementById("phone").value.trim();
        const locationVal = document.getElementById("location").value.trim();
        if (!phone || !locationVal || cart.length === 0) {
            alert("Please fill all details and ensure your cart is not empty.");
            return;
        }
        khaltiCheckout.show({
            amount: 1000
        });
    });
    </script>
</body>

</html>