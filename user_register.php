<?php
// Enable error reporting (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'includes/db.php';
include 'header.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // Validate input
    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Check if username or email already exists
        $check = $conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
        if (!$check) {
            die("SQL SELECT error: " . $conn->error);
        }
        $check->bind_param("ss", $username, $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Username or email already exists.";
        } else {
            // Insert new user
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            if (!$stmt) {
                die("SQL INSERT error: " . $conn->error);
            }
            $stmt->bind_param("sss", $username, $email, $password_hash);

            if ($stmt->execute()) {
                $success = "Account created successfully! <a href='login.php'>Log in now</a>.";
            } else {
                $error = "Registration failed. Try again.";
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link rel="stylesheet" href="cars.css">
</head>
<body>
<div class="login-container">
    <h2>User Registration</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post" autocomplete="off">
        <label>Username:<br>
            <input type="text" name="username" required>
        </label><br><br>

        <label>Email:<br>
            <input type="email" name="email" required>
        </label><br><br>

        <label>Password:<br>
            <input type="password" name="password" required>
        </label><br><br>

        <label>Confirm Password:<br>
            <input type="password" name="confirm" required>
        </label><br><br>

        <button type="submit">Register</button>
    </form>

    <div class="create-account-link">
        <p>Already have an account? <a href="login.php">Log in here</a>.</p>
    </div>
</div>
</body>
</html>
