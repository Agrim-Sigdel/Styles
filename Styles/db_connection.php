<?php
$host = 'localhost';
$db   = 'style_website'; // change to your DB name
$user = 'root';      // change if needed
$pass = '';          // change if you set a password
$charset = 'utf8mb4';

// Create DSN string
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

// Establish database connection
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>