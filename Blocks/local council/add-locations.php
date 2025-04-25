<?php
require_once '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        die("❌ User not logged in.");
    }
    $name = trim($_POST['name']);
    $postal_code = trim($_POST['zip']);
    $region = $_POST['category'];
    $locationType = $_POST['location-type'];
    $description = trim($_POST['description']);

    $stmt = $conn->prepare("INSERT INTO locations (user_id,name, postal_code, region, location_type, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $name, $postal_code, $region, $locationType, $description);

    if ($stmt->execute()) {
        header("Location: ../../lc.php?block=lc-dashboard-3&status=success");
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>