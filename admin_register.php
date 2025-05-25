<?php
session_start();
require_once 'includes/db.php';
include 'header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT admin_id FROM admins WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Username or email already taken.";
        } else {
            // Insert new admin
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO admins (username, password_hash, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hash, $email);
            if ($stmt->execute()) {
                $success = "Account created! You can now <a href='admin_login.php'>login</a>.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Register</title>
    <link rel="stylesheet" href="cars.css"> 
</head>
<body class="admin-login">
    <div class="login-container">
        <h2>Admin Register</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="success" style="color:#4fffbe;text-align:center;margin-bottom:1em;"><?= $success ?></div>
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
                <input type="password" name="confirm_password" required>
            </label><br><br>
            <button type="submit">Register</button>
        </form>
        <div class="create-account-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
