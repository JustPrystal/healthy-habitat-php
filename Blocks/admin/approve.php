<?php
require_once '../../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error' => 'Invalid request method']);
  exit;
}

// Optional: Only allow admins
// if ($_SESSION['user_role'] !== 'admin') {
//   http_response_code(403);
//   echo json_encode(['error' => 'Forbidden']);
//   exit;
// }

$item_id = $_POST['id'] ?? null;
$type = $_POST['type'] ?? null;

if (!$item_id || !is_numeric($item_id) || !in_array($type, ['product', 'service'])) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid parameters']);
  exit;
}

$table = $type === 'product' ? 'products' : 'services';

$stmt = $conn->prepare("UPDATE $table SET status = 'live' WHERE id = ?");
$stmt->bind_param("i", $item_id);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['error' => 'Failed to update item']);
}

$stmt->close();
$conn->close();
