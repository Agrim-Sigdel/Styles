<?php
session_start();
include 'db_connection.php';
ob_start(); // Allow echoing JS before redirect

$console_logs = [];
$connected = false;

try {
    include 'db_connection.php';
    $connected = true;
    $console_logs[] = "✅ Database connected successfully.";
} catch (Exception $e) {
    $console_logs[] = "❌ Database connection failed: " . $e->getMessage();
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password']; // Keep raw password for verification

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['email']; // Or 'username' if your DB has it

            $console_logs[] = "✅ Login successful. Redirecting to index.php...";
            echo "<script>console.log('Login successful. Redirecting...');</script>";
            echo "<script>setTimeout(() => window.location.href = 'index.php', 1000);</script>";
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: login.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
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
    </style>
    <script>
    <?php
        foreach ($console_logs as $log) {
            echo "console.log(" . json_encode($log) . ");";
        }
    ?>
    </script>
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

    <section class="login_box">
        <div class="text">LOG IN</div>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
            unset($_SESSION['error']);
        }
        ?>
        <form method="POST" action="">
            <div class="input_type">
                <input type="email" name="email" placeholder="E-MAIL" required /><br />
                <input type="password" name="password" placeholder="PASSWORD" required />
            </div>
            <button type="submit">Log IN</button>
        </form>
        <div class="register">
            <p>Don't have an account?</p>
            <button onclick="window.location.href='register.php'">Register</button>
        </div>
    </section>

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
</body>
</html>
<?php ob_end_flush(); ?>