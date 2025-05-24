<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}
$username = $_SESSION['username'];
// Fetch user info
$stmt = $conn->prepare("SELECT id, username, full_name, address, photo, phone FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
// Fetch user orders
$order_stmt = $conn->prepare("SELECT id, items, total, status FROM orders WHERE username = ? ORDER BY id DESC");
$order_stmt->bind_param("s", $username);
$order_stmt->execute();
$orders = $order_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {
            max-width: 500px;
            margin: 30px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px #eee;
            padding: 32px;
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eee;
            margin-bottom: 16px;
        }

        .profile-form input[type="text"],
        .profile-form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .profile-form button {
            background: #ff5722;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            cursor: pointer;
        }

        .orders-section {
            margin-top: 40px;
        }

        .orders-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-section th,
        .orders-section td {
            border: 1px solid #eee;
            padding: 8px;
            text-align: left;
        }

        .orders-section th {
            background: #f5f5f5;
        }
    </style>
</head>

<body>
    <header>
        <h1>🍽 FoodieExpress</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="restaurant.php">Restaurants</a>
            <a href="contact.html">Contact</a>
            <a href="about.html">About</a>
            <a href="profile.php">Profile</a>
            <a href="cart.html">Cart (<span id=\"cart-count\">0</span>)</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="profile-container">
        <h2>My Profile</h2>
        <form class="profile-form" method="POST" enctype="multipart/form-data">
            <img src="<?php echo $user['photo'] ? htmlspecialchars($user['photo']) : 'pic/default_profile.png'; ?>" class="profile-photo" id="profilePreview">
            <input type="file" name="photo" accept="image/*" onchange="previewPhoto(event)">
            <input type="text" name="full_name" placeholder="Full Name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" required>
            <input type="text" name="address" placeholder="Address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" required>
            <input type="text" name="phone" placeholder="Phone Number" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
            <button type="submit">Save Changes</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = trim($_POST['full_name']);
            $address = trim($_POST['address']);
            $phone = trim($_POST['phone']);
            $photo_path = $user['photo'];
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $imageTmpPath = $_FILES['photo']['tmp_name'];
                $imageName = basename($_FILES['photo']['name']);
                $targetDir = 'pic/';
                $targetFilePath = $targetDir . uniqid() . '_' . $imageName;
                $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($imageFileType, $allowedTypes)) {
                    if (move_uploaded_file($imageTmpPath, $targetFilePath)) {
                        $photo_path = $targetFilePath;
                    }
                }
            }
            $update_stmt = $conn->prepare("UPDATE users SET full_name=?, address=?, phone=?, photo=? WHERE username=?");
            $update_stmt->bind_param("sssss", $full_name, $address, $phone, $photo_path, $username);
            if ($update_stmt->execute()) {
                echo '<p style="color:green;">Profile updated!</p>';
                echo '<script>setTimeout(()=>{window.location.reload();}, 1000);</script>';
            } else {
                echo '<p style="color:red;">Failed to update profile.</p>';
            }
        }
        ?>
        <div class="orders-section">
            <h3>My Orders</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td>
                            <ul>
                                <?php foreach (json_decode($order['items'], true) as $item): ?>
                                    <li><?php echo htmlspecialchars($item['name']) . ' x' . (isset($item['qty']) ? $item['qty'] : (isset($item['quantity']) ? $item['quantity'] : 1)); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td><?php echo htmlspecialchars($order['total']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($order['status'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let count = cart.reduce((total, item) => total + (item.quantity || item.qty || 1), 0);
            document.getElementById('cart-count').textContent = count;
        });

        function previewPhoto(event) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>