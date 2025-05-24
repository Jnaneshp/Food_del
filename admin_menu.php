<?php
require_once('config.php');

// Fetch all restaurants for dropdown
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT id, name, location, image_path FROM restaurants");
    $restaurants = [];
    while ($row = $result->fetch_assoc()) {
        $restaurants[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($restaurants);
    exit();
}

// Handle menu item addition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $restaurant_id = $_POST['restaurant_id'];
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $targetDir = 'pic/';
        $targetFilePath = $targetDir . uniqid() . '_' . $imageName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($imageTmpPath, $targetFilePath)) {
                $image_path = $targetFilePath;
            }
        }
    }

    $sql = "INSERT INTO menu_items (restaurant_id, name, price, image_path, description) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdss", $restaurant_id, $item_name, $price, $image_path, $description);
    $stmt->execute();
    header("Location: admin_dashboard.html");
    exit();
}
