<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
require_once 'includes/db.php';

if (!isset($_GET['car_id'])) {
    header('Location: admin_panel.php');
    exit;
}
$car_id = intval($_GET['car_id']);
$error = '';
$success = '';

// Handle image uploads
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photos'])) {
    $files = $_FILES['photos'];
    $uploaded = 0;
    for ($i = 0; $i < count($files['name']); $i++) {
        if ($files['error'][$i] === UPLOAD_ERR_OK) {
            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $fileName = uniqid('car_', true) . '.' . $ext;
            $imagePath = "resources/$fileName";
            move_uploaded_file($files['tmp_name'][$i], $imagePath);
            $image_type = $files['type'][$i];

            $stmt = $conn->prepare("INSERT INTO car_images (car_id, image_url, image_type) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $car_id, $imagePath, $image_type);
            $stmt->execute();
            $stmt->close();
            $uploaded++;
        }
    }
    if ($uploaded > 0) {
        $success = "$uploaded image(s) uploaded successfully!";
    } else {
        $error = "No images uploaded.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Images to Car</title>
    <link rel="stylesheet" href="cars.css">
</head>
<body class="admin-login">
    <div class="admin-panel-container">
        <h2>Add Images to Car #<?= htmlspecialchars($car_id) ?></h2>
        <?php if ($error) echo "<div class='error'>$error</div>"; ?>
        <?php if ($success) echo "<div class='success'>$success</div>"; ?>
        <form method="post" enctype="multipart/form-data">
            <label>Select Images:
                <input type="file" name="photos[]" accept="resources/*" multiple required>
            </label>
            <button type="submit">Upload Images</button>
        </form>
        <div class="create-account-link">
            <a href="admin_panel.php">Back to Admin Panel</a>
        </div>
        <hr>
        <h3>Existing Images</h3>
        <div>
        <?php
        // Show already uploaded images for this car
        $result = $conn->prepare("SELECT image_url FROM car_images WHERE car_id = ?");
        $result->bind_param("i", $car_id);
        $result->execute();
        $result->bind_result($url);
        while ($result->fetch()) {
           echo '<img src="' . htmlspecialchars($url) . '" alt="Car Image" class="uploaded-thumb">';
        }
        $result->close();
        ?>
        </div>
    </div>
</body>
</html>
