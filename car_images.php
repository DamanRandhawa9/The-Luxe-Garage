<?php
function getCarImage($conn, $car_id) {
    $sql = "SELECT image_url FROM car_images WHERE car_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return 'default_car.jpg';

    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $img = $result->fetch_assoc();
    $stmt->close();

    // Only return filename
    return $img ? basename($img['image_url']) : 'default_car.jpg';
}
?>
