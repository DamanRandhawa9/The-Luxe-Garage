
<?php
$conn = new mysqli("localhost", "root", "", "pitch_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['username'] = $username;
        echo "Login successful! Welcome, $username.";
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "No user found.";
}
$conn->close();
?>
