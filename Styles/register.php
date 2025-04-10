<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include DB connection
ob_start(); // To safely echo JS before header redirect
include 'db_connection.php';

$message = "";
$console_logs = [];

// Connection success log
$console_logs[] = "Database connected successfully.";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $confirm = $_POST["confirm"] ?? '';

    if ($password !== $confirm) {
        $message = "Passwords do not match.";
    } else {
        try {
            // Check if email exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $message = "Email already registered.";
            } else {
                // Insert new user
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                
                if ($stmt->execute([$email, $hashedPassword])) {
                    $console_logs[] = "Registration successful.";
                    echo "<script>console.log('Registration successful. Redirecting to login page...');</script>";
                    echo "<script>setTimeout(() => window.location.href = 'login.php', 1500);</script>";
                } else {
                    $message = "Registration failed. Please try again.";
                }
            }
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Page</title>
    <link rel="stylesheet" href="login.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
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
        <div class="text">Register</div>

        <?php if (!empty($message)) echo "<p style='color:red;'>$message</p>"; ?>

        <form method="POST" action="">
            <div class="input_type">
                <input type="email" name="email" placeholder="E-MAIL" required /><br />
                <input type="password" name="password" placeholder="PASSWORD" required />
                <input type="password" name="confirm" placeholder="CONFIRM PASSWORD" required />
            </div>
            <button type="submit">Register</button>
        </form>

        <div class="register">
            <p>Already have an account?</p>
            <button onclick="window.location.href='login.php'">Login</button>
        </div>
    </section>

    <?php
    // Output all console logs
    if (!empty($console_logs)) {
        echo "<script>";
        foreach ($console_logs as $log) {
            echo "console.log(" . json_encode($log) . ");";
        }
        echo "</script>";
    }
    ob_end_flush();
    ?>
</body>

</html>