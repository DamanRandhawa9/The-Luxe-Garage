<?php
session_start();
require_once 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role']; // 'admin' or 'user'

    if ($role === 'admin') {
        $stmt = $conn->prepare("SELECT admin_id, password_hash FROM admins WHERE username = ?");
    } else {
        $stmt = $conn->prepare("SELECT user_id, password_hash FROM users WHERE username = ?");
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $password_hash);

    if ($stmt->fetch()) {
        if (password_verify($password, $password_hash)) {
            if ($role === 'admin') {
                $_SESSION['admin_id'] = $id;
                header("Location: admin_panel.php");
            } else {
                $_SESSION['user_id'] = $id;
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "Invalid credentials.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - The Luxe Garage</title>
    <link rel="stylesheet" href="cars.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Username:
                <input type="text" name="username" required>
            </label><br><br>
            <label>Password:
                <input type="password" name="password" required>
            </label><br><br>
            <label>Login as:
                <select name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </label><br><br>
            <button type="submit">Login</button>
        </form>
        <div class="create-account-link">
            <p>Need an account? <a href="user_register.php">Register as User</a> | <a href="admin_register.php">Admin Register</a></p>
        </div>
    </div>
</body>
</html>
