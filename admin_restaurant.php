<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle restaurant deletion
    if (isset($_POST['delete_restaurant_id'])) {
        $restaurant_id = intval($_POST['delete_restaurant_id']);
        // Delete related menu items and their images
        $menu_items = $conn->query("SELECT image_path FROM menu_items WHERE restaurant_id = $restaurant_id");
        while ($item = $menu_items->fetch_assoc()) {
            if (!empty($item['image_path']) && file_exists($item['image_path'])) {
                unlink($item['image_path']);
            }
        }
        $conn->query("DELETE FROM menu_items WHERE restaurant_id = $restaurant_id");
        // Delete restaurant image
        $res = $conn->query("SELECT image_path FROM restaurants WHERE id = $restaurant_id");
        if ($row = $res->fetch_assoc()) {
            if (!empty($row['image_path']) && file_exists($row['image_path'])) {
                unlink($row['image_path']);
            }
        }
        // Delete restaurant
        $conn->query("DELETE FROM restaurants WHERE id = $restaurant_id");
        http_response_code(200);
        exit();
    }
    // Handle restaurant addition
    if (isset($_POST['restaurant_name'])) {
        $restaurant_name = $_POST['restaurant_name'];
        $location = $_POST['location'];
        // Handle image upload
        $image_path = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "pic/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $image_path = $target_file;
        }
        $sql = "INSERT INTO restaurants (name, location, image_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $restaurant_name, $location, $image_path);
        $stmt->execute();
        header("Location: admin_dashboard.html");
        exit();
    }
}
