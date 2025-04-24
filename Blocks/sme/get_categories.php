<?php
require_once '../../db.php';

$type = isset($_GET['type']) ? $_GET['type'] : 'product'; // default to 'product'

// Prepare SQL statement
$stmt = $conn->prepare("SELECT DISTINCT category FROM categories WHERE type = ?");
$stmt->bind_param("s", $type);
$stmt->execute();
$result = $stmt->get_result();

// Fetch categories
$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category']; // Updated from 'name' to 'category'
}

// Return as JSON
echo json_encode($categories);
$conn->close();