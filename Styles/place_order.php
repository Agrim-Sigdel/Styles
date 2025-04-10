<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connection.php'; // Contains your PDO connection ($pdo)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $phone_number     = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);
    $customer_address = filter_input(INPUT_POST, 'customer_address', FILTER_SANITIZE_STRING);
    $total_amount     = filter_input(INPUT_POST, 'total_amount', FILTER_VALIDATE_FLOAT);
    $cart_data_json   = $_POST['cart_data'] ?? '';

    // Decode JSON cart data
    $products = json_decode($cart_data_json, true);

    // Basic validation
    if (!$phone_number || !$customer_address || !$total_amount || !$products || !is_array($products)) {
        die("Invalid order data.");
    }

    // Get user info from session
    $user_id    = $_SESSION['user_id'] ?? null;
    $user_email = $_SESSION['email'] ?? null;

    try {
        $pdo->beginTransaction();

        $sql = "INSERT INTO orders (user_id, user_email, phone_number, customer_address, products, total_amount, order_date)
                VALUES (:user_id, :user_email, :phone_number, :customer_address, :products, :total_amount, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id'          => $user_id,
            ':user_email'       => $user_email,
            ':phone_number'     => $phone_number,
            ':customer_address' => $customer_address,
            ':products'         => json_encode($products),
            ':total_amount'     => $total_amount
        ]);

        $order_id = $pdo->lastInsertId();
        $pdo->commit();

        // Optional: Clear cart from sessionStorage (frontend does this)
        header("Location: confirmation.php?order_id=" . $order_id);
        exit();

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        die("Error processing order: " . $e->getMessage());
    }
} else {
    header("Location: checkout.php");
    exit();
}
?>