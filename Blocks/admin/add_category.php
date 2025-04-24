<?php
require_once '../../db.php';
session_start();

// Ensure user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo '<div class="row"><div class="body-cell">You are not authorized to view this data.</div></div>';
    exit;
  }
  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $type = $_POST['type'] ?? '';
    $category = trim($_POST['category']);

    // Check if category already exists
    $check = $conn->prepare("SELECT id FROM categories WHERE user_id = ? AND type = ? AND category = ?");
    $check->bind_param("iss", $user_id, $type, $category);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "⚠️ Category already exists!";
        $check->close();
        $conn->close();
        exit;
    }
    $check->close();

    // Insert new category
    $stmt = $conn->prepare("INSERT INTO categories (user_id, type, category) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $type, $category);

    if ($stmt->execute()) {
        header("Location: ../../admin.php?block=admin-dashboard-3&status=success");
    } else {
        echo "❌ Error: " . $stmt->error;
    }


    $stmt->close();
    $conn->close();
}
?>