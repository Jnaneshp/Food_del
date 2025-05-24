<?php
session_start();
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? '');
    $password = trim($_POST["password"] ?? '');
    if ($username === '' || $password === '') {
        echo "<script>alert('Username and password are required!');window.location.href='login.html';</script>";
        exit();
    }
    $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword, $role);
        $stmt->fetch();
        if (password_verify($password, $hashedPassword)) {
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;
            error_log("Role value from DB: " . $role); // Debug output
            $stmt->close();
            $conn->close();
            if ($role === "admin") {
                error_log("Redirecting to admin dashboard"); // Debug output
                header("Location: admin_dashboard.html");
                exit();
            } else {
                error_log("Redirecting to home page"); // Debug output
                header("Location: index.html");
                exit();
            }
        }
    }
    $stmt->close();
    $conn->close();
    echo "<script>alert('Invalid credentials!');window.location.href='login.html';</script>";
    exit();
}
