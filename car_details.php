<?php
require_once 'includes/db.php';
include 'header.php';
include 'car_images.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Invalid car ID.</p>";
    include 'footer.php';
    exit;
}

$car_id = intval($_GET['id']);

// Fetch car info
$stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();
$stmt->close();

if (!$car) {
    echo "<p>Car not found.</p>";
    include 'footer.php';
    exit;
}

// Get image
$image = getCarImage($conn, $car_id);
?>

<link rel="stylesheet" href="cars.css">

<div class="car-details-page">
   <h2 class="car-title"><?= htmlspecialchars("{$car['year']} {$car['make']} {$car['model']}") ?></h2>

    <img src="resources/<?= htmlspecialchars($image) ?>" alt="Car" class="car-details-image">

    <p><strong>Price:</strong> $<?= number_format($car['price']) ?></p>
    <p><strong>Mileage:</strong> <?= number_format($car['mileage']) ?> miles</p>
    <p><strong>Condition:</strong> <?= htmlspecialchars($car['car_condition']) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($car['location']) ?></p>
    <p><strong>Status:</strong> <?= ucfirst($car['status']) ?> <?= $car['verified'] ? '✅ Verified' : '' ?></p>
    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($car['description'])) ?></p>

    <a href="cars.php" class="c-btn" >⬅ Back to Listings</a>

    <!-- Buy Now Button -->
    <button id="buyCarBtn" class="c-btn">Buy This Car</button>

</div>

<!-- Booking Modal -->
<div id="bookingModal">
    <div class="modal-content">
        <h3>Book a Test Drive or Appointment</h3>
        <form method="post" action="booking_submit.php">
            <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">
            <label>Your Name</label>
            <input type="text" name="name" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Preferred Date</label>
            <input type="date" name="date" required>
            <button type="submit">Submit Booking</button>
            <button type="button" id="cancelModalBtn" class="cancel-btn">Cancel</button>

        </form>
    </div>
</div>

<script src="script.js"></script>

<?php include 'footer.php'; ?>
