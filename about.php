<?php
// Include database connection
require_once 'db.php';

// Start session to access user data
session_start();

// =========================
// Get items on sale
// =========================
$sale = $pdo->query("
    SELECT * FROM products 
    WHERE original_price IS NOT NULL AND original_price > price 
    LIMIT 2
")->fetchAll(PDO::FETCH_ASSOC);

// =========================
// Get featured items
// =========================
$featured = $pdo->query("
    SELECT * FROM products 
    ORDER BY id ASC 
    LIMIT 2
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Hoodie Haven</title>
    <!-- Link to external stylesheet -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main>
<!-- Include site navigation -->
<?php include 'partials/navbar.php'; ?>

<!-- About us content -->
<div class="about">
    <h2>Welcome to Hoodie Haven</h2>

    <!-- Company description -->
    <p>Founded in 2018 by a small collective of software engineers and fashion enthusiasts in Amsterdam, Hoodie Haven was born from late-night hackathons and endless cups of coffee. Our mission? To create the perfect hoodie for tech lovers, gamers, coders, and creatives around the world.</p>

    <p>We understand the struggle of cold server rooms and marathon coding sessions. That’s why every Hoodie Haven product is designed with ultra-soft fabrics, hidden utility pockets, device-safe linings, and an ergonomic fit for maximum comfort during your next deep dive into code or your next Netflix binge.</p>

    <p>From humble beginnings shipping hoodies from a single garage, we’ve now grown into a global community of comfort-seekers who never compromise on style or function. Whether you’re debugging at 3 AM, working remotely from a café, or simply relaxing at home, Hoodie Haven has got your back (literally).</p>

    <p>Join the movement. Wear your hustle.</p>

    <!-- Sale items section -->
    <h3>🔥 On Sale Now</h3>
    <div class="promo-products">
        <?php foreach ($sale as $item): ?>
            <!-- Each sale product links to hoodie listing -->
            <a href="hoodies.php#product-<?= $item['id'] ?>" class="promo-card">
                <img src="assets/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <div>
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p>
                        <span class="original-price">€<?= number_format($item['original_price'], 2) ?></span>
                        <strong class="sale-price">€<?= number_format($item['price'], 2) ?></strong>
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</main>
<?php include 'partials/footer.php'; ?>

</body>
</html>
