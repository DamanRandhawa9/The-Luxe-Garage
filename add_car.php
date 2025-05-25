<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
require_once 'includes/db.php';
include 'header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seller_id = $_SESSION['admin_id'];
    $make = trim($_POST['make']);
    $model = trim($_POST['model']);
    $year = intval($_POST['year']);
    $mileage = intval($_POST['mileage']);
    $price = floatval($_POST['price']);
    $car_condition = trim($_POST['car_condition']);
    $description = trim($_POST['description']);
    $verified = isset($_POST['verified']) ? 1 : 0;
    $location = trim($_POST['location']);
    $status = $_POST['status'];
    $date_listed = date('Y-m-d H:i:s');

    // Handle image upload
    $imagePath = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $imagePath = uniqid('car_', true) . '.' . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], "resources/$imagePath");
    }
    $images = json_encode([$imagePath]);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO cars (seller_id, make, model, year, mileage, price, car_condition, description, verified, location, images, status, date_listed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "issiidssissss",
        $seller_id,
        $make,
        $model,
        $year,
        $mileage,
        $price,
        $car_condition,
        $description,
        $verified,
        $location,
        $images,
        $status,
        $date_listed
    );

    if ($stmt->execute()) {
        $success = "Car added successfully!";
    } else {
        $error = "Error adding car: " . $conn->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Car</title>
    <link rel="stylesheet" href="cars.css">
</head>
<body class="admin-login">
    <div class="admin-panel-container">
        <h2>Add New Car</h2>
        <?php if ($error) echo "<div class='error'>$error</div>"; ?>
        <?php if ($success) echo "<div class='success'>$success</div>"; ?>
        <form method="post" enctype="multipart/form-data">
            <label>Make:
                <input type="text" name="make" required>
            </label>
            <label>Model:
                <input type="text" name="model" required>
            </label>
            <label>Year:
                <input type="number" name="year" required>
            </label>
            <label>Mileage:
                <input type="number" name="mileage" required>
            </label>
            <label>Price:
                <input type="number" step="0.01" name="price" required>
            </label>
            <label>Condition:
                <input type="text" name="car_condition" required>
            </label>
            <label>Description:
                <textarea name="description" rows="3" required></textarea>
            </label>
            <label>Location:
                <input type="text" name="location" required>
            </label>
            <label>Status:
                <select name="status">
                    <option value="available">Available</option>
                    <option value="sold">Sold</option>
                </select>
            </label>
            <label>
                <input type="checkbox" name="verified" value="1"> Verified
            </label>
            <label>Photo:
                <input type="file" name="photo" accept="image/*" required>
            </label>
            <button type="submit">Add Car</button>
        </form>
        <div class="create-account-link">
            <a href="admin_panel.php">Back to Admin Panel</a>
        </div>
    </div>
</body>
</html>
