<?php
require_once 'db_config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$submitted_passkey = $_POST['passkey'] ?? '';

$sql = "SELECT passkey FROM admin_passkeys ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_passkey = $row['passkey'];

    if (password_verify($submitted_passkey, $hashed_passkey)) {
        $_SESSION['passkey_verified'] = true;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No passkey found']);
}

$conn->close();