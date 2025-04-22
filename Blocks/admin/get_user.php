<?php
require_once '../../db.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
  echo '<div class="row"><div class="body-cell">You are not authorized to view this data.</div></div>';
  exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user and their meta information
$sql = "SELECT u.id, u.name, u.email, u.role, um.meta_key, um.meta_value
        FROM users u
        LEFT JOIN user_meta um ON u.id = um.user_id
        WHERE u.id = ?";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

var_dump($result);

// Organize data into associative array
$user = [];
$meta = [];

while ($row = $result->fetch_assoc()) {
  if (empty($user)) {
    $user = [
      'id' => $row['id'],
      'username' => $row['name'],
      'email' => $row['email'],
      'role' => $row['role']
      
    ];
  }
  if ($row['meta_key']) {
    $meta[$row['meta_key']] = $row['meta_value'];
  }
  print_r($meta);
}

$stmt->close();
$conn->close();

// Output HTML
if (!empty($user)) {
  echo get_user_html($user, $meta);
} else {
  echo '<div class="row"><div class="body-cell">User not found.</div></div>';
}
echo '<pre>';
while ($row = $result->fetch_assoc()) {
    print_r($row);
}
echo '</pre>';
exit;


function get_user_html($user, $meta) {
  ob_start();
  ?>
  <div class="row">
    <div class="body-cell medium">
      <?= htmlspecialchars($user['username']) ?>
    </div>
    <div class="body-cell large">
      <?= htmlspecialchars($user['email']) ?>
    </div>
    <div class="body-cell medium">
      <?= htmlspecialchars($user['id'] ?? 'N/A') ?>
    </div>
    <div class="body-cell medium">
      <?= htmlspecialchars($user['role'] ?? 'N/A') ?>
    </div>
    <div class="body-cell medium">
      <?= htmlspecialchars($meta['phone'] ?? 'N/A') ?>
    </div>
    <!-- Add more fields if needed -->
  </div>
  <?php
  return ob_get_clean();
}
?>
