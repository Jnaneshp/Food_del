<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? '');
    $password = trim($_POST["password"] ?? '');
    if ($username === '' || $password === '') {
        echo "<script>alert('Username and password are required!');window.location.href='register.html';</script>";
        exit();
    }
    // Check if username exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "<script>alert('Username already exists!');window.location.href='register.html';</script>";
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // Default role is 'user'
    $role = 'user';
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $role);
    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.');window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Registration failed!');window.location.href='register.html';</script>";
    }
    $stmt->close();
    $conn->close();
    exit();
}
