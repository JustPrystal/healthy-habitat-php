<?php
require_once '../../db.php';

$table = $_POST['table'];
if (!in_array($table, ['products', 'services'])) {
  die('❌ Invalid table');
}

$id = $_POST['id'];
$name = $_POST['name'];
$category = $_POST['category'];
$price = $_POST['price'];
$description = $_POST['description'];
$benefits = $_POST['benefits'];

$stmt = $conn->prepare("UPDATE $table SET name=?, category=?, price=?, description=?, benefits=? WHERE id=?");
$stmt->bind_param("ssdssi", $name, $category, $price, $description, $benefits, $id);
$stmt->execute();
echo "✅ Updated";

?>