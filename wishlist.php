<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Remove item from wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $wishlistId = (int)$_POST['wishlist_id'];
    $stmt = $pdo->prepare("DELETE FROM wishlists WHERE id = ? AND user_id = ?");
    $stmt->execute([$wishlistId, $userId]);
}

// Get wishlist items
$stmt = $pdo->prepare("
    SELECT wishlists.id AS wishlist_id, products.id AS product_id, products.name, products.price, products.image 
    FROM wishlists 
    JOIN products ON wishlists.product_id = products.id 
    WHERE wishlists.user_id = ?
");
$stmt->execute([$userId]);
$wishlistItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wishlist 💖</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main>
<?php include 'partials/navbar.php'; ?>

<div class="container wishlist-page">
    <h2>Your Wishlist 💖</h2>

    <?php if (empty($wishlistItems)): ?>
        <p>No hoodies saved yet. <a href="hoodies.php">Browse the store!</a></p>
    <?php else: ?>
        <div class="products">
            <?php foreach ($wishlistItems as $item): ?>
                <div class="product">
                    <a href="hoodie_detail.php?id=<?= $item['product_id'] ?>">
                        <img src="assets/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    </a>
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <strong>€<?= number_format($item['price'], 2) ?></strong>

                    <form method="post">
                        <input type="hidden" name="wishlist_id" value="<?= $item['wishlist_id'] ?>">
                        <button type="submit" name="remove" class="remove-btn">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</main>
<?php include 'partials/footer.php'; ?>

</body>
</html>
