<?php
require_once 'config.php';
// Accept order (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    if ($order_id && in_array($status, ['confirmed', 'pending', 'rejected'])) {
        $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $order_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update order']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }
    exit;
}
// GET: fetch all orders
$result = $conn->query("SELECT id, username, address, items, total, status FROM orders ORDER BY id DESC");
$orders = [];
while ($row = $result->fetch_assoc()) {
    $row['items'] = json_decode($row['items'], true);
    $orders[] = $row;
}
echo json_encode($orders);
exit;