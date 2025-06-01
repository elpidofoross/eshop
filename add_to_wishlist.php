<?php
// Start session and connect to database
session_start();
require_once 'db.php';

// =========================
// Redirect guests to sign-in
// =========================
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

// Get logged-in user ID
$userId = $_SESSION['user_id'];

// =========================
// Handle "Add to Wishlist" form submission
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];

    // =========================
    // Check if item already in wishlist
    // =========================
    $stmt = $pdo->prepare("SELECT id FROM wishlists WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existing) {
        // =========================
        // If not in wishlist, insert it
        // =========================
        $insert = $pdo->prepare("INSERT INTO wishlists (user_id, product_id) VALUES (?, ?)");
        $insert->execute([$userId, $productId]);
    }

    // =========================
    // Redirect back to previous page
    // =========================
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
 