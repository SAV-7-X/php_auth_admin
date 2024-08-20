<?php
session_start();
require_once 'db_config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM admin_users WHERE id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    session_destroy();
    echo json_encode(['success' => true, 'message' => 'Account deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete account.']);
}

$stmt->close();
$conn->close();