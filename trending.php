<?php
require_once 'includes/db.php';
include 'header.php';
include 'car_images.php';

$sql = "SELECT * FROM cars WHERE trending = 1 ORDER BY date_listed DESC LIMIT 8";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trending Cars - The Luxe Garage</title>
    <link rel="stylesheet" href="cars.css">
</head>
<body>
    <div class="section-header">
        <h2>🔥 Trending this week</h2>
        <p>These cars are catching everyone's attention — grab yours before it's gone!</p>
    </div>

    <div class="cars-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $img_src = getCarImage($conn, $row['car_id']);
                $raw_path = 'resources/' . $img_src;
                if (!file_exists($raw_path)) {
                    $raw_path = 'resources/default_car.jpg';
                }
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
                echo '<span class="status ' . ($row['status'] === 'available' ? 'available' : 'sold') . '">' . ucfirst($row['status']) . '</span>';
                if ($row['verified']) {
                    echo ' <span title="Verified">&#10004;</span>';
                }
                echo '</div></div></a>';
            }
        } else {
            echo '<p style="text-align:center;">No trending cars at the moment.</p>';
        }
        ?>
    </div>

<?php include 'footer.php'; ?>
</body>
</html>
