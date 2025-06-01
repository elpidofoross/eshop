<?php
// Start session and include database connection
session_start();
require_once 'db.php';

// =========================
// Redirect guest users
// =========================
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

// Get user ID
$userId = $_SESSION['user_id'];

// =========================
// Handle add to cart form submission
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $productId = (int) $_POST['product_id'];
    $quantity = max(1, (int) $_POST['quantity']); // Quantity must be at least 1

    // =========================
    // Check if product already exists in user cart
    // =========================
    $stmt = $pdo->prepare("SELECT id, quantity FROM carts WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        // =========================
        // If exists, update quantity
        // =========================
        $newQty = $item['quantity'] + $quantity;
        $update = $pdo->prepare("UPDATE carts SET quantity = ? WHERE id = ?");
        $update->execute([$newQty, $item['id']]);
    } else {
        // =========================
        // If not exists, insert new cart item
        // =========================
        $insert = $pdo->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $insert->execute([$userId, $productId, $quantity]);
    }

    // =========================
    // Redirect back to previous page
    // =========================
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
