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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Segoe+UI:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #ff6b35;
            --secondary-color: #004e64;
            --accent-color: #f9dc5c;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --white: #ffffff;
            --light-bg: #f8f9fa;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
            --gradient: linear-gradient(135deg, var(--primary-color), #ff8f65);
            --border-radius: 12px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--white);
        }

        header {
            background: linear-gradient(135deg, var(--secondary-color), #006080);
            color: var(--white);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        header h1 {
            font-size: 2rem;
            font-weight: 700;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        nav {
            display: flex;
            gap: 2rem;
            align-items: center;
            flex-wrap: wrap;
        }

        nav a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        nav a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient);
            transition: left 0.3s ease;
            z-index: -1;
        }

        nav a:hover::before {
            left: 0;
        }

        nav a:hover {
            transform: translateY(-2px);
        }

        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .profile-container {
            max-width: 500px;
            margin: 2rem auto 0 auto;
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 2rem;
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eee;
            margin-bottom: 16px;
            display: block;
            margin-left: auto;
            margin-right: auto;
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
            background: linear-gradient(90deg, #ff6f00 60%, #ffa040 100%);
            color: #fff;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 1.2rem;
            box-shadow: 0 2px 8px rgba(255, 111, 0, 0.08);
            transition: background 0.3s;
            width: 100%;
        }

        .profile-form button:hover {
            background: linear-gradient(90deg, #ffa040 60%, #ff6f00 100%);
        }

        .orders-section {
            margin-top: 40px;
        }

        .orders-section table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px #eee;
            overflow: hidden;
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

        .footer {
            background: #222;
            color: #fff;
            padding: 2rem 0 0.5rem 0;
            margin-top: 3rem;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .footer-section {
            flex: 1 1 200px;
            margin-bottom: 1.5rem;
        }

        .footer-section h4 {
            color: #ff6f00;
            margin-bottom: 0.8rem;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            color: #ffe0b2;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: #fff;
        }

        .footer-bottom {
            text-align: center;
            padding: 1rem 0 0.5rem 0;
            border-top: 1px solid #444;
            font-size: 0.95rem;
            color: #bbb;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-content">
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
        </div>
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
        <div id="saved-card-section" style="margin-top:24px;"></div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                fetch('get_saved_card.php')
                    .then(response => response.json())
                    .then(data => {
                        let section = document.getElementById('saved-card-section');
                        if (data.success && data.card) {
                            section.innerHTML = `<h3>Saved Card</h3>
                            <div style='background:#f8f9fa;padding:1rem;border-radius:8px;margin-bottom:1rem;'>
                                <strong>Card:</strong> **** **** **** ${data.card.last4}<br>
                                <strong>Expiry:</strong> ${data.card.expiry}
                            </div>`;
                        } else {
                            section.innerHTML = `<h3>Saved Card</h3><div style='color:#888;'>No saved card found.</div>`;
                        }
                    });
            });
        </script>
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