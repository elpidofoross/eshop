<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Get all products from user cart (from DB)
$stmt = $pdo->prepare("
    SELECT products.price, carts.quantity 
    FROM carts 
    JOIN products ON carts.product_id = products.id 
    WHERE carts.user_id = ?");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll();

// If cart is empty → redirect to cart page
if (empty($cartItems)) {
    header("Location: cart.php");
    exit;
}

// Calculate total order value
$subtotal = 0;
foreach ($cartItems as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$total = $subtotal;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Hoodie Haven</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* Red border for any invalid input field */
        input:invalid, select:invalid {
            border-color: red;
        }
    </style>
</head>
<body>
<main>
<?php include 'partials/navbar.php'; ?>

<div class="checkout-container">
    <h2>🧾 Checkout & Shipping</h2>

    <!-- Display cart total -->
    <div class="checkout-summary">
        <p><strong>Subtotal:</strong> €<?= number_format($subtotal, 2) ?></p>
        <p><strong>Total to Pay:</strong> €<?= number_format($total, 2) ?></p>
    </div>

    <!-- Checkout form -->
    <form method="post" action="process_order.php" class="checkout-form" id="checkoutForm">
        <h3>📦 Shipping Details</h3>
        <!-- Shipping inputs -->
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="text" name="address" placeholder="Street Address" required>
        <input type="text" name="city" placeholder="City" required>
        <input type="text" name="zip" placeholder="ZIP Code" required pattern="\d{4,10}" title="Only numbers (4-10 digits)">
        <select name="country" required>
            <option value="">Select Country</option>
            <option value="Greece">Greece</option>
            <option value="Italy">Italy</option>
            <option value="Germany">Germany</option>
            <option value="France">France</option>
            <option value="Spain">Spain</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="United States">United States</option>
        </select>
        <input type="text" name="phone" placeholder="Phone (optional)" pattern="\d*" title="Only numbers allowed">

        <h3>💳 Payment Details</h3>
        <!-- Payment inputs -->
        <input type="text" name="card_number" maxlength="19" placeholder="Card Number (1234 5678 9012 3456)" required pattern="(?:\d{4} ){3}\d{4}" title="Card number must be 16 digits (with spaces)">
        <input type="text" name="card_name" placeholder="Cardholder Name" required>
        <input type="text" name="expiry" maxlength="5" minlength="4" placeholder="MM/YY" required pattern="(0?[1-9]|1[0-2])/\d{2}" title="Format must be MM/YY (e.g. 3/24 or 03/24)">
        <input type="text" name="cvv" maxlength="3" placeholder="CVV (3 digits)" required pattern="\d{3}" title="CVV must be exactly 3 digits">

        <!-- Submit button -->
        <button type="submit" class="buy-btn">Buy Now</button>
    </form>
</div>

<script>
// Select inputs for validation + formatting
const cardInput = document.querySelector('input[name="card_number"]');
const expiryInput = document.querySelector('input[name="expiry"]');
const phoneInput = document.querySelector('input[name="phone"]');
const zipInput = document.querySelector('input[name="zip"]');

// Auto add space every 4 digits (1234 5678 9012 3456)
cardInput.addEventListener('input', () => {
    cardInput.value = cardInput.value
        .replace(/\D/g, '')
        .replace(/(.{4})/g, '$1 ')
        .trim()
        .substring(0, 19);
});

// Auto add "/" after 2 digits for expiry date (MM/YY)
expiryInput.addEventListener('input', () => {
    expiryInput.value = expiryInput.value.replace(/\D/g, '')
        .replace(/(\d{2})(\d{1,2})/, '$1/$2')
        .substring(0, 5);
});

// Allow only numbers in phone + zip inputs
phoneInput.addEventListener('input', () => {
    phoneInput.value = phoneInput.value.replace(/\D/g, '');
});
zipInput.addEventListener('input', () => {
    zipInput.value = zipInput.value.replace(/\D/g, '');
});

// Validate expiry date on form submit (must not be past date + valid month/year)
document.getElementById("checkoutForm").addEventListener("submit", function(e) {
    const expiryRaw = expiryInput.value.replace(/\s/g, '');
    const match = expiryRaw.match(/^(\d{1,2})\/(\d{2})$/);
    if (!match) {
        e.preventDefault();
        alert("Please enter expiry date in MM/YY format.");
        expiryInput.focus();
        return;
    }

    let inputMonth = parseInt(match[1], 10);
    let inputYear = parseInt("20" + match[2], 10);

    if (inputMonth < 1 || inputMonth > 12) {
        e.preventDefault();
        alert("Expiry month must be between 1 and 12.");
        expiryInput.focus();
        return;
    }

    const today = new Date();
    const currentMonth = today.getMonth() + 1;
    const currentYear = today.getFullYear();
    const maxYear = currentYear + 10;

    if (inputYear < currentYear || inputYear > maxYear ||
        (inputYear === currentYear && inputMonth < currentMonth)) {
        e.preventDefault();
        alert("Card expiry date is invalid or expired. Please check your card.");
        expiryInput.focus();
    }
});
</script>
</main>
<?php include 'partials/footer.php'; ?>
</body>
</html>
