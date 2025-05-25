<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = intval($_POST['car_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $date = $_POST['date'];

    $stmt = $conn->prepare("INSERT INTO bookings (car_id, name, email, preferred_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $car_id, $name, $email, $date);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Booking submitted! We will contact you soon.'); window.location.href='cars.php';</script>";
    exit;
}
?>
