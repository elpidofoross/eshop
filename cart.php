<?php
// Include database connection
require_once 'db.php';

// Start session to track user
session_start();

// Redirect guests to sign in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

$userId = $_SESSION['user_id'];

// =========================
// Handle quantity update
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_qty'])) {
    $cartId = (int)$_POST['cart_id'];
    $quantity = max(1, (int)$_POST['quantity']);

    // Update quantity of product in cart
    $stmt = $pdo->prepare("UPDATE carts SET quantity = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$quantity, $cartId, $userId]);
}

// =========================
// Handle item removal
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $cartId = (int)$_POST['cart_id'];

    // Delete product from cart
    $stmt = $pdo->prepare("DELETE FROM carts WHERE id = ? AND user_id = ?");
    $stmt->execute([$cartId, $userId]);
}

// =========================
// Fetch current cart items
// =========================
$stmt = $pdo->prepare("
    SELECT carts.id AS cart_id, products.id AS product_id, products.name, products.price, products.image, carts.quantity 
    FROM carts 
    JOIN products ON carts.product_id = products.id 
    WHERE carts.user_id = ?
");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// =========================
// Calculate total price
// =========================
$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Hoodie Cart 🛒</title>
    <!-- Link to external stylesheet -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main>
<!-- Include site navigation -->
<?php include 'partials/navbar.php'; ?>

<!-- Display cart contents -->
<div class="container cart-page">
    <h2>Your Hoodie Cart 🛒</h2>

    <?php if (empty($cartItems)): ?>
        <!-- Show message if cart is empty -->
        <p>Your cart is empty. <a href="hoodies.php">Go add some hoodies!</a></p>
    <?php else: ?>
        <!-- Loop over cart items -->
        <?php foreach ($cartItems as $item): ?>
            <div class="cart-item">
                <!-- Product image -->
                <img src="assets/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width:60px;height:auto;">
                
                <!-- Product details -->
                <h4><?= htmlspecialchars($item['name']) ?></h4>
                <p>€<?= number_format($item['price'], 2) ?> x <?= $item['quantity'] ?> = 
                    <strong>€<?= number_format($item['price'] * $item['quantity'], 2) ?></strong>
                </p>

                <!-- Form to update quantity -->
                <form method="post" class="inline-form">
                    <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1">
                    <button type="submit" name="update_qty">Update</button>
                </form>

                <!-- Form to remove item -->
                <form method="post" class="inline-form">
                    <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                    <button type="submit" name="remove" class="remove-btn">Remove</button>
                </form>
            </div>
        <?php endforeach; ?>

        <!-- Cart total and checkout button -->
        <div class="cart-summary">
            <p><strong>Total: €<?= number_format($total, 2) ?></strong></p>
            <form action="checkout.php" method="post">
                <button type="submit" class="add-btn">Buy Now</button>
            </form>
        </div>
    <?php endif; ?>
</div>
</main>
<?php include 'partials/footer.php'; ?>

</body>
</html>
