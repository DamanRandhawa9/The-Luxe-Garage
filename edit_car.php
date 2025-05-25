<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

require_once 'includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: admin_panel.php');
    exit;
}

$car_id = intval($_GET['id']);

// Fetch existing car details
$stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();
$stmt->close();

if (!$car) {
    echo "Car not found.";
    exit;
}

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $verified = isset($_POST['verified']) ? 1 : 0;
    $trending = isset($_POST['trending']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE cars SET status = ?, verified = ?, trending = ? WHERE car_id = ?");
    $stmt->bind_param("siii", $status, $verified, $trending, $car_id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_panel.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Car</title>
    <link rel="stylesheet" href="cars.css">
</head>
<body class="admin-login">
<div class="login-container">
    <h2>Edit Car Status</h2>
    <form method="POST">
        <div>
            <label>Status:</label>
            <select name="status" required>
                <option value="available" <?= $car['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                <option value="sold" <?= $car['status'] === 'sold' ? 'selected' : '' ?>>Sold</option>
            </select>
        </div>

        <div style="margin-top: 1em;">
            <label><input type="checkbox" name="verified" <?= $car['verified'] ? 'checked' : '' ?>> Verified</label>
        </div>

        <div style="margin-top: 1em;">
            <label><input type="checkbox" name="trending" <?= $car['trending'] ? 'checked' : '' ?>> Mark as Trending</label>
        </div>

        <button type="submit" style="margin-top: 1.5em;">Update</button>
        <a href="admin_panel.php" class="admin-btn" style="margin-top: 1em; display: block; text-align: center;">Cancel</a>
    </form>
</div>
</body>
</html>
