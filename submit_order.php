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
$stmt = $conn->prepare("INSERT INTO orders (username, address, items, total, payment_method, status) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiss", $username, $address, $items, $total, $payment_method, $status);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'DB error']);
}
exit;
