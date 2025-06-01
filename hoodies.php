<?php
// Include database connection
require_once 'db.php';

// Start session to track user state
session_start();

// =========================
// Sorting system
// =========================
$order = "id ASC"; // Default sort order
if (isset($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'price_asc': $order = "price ASC"; break;
        case 'price_desc': $order = "price DESC"; break;
        case 'name_asc': $order = "name ASC"; break;
        case 'name_desc': $order = "name DESC"; break;
    }
}

// Fetch all products from database ordered by selected sort
$stmt = $pdo->query("SELECT * FROM products ORDER BY $order");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Hoodies - Hoodie Haven</title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main>
<!-- Include navigation bar -->
<?php include 'partials/navbar.php'; ?>

<!-- Product listing -->
<div class="container">
    <h2>All Our Hoodies</h2>

    <!-- Filter dropdown -->
    <div class="filter-bar">
        <form method="get" action="hoodies.php">
            <label for="sort">Sort by:</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="">Default</option>
                <option value="price_asc" <?= ($_GET['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                <option value="price_desc" <?= ($_GET['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                <option value="name_asc" <?= ($_GET['sort'] ?? '') === 'name_asc' ? 'selected' : '' ?>>Name: A → Z</option>
                <option value="name_desc" <?= ($_GET['sort'] ?? '') === 'name_desc' ? 'selected' : '' ?>>Name: Z → A</option>
            </select>
        </form>
    </div>

    <!-- Check if products exist -->
    <?php if (empty($products)): ?>
        <p>No hoodies available at the moment.</p>
    <?php else: ?>
        <div class="products">
            <!-- Loop through each product -->
            <?php foreach ($products as $product): ?>
                <div class="product" id="product-<?= $product['id'] ?>">
                    <!-- Product image -->
                    <img src="assets/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">

                    <!-- Product name + description -->
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p><?= htmlspecialchars($product['description']) ?></p>

                    <!-- Show price + sale price -->
                    <?php if (!empty($product['original_price']) && $product['original_price'] > $product['price']): ?>
                        <p>
                            <span class="original-price">€<?= number_format($product['original_price'], 2) ?></span>
                            <strong class="sale-price">€<?= number_format($product['price'], 2) ?></strong>
                        </p>
                    <?php else: ?>
                        <strong>€<?= number_format($product['price'], 2) ?></strong>
                    <?php endif; ?>

                    <!-- If user is logged in: show buy/wishlist buttons -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Add to cart form -->
                        <form method="post" class="inline-form" action="add_to_cart.php">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <label>Qty:</label>
                            <input type="number" name="quantity" value="1" min="1" style="width:50px">
                            <button type="submit" class="add-btn">Add to Cart</button>
                        </form>

                        <!-- Add to wishlist form -->
                        <form method="post" class="inline-form" action="add_to_wishlist.php">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button type="submit" class="wishlist-btn">🤍 Wishlist</button>
                        </form>
                    <?php else: ?>
                        <!-- Message for guest users -->
                        <p><small><a href="signin.php">Sign in</a> to buy or save items.</small></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</main>
<?php include 'partials/footer.php'; ?>

</body>
</html>
