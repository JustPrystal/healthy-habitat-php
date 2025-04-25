<?php
require_once '../../db.php';
$id = $_POST['id'];
$table = $_POST['table'];

$allowedTables = ['products', 'services', 'locations', 'categories'];
if (!in_array($table, $allowedTables)) {
  http_response_code(400);
  echo "❌ Invalid table name";
  exit;
}

$stmt = $conn->prepare("DELETE FROM `$table` WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
echo "✅ Deleted";

?>