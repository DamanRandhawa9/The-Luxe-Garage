<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
require_once 'includes/db.php';


// Fetch admin info
$stmt = $conn->prepare("SELECT username, email FROM admins WHERE admin_id = ?");
$stmt->bind_param("i", $_SESSION['admin_id']);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

// Fetch all admins
$admins = [];
$result = $conn->query("SELECT username, email FROM admins ORDER BY username ASC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
}

// Fetch all cars
$carsResult = $conn->query("SELECT * FROM cars ORDER BY date_listed DESC");

// Fetch all bookings
$bookingsResult = $conn->query("SELECT b.*, c.make, c.model, c.year FROM bookings b LEFT JOIN cars c ON b.car_id = c.car_id ORDER BY b.booking_date DESC");
// Fetch contact messages
$messagesResult = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");

// Fetch all subscribers
$subscribersResult = $conn->query("SELECT * FROM subscribers ORDER BY subscribed_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="cars.css">
</head>
<body class="admin-login">
    <div class="admin-panel-container">
        <h2>Welcome to the Admin Panel</h2>
        <div class="admin-info">
            <strong>Logged in as:</strong> <?= htmlspecialchars($username) ?><br>
            <small><?= htmlspecialchars($email) ?></small>
        </div>
        <hr>

        <!-- Admins -->
        <div class="admin-list">
            <h3>All Admins</h3>
            <table>
                <tr><th>Username</th><th>Email</th></tr>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?= htmlspecialchars($admin['username']) ?></td>
                        <td><?= htmlspecialchars($admin['email']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <hr>

        <!-- Cars -->
<div class="admin-list">
    <h3>Manage Car Listings</h3>
    <a href="add_car.php" class="admin-btn">Add New Car</a>
    <table class="admin-table">
        <tr>
            <th>Photo</th><th>Car</th><th>Price</th><th>Status</th><th>Verified</th><th>Actions</th>
        </tr>
        <?php while ($row = $carsResult->fetch_assoc()):
            // Fetch first image from car_images table
        $img_src = 'default_car.jpg';
        $imgQuery = $conn->prepare("SELECT image_url FROM car_images WHERE car_id = ? LIMIT 1");
        $imgQuery->bind_param("i", $row['car_id']);
        $imgQuery->execute();
        $imgQuery->bind_result($img_url);
        if ($imgQuery->fetch()) {
          $img_file = basename($img_url); // remove any path just in case
        if (file_exists("resources/$img_file")) {
        $img_src = $img_file;
    }
}
$imgQuery->close();

        ?>
        <tr>
            <td>
                <img src="resources/<?= htmlspecialchars($img_src) ?>" alt="Car Image" class="car-thumb">
            </td>
            <td>
                <?= htmlspecialchars($row['year'] . ' ' . $row['make'] . ' ' . $row['model']) ?><br>
                <small><?= htmlspecialchars($row['location']) ?></small>
            </td>
            <td>$<?= number_format($row['price']) ?></td>
            <td><span class="status <?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span></td>
            <td>
                <?= $row['verified'] ? '<span class="verified">&#10004;</span>' : '<span class="not-verified">&#10008;</span>' ?>
            </td>
            <td>
                <a href="edit_car.php?id=<?= $row['car_id'] ?>" class="action-link edit">Edit</a> |
                <a href="delete_car.php?id=<?= $row['car_id'] ?>" class="action-link delete" onclick="return confirm('Delete this car?')">Delete</a> |
                <a href="add_car_images.php?car_id=<?= $row['car_id'] ?>" class="action-link images">Add Images</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

        <hr>

        <!-- Bookings -->
        <div class="admin-list">
            <h3>Recent Bookings</h3>
            <table class="admin-table">
                <tr>
                    <th>Car</th><th>Customer</th><th>Email</th><th>Date</th><th>Booked At</th>
                </tr>
                <?php while ($booking = $bookingsResult->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($booking['year'] . ' ' . $booking['make'] . ' ' . $booking['model']) ?></td>
                    <td><?= htmlspecialchars($booking['name']) ?></td>
                    <td><?= htmlspecialchars($booking['email']) ?></td>
                    <td><?= htmlspecialchars($booking['preferred_date']) ?></td>
                    <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <hr>

        <!-- Subscribers -->
        <div class="admin-list">
            <h3>Subscribers</h3>
            <table class="admin-table">
                <tr><th>Email</th><th>Subscribed At</th></tr>
                <?php if ($subscribersResult && $subscribersResult->num_rows > 0): ?>
                    <?php while ($sub = $subscribersResult->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($sub['email']) ?></td>
                        <td><?= htmlspecialchars($sub['subscribed_at']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="2">No subscribers yet.</td></tr>
                <?php endif; ?>
            </table>
        </div>
        <hr>
<div class="admin-list">
    <h3>Contact Messages</h3>
    <table class="admin-table">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Received At</th>
        </tr>
        <?php if ($messagesResult && $messagesResult->num_rows > 0): ?>
            <?php while ($msg = $messagesResult->fetch_assoc()): ?>
                <tr>
                <td><?= htmlspecialchars($msg['name']) ?></td>
                <td><?= htmlspecialchars($msg['email']) ?></td>
                <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                <td>
                    <?= htmlspecialchars($msg['submitted_at']) ?><br>
                    <a href="delete_message.php?id=<?= $msg['id'] ?>" onclick="return confirm('Delete this message?')" class="action-link delete">Delete</a>
                </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">No messages yet.</td></tr>
        <?php endif; ?>
    </table>
</div>


        <div class="admin-footer">
            <a class="logout-link" href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
