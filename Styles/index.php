<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db_connection.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'women'");
    $stmt->execute();
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching products: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Styles</title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300..700&display=swap"
        rel="stylesheet" />

    <script>
    function toggleUserMenu() {
        const menu = document.getElementById("userMenu");
        if (menu.style.display === "block") {
            menu.style.transition = "opacity 0.3s ease-out";
            menu.style.opacity = "0";
            setTimeout(() => {
                menu.style.display = "none";
            }, 300);
        } else {
            menu.style.display = "block"; 
            menu.style.transition = "opacity 0.3s ease-in";
            menu.style.opacity = "1";
        }
    }

    window.onclick = function(event) {
        const menu = document.getElementById("userMenu");
        if (!event.target.matches('.user-icon') && !event.target.closest('#userMenu')) {
            if (menu.style.display === "block") {
                menu.style.transition = "opacity 0.3s ease-out";
                menu.style.opacity = "0";
                setTimeout(() => {
                    menu.style.display = "none";
                }, 300);
            }
        }
    };
    </script>

    <style>
    /* User Menu Styles */
    .user-menu {
        display: none;
        position: absolute;
        top: 60px;
        right: 10px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        width: 200px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 999;
    }

    .user-menu-content {
        text-align: center;
    }

    .user-menu h3 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #4b7b5f;
    }

    .user-menu p {
        font-size: 14px;
        color: #6a6a6a;
        margin-bottom: 20px;
    }

    .small-text {
        font-size: 12px;
        color: #8a6f5e;
        margin: 5px 0;
    }

    .user-menu .login-register-btn {
        display: block;
        width: 100%;
        padding: 12px;
        margin: 5px 0;
        text-align: center;
        background-color: #8a6f5e;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .user-menu .login-register-btn:hover {
        background-color: #7a5e4d;
    }

    .user-menu .register {
        background-color: #f4f1ee;
        color: #8a6f5e;
        border: 2px solid #8a6f5e;
    }

    .user-menu .register:hover {
        background-color: #8a6f5e;
        color: #fff;
    }

    .user-menu .logout-btn {
        background-color: #e74c3c;
        color: white;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        padding: 8px;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    .user-menu .logout-btn:hover {
        background-color: #c0392b;
    }

    .btn-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* User Icon Styles */
    .user-icon i {
        font-size: 1.5rem;
        cursor: pointer;
        color: #333;
        margin-right: 5px;
    }

    .user-icon span {
        font-size: 14px;
        color: #333;
        font-weight: bold;
    }

    .user-icon a {
        display: flex;
        align-items: center;
        color: #333;
        text-decoration: none;
    }

    .user-icon a:hover {
        color: #7a5e4d;
    }

    /* Product Card Styles */
    .product_cards {
        padding: 40px;
        background-color: #fff;
    }

    .title_text {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        color: #34553d;
        margin-bottom: 32px;
    }

    .product-row {
        display: flex;
        justify-content: center;
        gap: 40px;
        flex-wrap: wrap;
    }

    .product-card {
        background-color: #fdfdfb;
        border-radius: 16px;
        padding: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        text-align: center;
        transition: transform 0.3s ease;
        width: 300px;
    }

    .product-card:hover {
        transform: translateY(-4px);
    }

    .product-image {
        width: 20rem;
        height: 30rem;
        border-radius: 12px;
        object-fit: cover;
    }

    .product-info {
        margin-top: 10px;
        font-family: 'Segoe UI', sans-serif;
        color: #4b7b5f;
    }

    .product-info h4 {
        margin: 10px 0 4px;
        font-size: 20px;
        font-weight: 500;
    }

    .product-info .price {
        margin: 6px 0;
        font-weight: bold;
        font-size: 18px;
        color: #4b7b5f;
    }

    .product-info .see-more {
        display: inline-flex;
        align-items: center;
        background-color: transparent;
        color: #8a6f5e;
        font-size: 17px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        gap: 6px;
        text-decoration: none;
    }

    .product-info .see-more:hover {
        color: #4b7b5f;
    }

    .product-info .see-more::after {
        content: '→';
        font-size: 16px;
        transition: transform 0.3s ease;
    }

    .product-info .see-more:hover::after {
        transform: translateX(4px);
    }

    /* Welcome Section Styles */
    .welcome-section {
        background-color: #f6f7f0;
        border: 1px solid #7c6755;
        box-shadow: 0 0 0 4px #7c6755;
        border-radius: 0;
        padding: 50px 20px;
        margin: 40px auto;
        text-align: center;
        width: 100%;
    }

    .welcome-section h2 {
        color: #7c6755;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 35px;
        position: relative;
        font-family: 'Segoe UI', sans-serif;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .welcome-content {
        display: flex;
        justify-content: space-between;
        flex-wrap: nowrap;
        gap: 40px;
        width: 100%;
        margin: 0 auto;
    }

    .welcome-content div {
        flex: 1;
        min-width: 200px;
        padding: 0 15px;
    }

    .welcome-content h3 {
        color: #4a7259;
        font-size: 25px;
        font-weight: 800;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .welcome-content p {
        color: #7c6755;
        font-size: 18px;
        line-height: 1.4;
        font-weight: 400;
        white-space: nowrap;
    }

    .welcome-logo {
        width: 10%;
        position: relative;
    }

    /* Slider Section Styles */
    .slider-section {
        padding: 60px 20px;
        background-color: #fdfdfb;
        overflow: hidden;
    }

    .slider-container {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 40px;
        animation: slide 30s linear infinite;
    }

    .slider-item {
        position: relative;
        width: 400px;
        height: 500px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .slider-image-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .slider-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: grayscale(100%);
        transition: transform 0.5s ease;
    }

    .slider-item:hover img {
        transform: scale(1.05);
    }

    /* Footer Styles */
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

    .social-icons {
        display: flex;
        gap: 15px;
        margin-top: 15px;
    }

    .social-icons a {
        color: #7c6755;
        font-size: 20px;
        transition: color 0.3s ease;
    }

    .social-icons a:hover {
        color: #4a7259;
    }

    .footer-bottom {
        text-align: center;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #7c6755;
    }

    /* Responsive Styles */
    @media (max-width: 1200px) {
        .slider-item {
            width: 350px;
            height: 450px;
        }
    }

    @media (max-width: 768px) {
        .welcome-content {
            flex-direction: column;
            align-items: center;
            gap: 25px;
        }
        
        .welcome-content div {
            max-width: 100%;
            padding: 0 20px;
        }
        
        .welcome-section {
            padding: 30px 15px;
        }
        
        .slider-item {
            width: 300px;
            height: 400px;
        }
        
        .footer-content {
            flex-direction: column;
            gap: 30px;
        }
        
        .footer-section {
            text-align: center;
        }
        
        .social-icons {
            justify-content: center;
        }
    }

    @keyframes slide {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-100%);
        }
    }

    .discount-section {
        display: none;
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
                <li class="user-icon" onclick="toggleUserMenu()">
                    <i class="fa-solid fa-user"></i>
                    <div id="userMenu" class="user-menu">
                        <?php if (isset($_SESSION['email'])): ?>
                            <div class="user-info">
                                <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                                <form method="post" action="logout.php">
                                    <button type="submit" class="logout-btn">Logout</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="auth-buttons">
                                <a href="login.php" class="login-btn">Login</a>
                                <a href="register.php" class="register-btn">Don't have an account? Register</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <section class="landingpage">
        <div class="landing_page_image">
            <img src="./assets/landingpage.jpg" alt="" />
        </div>

        <div class="landing_page_content">
            <div class="landing_page_text">
                <div class="large_text">
                    <span class="brown_text">ELEGANCE IN</span><br />
                    <span class="green_text">EVERY THREAD</span>
                </div>

                <div class="small_text">
                    Step into our designs and own every moment with style, from dawn to dusk!
                </div>
            </div>

            <div class="shop_now_button">
                <button onclick="window.scrollTo({ top: document.querySelector('.product_cards').offsetTop, behavior: 'smooth' });" style="transition: all 0.5s ease;">SHOP NOW</button>
            </div>
        </div>
    </section>

    <section class="product_cards">
        <div class="title_text">NEW ARRIVALS</div>

        <div class="product-row">
            <?php
            try {
                // Men's Product
                $stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'men' ORDER BY id DESC LIMIT 1");
                $stmt->execute();
                $menProduct = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($menProduct) {
                    echo '<div class="product">';
                    echo '  <img src="' . htmlspecialchars($menProduct['image']) . '" alt="' . htmlspecialchars($menProduct['name']) . '" />';
                    echo '  <div class="product-info">';
                    echo '    <div>' . htmlspecialchars($menProduct['name']) . '</div>';
                    echo '    <div>$' . number_format($menProduct['price'], 2) . '</div>';
                    echo '    <a href="men.php?id=' . $menProduct['id'] . '" class="see-more">See More</a>';
                    echo '  </div>';
                    echo '</div>';
                }

                // Women's Product
                $stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'women' ORDER BY id DESC LIMIT 1");
                $stmt->execute();
                $womenProduct = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($womenProduct) {
                    echo '<div class="product">';
                    echo '  <img src="' . htmlspecialchars($womenProduct['image']) . '" alt="' . htmlspecialchars($womenProduct['name']) . '" />';
                    echo '  <div class="product-info">';
                    echo '    <div>' . htmlspecialchars($womenProduct['name']) . '</div>';
                    echo '    <div>$' . number_format($womenProduct['price'], 2) . '</div>';
                    echo '    <a href="women.php?id=' . $menProduct['id'] . '" class="see-more">See More</a>';
                    echo '  </div>';
                    echo '</div>';
                }

                // Kids' Product
                $stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'kid' ORDER BY id DESC LIMIT 1");
                $stmt->execute();
                $kidsProduct = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($kidsProduct) {
                    echo '<div class="product">';
                    echo '  <img src="' . htmlspecialchars($kidsProduct['image']) . '" alt="' . htmlspecialchars($kidsProduct['name']) . '" />';
                    echo '  <div class="product-info">';
                    echo '    <div>' . htmlspecialchars($kidsProduct['name']) . '</div>';
                    echo '    <div>$' . number_format($kidsProduct['price'], 2) . '</div>';
                    echo '    <a href="kid.php?id=' . $menProduct['id'] . '" class="see-more">See More</a>';
                    echo '  </div>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo '<p style="text-align:center; color:red;">Error loading products: ' . $e->getMessage() . '</p>';
            }
            ?>
        </div>
    </section>

    <section class="welcome-section">
        <img src="./assets/styles_logo.png" alt="Logo" class="welcome-logo" />
        
        <div class="welcome-content">
            <div>
                <h3>FOR EVERYONE, EVERYWHERE</h3>
                <p>Fashion that embraces every age and style.</p>
            </div>
            <div>
                <h3>QUALITY IN EVERY STITCH</h3>
                <p>Crafted with care for lasting comfort and confidence.</p>
            </div>
            <div>
                <h3>FAMILY FIRST, STYLE ALWAYS</h3>
                <p>Styles that unite the whole family.</p>
            </div>
        </div>
    </section>

    <section class="slider-section">
        <div class="slider-container">
            <?php
            try {
                $stmt = $pdo->prepare("
                    (SELECT *, 'men' as category_type FROM products WHERE category = 'men')
                    UNION ALL
                    (SELECT *, 'women' as category_type FROM products WHERE category = 'women')
                    UNION ALL
                    (SELECT *, 'kid' as category_type FROM products WHERE category = 'kid')
                    ORDER BY RAND()
                ");
                
                $stmt->execute();
                $allProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($allProducts as $product) {
                    echo '<div class="slider-item">';
                    echo '    <div class="slider-image-container">';
                    echo '        <img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" />';
                    echo '    </div>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo '<p style="text-align:center; color:red;">Error loading slider products: ' . $e->getMessage() . '</p>';
            }
            ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>