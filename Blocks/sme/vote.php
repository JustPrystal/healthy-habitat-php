<?php
require_once '../../db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error' => 'Invalid request method']);
  exit;
}

$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['user_role'] ?? null;

if (!$user_id) {
  http_response_code(401);
  echo json_encode(['error' => 'Not logged in']);
  exit;
}

if ($user_role !== 'resident') {
  http_response_code(403);
  echo json_encode(['error' => 'Only residents can vote']);
  exit;
}

$id = $_POST['id'] ?? null;
$type = $_POST['type'] ?? null;
$voteType = $_POST['vote'] ?? null;

if (!$id || !in_array($type, ['product', 'service']) || !in_array($voteType, ['up', 'down'])) {
  http_response_code(400);
  echo json_encode(['error' => 'Missing or invalid parameters']);
  exit;
}

$table = $type === 'product' ? 'products' : 'services';
$column = $voteType === 'up' ? 'upvotes' : 'downvotes';

$stmt = $conn->prepare("UPDATE $table SET $column = $column + 1 WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['error' => 'Failed to vote']);
}

$stmt->close();
$conn->close();
