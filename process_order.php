<?php
// Include database connection
require_once 'db.php';

// Start session
session_start();

// =========================
// Check if user is logged in
// =========================
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}

$userId = $_SESSION['user_id'];

// =========================
// Fetch user's cart from database
// =========================
$stmt = $pdo->prepare("
    SELECT products.name, products.price, carts.quantity
    FROM carts 
    JOIN products ON carts.product_id = products.id 
    WHERE carts.user_id = ?
");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// =========================
// If cart is empty, redirect to cart page
// =========================
if (empty($cartItems)) {
    header("Location: cart.php");
    exit;
}

// =========================
// Calculate total
// =========================
$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}

// =========================
// Get shipping + payment form values
// =========================
$full_name = $_POST['full_name'];
$address = $_POST['address'];
$city = $_POST['city'];
$zip = $_POST['zip'];
$country = $_POST['country'];
$phone = $_POST['phone'] ?? null;
$card_number = $_POST['card_number'];
$card_name = $_POST['card_name'];
$expiry = $_POST['expiry'];
$cvv = $_POST['cvv'];

try {
    // =========================
    // Insert order into orders table
    // =========================
    $stmt = $pdo->prepare("INSERT INTO orders 
        (user_id, user_name, full_name, total, discount, address, city, zip, country, phone, card_name, card_number, expiry, cvv, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    $stmt->execute([
        $userId,
        $_SESSION['user_name'],
        $full_name,
        $total,
        0, // discount (none)
        $address,
        $city,
        $zip,
        $country,
        $phone,
        $card_name,
        $card_number,
        $expiry,
        $cvv
    ]);

    // Get last inserted order ID
    $orderId = $pdo->lastInsertId();

    // =========================
    // Insert order items into order_items table (WITHOUT product_id)
    // =========================
    $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");

    foreach ($cartItems as $item) {
        $itemStmt->execute([
            $orderId,
            $item['name'],
            $item['quantity'],
            $item['price']
        ]);
    }

    // =========================
    // Clear user's cart
    // =========================
    $pdo->prepare("DELETE FROM carts WHERE user_id = ?")->execute([$userId]);

    // Set success + buyer name
    $_SESSION['order_success'] = true;
    $_SESSION['buyer'] = $full_name;

    // Redirect to thank you page
    header("Location: thank_you.php");
    exit;

} catch (PDOException $e) {
    echo "❌ Order failed: " . $e->getMessage();
    exit;
}
