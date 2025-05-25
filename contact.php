<?php
session_start();
require_once 'includes/db.php';
include 'header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - The Luxe Garage</title>
    <link rel="stylesheet" href="cars.css">
</head>
<body>
<div class="contact-page-container">
    <h2>Contact Us</h2>

    <div class="contact-flex">
        <!-- Left: Contact Form -->
        <div class="contact-form-box">
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="post">
                <label>Name:<br>
                    <input type="text" name="name" required>
                </label><br>

                <label>Email:<br>
                    <input type="email" name="email" required>
                </label><br>

                <label>Message:<br>
                    <textarea name="message" rows="5" required></textarea>
                </label><br>

                <button type="submit" class="c-btn">Send Message</button>
            </form>
        </div>

        <!-- Right: Support Info -->
        <div class="contact-info-box">
            <h3>Need Assistance?</h3>
            <p>Our friendly support team is here to help you with anything you need.</p>

            <h4>📞 Customer Service</h4>
            <p>Call us at <strong>1300-LUX-CAR</strong></p>
            <h4>📆 Call Centre Hours (AEST)</h4>
            <ul>
                <li>Monday: 9am – 5:30pm</li>
                <li>Tuesday: 9am – 4:30pm (Closed 2:30–3:45pm)</li>
                <li>Wed–Sat: 9am – 5:30pm</li>
                <li>Sunday: 9am – 5:30pm (Closed 11–12pm)</li>
            </ul>

            <h4>📍 Visit Us</h4>
            <p><strong>The Luxe Garage HQ</strong><br>
            20 Hobart Street <br>Southbank NSW 3006</p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
