<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connection.php'; // $pdo is your PDO connection

// User must be logged in
if (!isset($_SESSION['user_id'])) {
header("Location: login.php");
exit();
}

// Validate order_id from URL
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
die("Invalid order.");
}

$order_id = $_GET['order_id'];

// Fetch order info from DB
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :id AND user_id = :user_id");
$stmt->execute([
':id' => $order_id,
':user_id' => $_SESSION['user_id']
]);

$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
die("Order not found.");
}

$products = json_decode($order['products'], true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <nav>
        <div></div>
        <div class="middle">
            <a href="index.php"><img src="./assets/styles_logo.png" alt="Logo" /></a>
        </div>
        <div class="right">
        </div>
    </nav>

    <div class="confirmation-container">
        <h1>Thank You for Your Order!</h1>

        <div class="order-meta">
            <p><strong>Order ID:</strong> #<?= htmlspecialchars($order_id) ?></p>
            <p><strong>Delivery Address:</strong> <?= htmlspecialchars($order['customer_address']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone_number']) ?></p>
            <p><strong>Order Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
        </div>

        <div class="product-list">
            <h2>Items Ordered:</h2>
            <?php foreach ($products as $item): ?>
            <div class="product">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" />
                <div class="product-info">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p>$<?= number_format($item['price'], 2) ?> × <?= $item['quantity'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <p class="total">Total Amount: $<?= number_format($order['total_amount'], 2) ?></p>

        <a href="index.php" class="back-btn">Back to Home</a>
    </div>

    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>Styles is your premier destination for fashion-forward clothing and accessories. We bring you the latest trends with quality and style.</p>
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
                <h3>Contact Info</h3>
                <ul>
                    <li>Email: info@styles.com</li>
                    <li>Phone: 9869081558</li>
                    <li>Address: 123 Fashion Street, Style City</li>
                </ul>
            </div>
        </div>
    </footer>

    <style>
    body {
        font-family: 'Quicksand', Arial, sans-serif;
        background-color: #f8f6f4;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .confirmation-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 40px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(138, 111, 94, 0.1);
        color: #5a4336;
        flex: 1;
    }

    h1 {
        color: #8a6f5e;
        font-size: 42px;
        text-align: center;
        margin-bottom: 30px;
        font-weight: 600;
    }

    .order-meta {
        margin-top: 30px;
        background: #faf7f5;
        padding: 20px;
        border-radius: 12px;
    }

    .order-meta label {
        font-size: 18px;
        color: #5a4336;
        font-weight: 600;
        display: block;
        margin-bottom: 5px;
    }

    .product-list {
        margin-top: 40px;
    }

    .product {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
        align-items: center;
        border-bottom: 1px solid #e2d6cb;
        padding-bottom: 15px;
        transition: transform 0.2s ease;
    }

    .product:hover {
        transform: translateX(10px);
    }

    .product img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .product-info {
        flex-grow: 1;
    }

    .product-info h3 {
        margin: 0;
        font-size: 22px;
        color: #5d4b3b;
        font-weight: 600;
    }

    .product-info p {
        margin: 8px 0;
        font-size: 18px;
        color: #8a6f5e;
    }

    .total {
        font-size: 24px;
        font-weight: bold;
        margin-top: 30px;
        color: #5d4b3b;
        text-align: right;
        padding: 20px;
        background: #faf7f5;
        border-radius: 12px;
    }

    .back-btn {
        display: inline-block;
        margin-top: 40px;
        padding: 16px 32px;
        border: 2px solid #8a6f5e;
        background: white;
        color: #8a6f5e;
        font-weight: 600;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        text-align: center;
    }

    .back-btn:hover {
        background-color: #8a6f5e;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(138, 111, 94, 0.2);
    }

    .site-footer {
        background-color: #f6f7f0;
        color: #7c6755;
        padding: 40px 0 20px;
        margin-top: 60px;
        border-top: 1px solid #7c6755;
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
    </style>

    <script>
    const cart = JSON.parse(sessionStorage.getItem("cart") || "[]");
    const invoiceDiv = document.getElementById("invoice-items");
    const totalSpan = document.getElementById("final-total");

    let total = 0;

    cart.forEach(item => {
        const itemDiv = document.createElement("div");
        itemDiv.innerHTML =
            `<strong>${item.name}</strong> (x${item.quantity}) - $${(item.price * item.quantity).toFixed(2)}`;
        invoiceDiv.appendChild(itemDiv);
        total += item.price * item.quantity;
    });
    totalSpan.innerText = total.toFixed(2);

    document.getElementById("cartData").value = JSON.stringify(cart);

    document.querySelector("form").addEventListener("submit", function() {
        sessionStorage.removeItem("cart");
        console.log("Cart has been cleared.");
    });
    </script>
</body>
</html>