<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "error" => "User not logged in."]);
    exit;
}

require_once 'config.php';
$username = $_SESSION['username'];

// Remove redundant mysqli connection, use $conn from config.php
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed."]);
    exit;
}

$stmt = $conn->prepare("SELECT card_number, card_expiry FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $card_number = $row['card_number'];
    $last4 = $card_number ? substr($card_number, -4) : null;
    $expiry = $row['card_expiry'];
    if ($card_number && $expiry) {
        echo json_encode([
            "success" => true,
            "card" => [
                "last4" => $last4,
                "expiry" => $expiry,
                "card_number" => $card_number
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "error" => "No saved card found."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No saved card found."]);
}
$stmt->close();
$conn->close();
