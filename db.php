<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "healthy_habitat";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

$conn->query("SET time_zone = '+00:00'");


// Test code in db.php
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>