<?php
session_start();
include 'db_connection.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'men'");
    $stmt->execute();
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching products: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men</title>
    <link rel="stylesheet" href="men.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <style>
    .site-footer {
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

    /* Sliding banner styles */
    .sliding-banner {
        width: 100%;
        overflow: hidden;
        position: relative;
        margin: 40px 0;
    }

    .sliding-container {
        display: flex;
        animation: slide 30s linear infinite;
    }

    .sliding-container img {
        width: 300px;
        height: 400px;
        object-fit: cover;
        margin-right: 20px;
        filter: sepia(50%) saturate(85%) brightness(90%);
    }

    @keyframes slide {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-100%);
        }
    }

    /* Product overlay styles */
    .gallery-item .overlay-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-item:hover .overlay-content {
        opacity: 1;
        background: rgba(0,0,0,0.7);
    }

    .gallery-item .product-name {
        color: white;
        font-size: 1.1em;
        margin-bottom: 8px;
    }

    .gallery-item .product-price {
        color: white;
        font-weight: bold;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }

    .add-to-cart {
        background: black;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.3s ease;
    }

    .add-to-cart:hover {
        background: #333;
    }

    /* Gallery styles */
    .gallery {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        padding: 0 2rem;
    }

    .gallery-item {
        width: 100%;
        height: 100%;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #f5f5f5;
        padding: 30px;
        border-radius: 12px;
        max-width: 1000px;
        width: 90%;
        position: relative;
        display: flex;
        gap: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    .modal-image {
        flex: 1.2;
        max-width: 600px;
    }

    .modal-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .modal-details {
        flex: 0.8;
        padding: 20px 0;
    }

    .modal-details h2 {
        color: #4a7259;
        font-size: 28px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .modal-details p {
        color: #7c6755;
        font-size: 24px;
        margin-bottom: 25px;
        font-weight: 500;
    }

    .modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 28px;
        cursor: pointer;
        color: #7c6755;
        transition: color 0.3s ease;
    }

    .modal-close:hover {
        color: #4a7259;
    }

    /* Main gallery section */
    .main-gallery {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .main-gallery .gallery-row {
        display: grid;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .main-gallery .gallery-row:first-child {
        grid-template-columns: repeat(4, 1fr);
    }

    .main-gallery .gallery-row:last-child,
    .main-gallery .gallery-row.bottom-row {
        grid-template-columns: repeat(3, 1fr);
        justify-content: center;
    }

    .modal-buttons button {
        padding: 15px 30px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 16px;
        font-weight: 500;
    }

    .modal-buttons .add-to-cart {
        background-color: #4a7259;
        color: white;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .modal-buttons .add-to-cart:hover {
        background-color: #3d5d48;
        transform: translateY(-2px);
    }

    .modal-buttons .add-to-cart i {
        font-size: 18px;
    }
    </style>
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
                        <a href="register.php">Register</a>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Product Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div class="modal-image">
                <img id="modalImage" src="" alt="">
            </div>
            <div class="modal-details">
                <h2 id="modalName"></h2>
                <p id="modalPrice"></p>
                <div class="modal-buttons">
                    <button class="add-to-cart" id="modalAddToCart">
                        Add to Cart <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="main-gallery">
        <?php if (empty($products)): ?>
            <p style="text-align:center;">No men's products available.</p>
        <?php else: ?>
            <div class="gallery-row">
            <?php 
            $firstRow = array_slice($products, 0, 4);
            foreach ($firstRow as $product): 
            ?>
                <div class="gallery-item" onclick="showProductModal(this)" data-id="<?= $product['id']; ?>"
                    data-name="<?= htmlspecialchars($product['name']); ?>" data-price="<?= $product['price']; ?>"
                    data-image="<?= htmlspecialchars($product['image']); ?>">
                    <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                    <div class="overlay-content">
                        <p class="product-name"><?= htmlspecialchars($product['name']); ?></p>
                        <p class="product-price">$<?= number_format($product['price'], 2); ?></p>
                        <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(this)" data-id="<?= $product['id']; ?>"
                            data-name="<?= htmlspecialchars($product['name']); ?>" data-price="<?= $product['price']; ?>"
                            data-image="<?= htmlspecialchars($product['image']); ?>"
                            style="background: none; border: none; cursor: pointer;">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>

            <div class="gallery-row">
            <?php 
            $secondRow = array_slice($products, 4, 3);
            foreach ($secondRow as $product): 
            ?>
                <div class="gallery-item" onclick="showProductModal(this)" data-id="<?= $product['id']; ?>"
                    data-name="<?= htmlspecialchars($product['name']); ?>" data-price="<?= $product['price']; ?>"
                    data-image="<?= htmlspecialchars($product['image']); ?>">
                    <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                    <div class="overlay-content">
                        <p class="product-name"><?= htmlspecialchars($product['name']); ?></p>
                        <p class="product-price">$<?= number_format($product['price'], 2); ?></p>
                        <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(this)" data-id="<?= $product['id']; ?>"
                            data-name="<?= htmlspecialchars($product['name']); ?>" data-price="<?= $product['price']; ?>"
                            data-image="<?= htmlspecialchars($product['image']); ?>"
                            style="background: none; border: none; cursor: pointer;">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- Sliding Banner Section -->
    <div class="sliding-banner">
        <div class="sliding-container">
            <?php foreach ($products as $product): ?>
            <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
            <?php endforeach; ?>
            <?php foreach ($products as $product): ?>
            <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
            <?php endforeach; ?>
        </div>
    </div>

    <section class="main-gallery">
        <div class="gallery-row">
        <?php 
        $thirdRow = array_slice($products, 7, 4);
        foreach ($thirdRow as $product): 
        ?>
            <div class="gallery-item" onclick="showProductModal(this)" data-id="<?= $product['id']; ?>"
                data-name="<?= htmlspecialchars($product['name']); ?>" data-price="<?= $product['price']; ?>"
                data-image="<?= htmlspecialchars($product['image']); ?>">
                <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                <div class="overlay-content">
                    <p class="product-name"><?= htmlspecialchars($product['name']); ?></p>
                    <p class="product-price">$<?= number_format($product['price'], 2); ?></p>
                    <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(this)" data-id="<?= $product['id']; ?>"
                        data-name="<?= htmlspecialchars($product['name']); ?>" data-price="<?= $product['price']; ?>"
                        data-image="<?= htmlspecialchars($product['image']); ?>"
                        style="background: none; border: none; cursor: pointer;">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

        <div class="gallery-row">
        <?php 
        $fourthRow = array_slice($products, 11, 3);
        foreach ($fourthRow as $product): 
        ?>
            <div class="gallery-item" onclick="showProductModal(this)" data-id="<?= $product['id']; ?>"
                data-name="<?= htmlspecialchars($product['name']); ?>" data-price="<?= $product['price']; ?>"
                data-image="<?= htmlspecialchars($product['image']); ?>">
                <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                <div class="overlay-content">
                    <p class="product-name"><?= htmlspecialchars($product['name']); ?></p>
                    <p class="product-price">$<?= number_format($product['price'], 2); ?></p>
                    <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(this)" data-id="<?= $product['id']; ?>"
                        data-name="<?= htmlspecialchars($product['name']); ?>" data-price="<?= $product['price']; ?>"
                        data-image="<?= htmlspecialchars($product['image']); ?>"
                        style="background: none; border: none; cursor: pointer;">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </section>

    <div id="cart-toast"
        style="position: fixed; bottom: 20px; right: 20px; background: #8A6F5E; color: white; padding: 12px 20px; border-radius: 8px; display: none;">
        Item added to cart!
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

    <script src="js/cart.js"></script>
    <script>
        function showProductModal(element) {
            const modal = document.getElementById('productModal');
            const modalImage = document.getElementById('modalImage');
            const modalName = document.getElementById('modalName');
            const modalPrice = document.getElementById('modalPrice');
            const modalAddToCart = document.getElementById('modalAddToCart');

            modalImage.src = element.dataset.image;
            modalName.textContent = element.dataset.name;
            modalPrice.textContent = `$${parseFloat(element.dataset.price).toFixed(2)}`;
            
            modalAddToCart.onclick = function() {
                addToCart(element);
                modal.style.display = 'none';
            };

            modal.style.display = 'flex';
        }

        document.querySelector('.modal-close').onclick = function() {
            document.getElementById('productModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('productModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>