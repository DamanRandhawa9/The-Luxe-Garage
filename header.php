<?php
if (!isset($pageTitle)) $pageTitle = "The Luxe Garage";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="cars.css">
</head>
<body>

<!-- Header Navigation -->
<header class="header">
    <div class="logo">
        <a href="index.php">
            <img src="resources/logo.jpg" alt="LUXE Garage Logo">
        </a>
    </div>
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="cars.php">Cars</a></li>
            <li><a href="trending.php">Trending</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <button class="menu-toggle">&#9776;</button>
    </nav>
</header>
<script src="script.js"></script>
</body>
</html>
