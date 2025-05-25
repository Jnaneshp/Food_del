<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT address FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'address' => $row['address']]);
} else {
    echo json_encode(['success' => false, 'error' => 'Address not found']);
}
exit;