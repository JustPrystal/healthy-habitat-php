<?php 
require_once '../../db.php';

// Fetch products
$sql1 = "SELECT name, upvotes, downvotes FROM products";
$result1 = $conn->query($sql1);

// Fetch services
$sql2 = "SELECT name, upvotes, downvotes FROM services";
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