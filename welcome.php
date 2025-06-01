<?php
// Include database connection file
require_once 'db.php';

// Start session to access user login data
session_start();

// Redirect guest users to sign in page
if (!isset($_SESSION['user_name'])) {
    header('Location: signin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - Hoodie Haven</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- ✅ Navbar -->
<?php include 'partials/navbar.php'; ?>

<!-- ✅ Main content area (very important for sticky footer!) -->
<main>
    <div class="about">
        <h2>👋 Welcome back, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
        <p>We're glad to see you again. Your hoodie kingdom awaits.</p>

        <ul>
            <li><a href="hoodies.php">🧥 Browse All Hoodies</a></li>
            <li><a href="cart.php">🛒 View Your Cart</a></li>
            <li><a href="wishlist.php">🤍 View Wishlist</a></li>
            <li><a href="about.php">ℹ️ About Us and Sales</a></li>
        </ul>
    </div>
</main>

<!-- ✅ Footer -->
<?php include 'partials/footer.php'; ?>

</body>
</html>
