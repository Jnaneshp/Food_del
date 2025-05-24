<?php
require_once('config.php');
header('Content-Type: application/json');
if (isset($_GET['restaurant_id'])) {
    $restaurant_id = intval($_GET['restaurant_id']);
    $stmt = $conn->prepare("SELECT name, price, image_path, description FROM menu_items WHERE restaurant_id = ?");
    $stmt->bind_param("i", $restaurant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $menu = [];
    while ($row = $result->fetch_assoc()) {
        $menu[] = $row;
    }
    echo json_encode($menu);
    exit();
}
echo json_encode([]);
