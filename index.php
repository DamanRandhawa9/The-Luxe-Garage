<?php
require_once 'includes/db.php';
include 'header.php';

$cars = [];
$result = $conn->query("SELECT c.car_id, c.make, c.model, c.year, c.price, ci.image_url 
                        FROM cars c 
                        LEFT JOIN car_images ci ON c.car_id = ci.car_id 
                        GROUP BY c.car_id 
                        ORDER BY c.date_listed DESC LIMIT 6");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Luxe Garage</title>
    <link rel="stylesheet" href="cars.css">

</head>
<body>
    <!-- Hero Section -->
    <div class="hero">
        <h1>Welcome to The Luxe Garage</h1>
        Where your budget and luxury meet together<br><br>
        <a href="cars.php" class="cta-btn">Explore Cars</a>
    </div>
    <!-- Car Showcase -->
    <div class="showcase">
        <h2>Featured Cars</h2>
        <div class="car-grid">
            <?php foreach($cars as $car): ?>
                <div class="car-card">
                    <img src="<?= htmlspecialchars($car['image_url'] ?: 'resources/default_car.jpg') ?>" alt="Car">
                    <div class="info">
                        <h3><?= htmlspecialchars($car['year']." ".$car['make']." ".$car['model']) ?></h3>
                        <span>$<?= number_format($car['price']) ?></span>
                        <br>
                        <a href="car_details.php?id=<?= $car['car_id'] ?>" class="view-btn">View Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features">
        <h2>Why Choose The Luxe Garage?</h2>
        <div class="features-list">
            <div>✔ Verified Listings</div>
            <div>✔ Secure Payments</div>
            <div>✔ 24/7 Support</div>
            <div>✔ Trusted by Enthusiasts</div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="testimonials">
        <h2>What Our Customers Say</h2>
        <div class="testimonial">
            "Found my dream car at a great price! The Luxe Garage made it easy and safe." <br><strong>- Alex R.</strong>
        </div>
        <div class="testimonial">
            "Fantastic selection and top-notch service. Highly recommended!" <br><strong>- Priya S.</strong>
        </div>
    </div>

    <!-- Newsletter Signup -->
    <div class="newsletter">
        <h2>Stay Updated</h2>
        <form method="post" action="subscribe.php">
            <input type="email" name="email" placeholder="Your email address" required>
            <button type="submit">Subscribe</button>
        </form>
    </div>
   <?php include 'footer.php'; ?>
</body>
</html>
