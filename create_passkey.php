<?php
require_once 'db_config.php';

function generateSecurePasskey($length = 16) {
    return bin2hex(random_bytes($length));
}

$passkey = 123456789;
$hashed_passkey = password_hash($passkey, PASSWORD_DEFAULT);

$sql = "INSERT INTO admin_passkeys (passkey) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hashed_passkey);

if ($stmt->execute()) {
    echo "Passkey created successfully. Please save this passkey securely: " . $passkey;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();