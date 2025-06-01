<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<nav class="navbar">
  <div class="nav-container">
    <a href="welcome.php" class="logo">
      <img src="assets/logo.jpg" alt="Hoodie Haven Logo" style="height: 40px; vertical-align: middle;">
    </a>
    <div class="nav-links">
      <a href="hoodies.php">Store</a>
      <a href="cart.php">Cart</a>
      <a href="wishlist.php">Wishlist</a>
      <a href="about.php">About</a>

      <?php if (isset($_SESSION['user_name'])): ?>
        <form method="post" action="logout.php" style="display:inline;">
          <button type="submit" class="logout-btn">Logout</button>
        </form>
      <?php else: ?>
        <a href="signin.php">Sign In</a>
        <a href="signup.php">Sign Up</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
