<?php
session_start();

// Include database connection
include 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Set JSON response header
header('Content-Type: application/json');

// Handle non-POST requests
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    $conn->close();
    exit();
}

// Get and validate product IDs from request body
$input = json_decode(file_get_contents("php://input"), true);
$productIds = $input['ids'] ?? [];

if (empty($productIds)) {
    echo json_encode(['success' => false, 'error' => 'No product IDs provided.']);
    $conn->close();
    exit();
}

// Prepare SQL query
$placeholders = implode(',', array_fill(0, count($productIds), '?'));
$query = "SELECT * FROM products WHERE id IN ($placeholders)";
$stmt = $conn->prepare($query);

// Bind parameters and execute
$types = str_repeat('i', count($productIds));
$stmt->bind_param($types, ...$productIds);

// Get results
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $products = [];
    
    while ($product = $result->fetch_assoc()) {
        $products[] = $product;
    }
    
    echo json_encode(['success' => true, 'products' => $products]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

// Clean up
$stmt->close();
$conn->close();
?>