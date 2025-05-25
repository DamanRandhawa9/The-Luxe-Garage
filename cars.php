<?php
require_once 'includes/db.php';
include 'header.php';
include 'car_images.php';

$sql = "SELECT * FROM cars ORDER BY date_listed DESC";
$result = $conn->query($sql);

echo '<div class="section-header">';
echo '<h2>Our Exclusive Car Collection</h2>';
echo '<p>Browse our handpicked selection of luxury and performance vehicles curated just for you.</p>';
echo '</div>';


echo '<div class="cars-grid">';
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Fetch image filename from DB
        $img_src = getCarImage($conn, $row['car_id']);

        // Build path and check if the file exists
        $raw_path = 'resources/' . $img_src;
        if (!file_exists($raw_path)) {
            $raw_path = 'resources/default_car.jpg'; // Fallback
        }

        // Safe path for browser
        $image_path = htmlspecialchars($raw_path);
        echo '<a href="car_details.php?id=' . urlencode($row['car_id']) . '" class="car-card-link">';
        echo '<div class="car-card" data-make="' . htmlspecialchars($row['make']) . '" data-model="' . htmlspecialchars($row['model']) . '">';
        echo '<img class="car-image" src="' . $image_path . '" alt="' . htmlspecialchars($row['make'] . ' ' . $row['model']) . '">';
        echo '<div class="car-details">';
        echo '<div class="car-title">' . htmlspecialchars($row['year'] . ' ' . $row['make'] . ' ' . $row['model']) . '</div>';
        echo '<div class="car-meta">Mileage: ' . number_format($row['mileage']) . ' miles</div>';
        echo '<div class="car-meta">Condition: ' . htmlspecialchars($row['car_condition']) . '</div>';
        echo '<div class="car-meta">Location: ' . htmlspecialchars($row['location']) . '</div>';
        echo '<div class="price">$' . number_format($row['price']) . '</div>';
        echo '<div class="car-meta">' . htmlspecialchars($row['description']) . '</div>';
        echo '<span class="status ' . ($row['status'] === 'available' ? 'available' : 'sold') . '">' . ucfirst($row['status']) . '</span>';
        if ($row['verified']) {
            echo ' <span title="Verified">&#10004;</span>';
        }
        echo '</div></div>';
    }
} else {
    echo '<p>No cars found.</p>';
}
echo '</div>';

include 'footer.php';
?>
