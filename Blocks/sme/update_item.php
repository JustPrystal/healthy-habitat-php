<?php
require_once '../../db.php';
$id = $_POST['id'];
$name = $_POST['name'];
$category = $_POST['category'];
$price = $_POST['price'];
$description = $_POST['description'];

$stmt = $conn->prepare("UPDATE products SET name=?, category=?, price=?, description=? WHERE id=?");
$stmt->bind_param("ssdsi", $name, $category, $price, $description, $id);
$stmt->execute();
echo "✅ Updated";

?>