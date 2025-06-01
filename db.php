<?php
$host = 'localhost';
$db   = 'eshop';      // Make sure this matches your DB name
$user = 'root';       // Default XAMPP user
$pass = '';           // Default XAMPP password (empty)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ DB connection failed: " . $e->getMessage());
}
?>
