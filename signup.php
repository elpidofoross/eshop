<?php
// Include database connection
require_once 'db.php';

// Start session to store user data after signup
session_start();

// Initialize error message
$error = "";

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                $error = "Email already registered.";
            } else {
                // Hash the password for security
                $hashed = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user into database
                $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $hashed]);

                // Get inserted user ID
                $userId = $pdo->lastInsertId();

                // Set session variables to log in the user
                $_SESSION['user_name'] = $name;
                $_SESSION['user_id'] = $userId;

                // Redirect to welcome page
                header("Location: welcome.php");
                exit();
            }
        } catch (PDOException $e) {
            $error = "DB Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - Hoodie Haven</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'partials/navbar.php'; ?>

    <main>
        <div class="about">
            <h2>Create Account</h2>

            <?php if (!empty($error)): ?>
                <div style="color:red;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post">
                <label>Full Name</label><br>
                <input type="text" name="name" required><br><br>

                <label>Email</label><br>
                <input type="email" name="email" required><br><br>

                <label>Password</label><br>
                <input type="password" name="password" required><br><br>

                <button type="submit">Sign Up</button>
            </form>
        </div>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
