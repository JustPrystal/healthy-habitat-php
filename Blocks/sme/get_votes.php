<?php 
require_once '../../db.php';

// Get current user ID
session_start();
$current_user_id = $_SESSION['user_id'] ?? null;

if (!$current_user_id) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Modify queries to filter by user_id
// Fetch products
$sql1 = "SELECT name, upvotes, downvotes FROM products WHERE user_id = $current_user_id AND status = 'live'";
$result1 = $conn->query($sql1);

// Fetch services
$sql2 = "SELECT name, upvotes, downvotes FROM services WHERE user_id = $current_user_id AND status = 'live'";
$result2 = $conn->query($sql2);

$data = [];

// Add products to data
while ($row = $result1->fetch_assoc()) {
    $data[] = [
        'name' => 'Product: ' . $row['name'],
        'upvotes' => $row['upvotes'],
        'downvotes' => $row['downvotes']
    ];
}

// Add services to data
while ($row = $result2->fetch_assoc()) {
    $data[] = [
        'name' => 'Service: ' . $row['name'],
        'upvotes' => $row['upvotes'],
        'downvotes' => $row['downvotes']
    ];
}

echo json_encode($data);
$conn->close();