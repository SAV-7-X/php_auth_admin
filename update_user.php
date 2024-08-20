<?php
session_start();
require_once 'db_config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$new_password = $_POST['new_password'] ?? '';

if (empty($username) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Username and email are required.']);
    exit;
}

$sql = "UPDATE admin_users SET username = ?, email = ?";
$params = [$username, $email];
$types = "ss";

if (!empty($new_password)) {
    $sql .= ", password = ?";
    $params[] = password_hash($new_password, PASSWORD_DEFAULT);
    $types .= "s";
}

$sql .= " WHERE id = ?";
$params[] = $user_id;
$types .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    $_SESSION['username'] = $username;
    echo json_encode(['success' => true, 'message' => 'User details updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update user details.']);
}

$stmt->close();
$conn->close();