<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($_SESSION['username'], $data['address'], $data['items'], $data['total'], $data['payment_method'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid data or not logged in']);
    exit;
}
$username = $_SESSION['username'];
$address = $data['address'];
$items = json_encode($data['items']);
$total = floatval($data['total']);
$payment_method = $data['payment_method'];
$status = 'pending';
$card_number = isset($data['card_number']) ? $data['card_number'] : null;
$expiry = isset($data['expiry']) ? $data['expiry'] : null;
$cvv = isset($data['cvv']) ? $data['cvv'] : null;

if ($payment_method === 'card') {
    // Store card details in users table (update profile)
    $update = $conn->prepare("UPDATE users SET card_number=?, card_expiry=?, card_cvv=? WHERE username=?");
    $update->bind_param("ssss", $card_number, $expiry, $cvv, $username);
    $update->execute();
}

$stmt = $conn->prepare("INSERT INTO orders (username, address, items, total, payment_method, status) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiss", $username, $address, $items, $total, $payment_method, $status);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'DB error']);
}
exit;
