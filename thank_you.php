<?php
// Start session to check order completion
session_start();

// =========================
// Redirect to store if no order was placed
// =========================
if (!isset($_SESSION['order_success'])) {
    header('Location: welcome.php');
    exit;
}

// Get buyer name (fallback to "Customer")
$buyer = $_SESSION['buyer'] ?? 'Customer';

// Clear session order flags
unset($_SESSION['order_success'], $_SESSION['buyer']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thanks for Your Order</title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="assets/style.css">

    <!-- Additional internal styles for this page -->
    <style>
        .thankyou-box {
            text-align: center;
            margin: 80px auto;
            background: #fff;
            max-width: 600px;
            padding: 30px;
            border-radius: 8px;
            animation: pop 0.4s ease;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        /* Simple popup animation */
        @keyframes pop {
            from { transform: scale(0.8); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }

        /* Button styling */
        .thankyou-box a {
            display: inline-block;
            margin-top: 20px;
            color: #fff;
            background: #28a745;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .thankyou-box a:hover {
            background: #218838;
        }
    </style>
</head>
<body>
<main>
<!-- Include navigation bar -->
<?php include 'partials/navbar.php'; ?>

<!-- Thank you message -->
<div class="thankyou-box">
    <h2>✅ Thank you, <?= htmlspecialchars($buyer) ?>!</h2>
    <p>Your purchase has been confirmed. A dev hoodie is on the way.</p>
    <a href="hoodies.php">Continue Shopping →</a>
</div>
</main>
<?php include 'partials/footer.php'; ?>

</body>
</html>
