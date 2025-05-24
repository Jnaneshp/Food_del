<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodieexpress";
define('ADMIN_REGISTRATION_KEY', '12345');
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
