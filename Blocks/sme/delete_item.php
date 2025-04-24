<?php
require_once '../../db.php';
$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
echo "✅ Deleted";

?>