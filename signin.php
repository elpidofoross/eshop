<?php
// Include database connection
require_once 'db.php';

// Start session to store user login state
session_start();

// Initialize error message
$error = "";

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        // Check if user exists in database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password hash and set session
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_id'] = $user['id'];

            // Redirect to welcome page
            header("Location: welcome.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign In - Hoodie Haven</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<!-- ✅ Wrap page content in main -->
<main>
    <div class="about">
        <h2>Sign In</h2>

        <?php if (!empty($error)): ?>
            <div style="color:red;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <label>Email</label><br>
            <input type="email" name="email" required><br><br>

            <label>Password</label><br>
            <input type="password" name="password" required><br><br>

            <button type="submit">Sign In</button>
        </form>
    </div>
</main>

<?php include 'partials/footer.php'; ?>

</body>
</html>
