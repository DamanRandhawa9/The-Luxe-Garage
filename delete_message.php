<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

require_once 'includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: admin_panel.php');
    exit;
}

$msg_id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
$stmt->bind_param("i", $msg_id);
$stmt->execute();
$stmt->close();

header("Location: admin_panel.php");
exit;
?>
