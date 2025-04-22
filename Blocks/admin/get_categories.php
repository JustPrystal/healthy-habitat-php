<?php
require_once '../../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  echo '<div class="row"><div class="body-cell">You are not authorized to view this data.</div></div>';
  exit;
}

$type = $_GET['type'] ?? 'product'; // default to 'product'
$output = $_GET['output'] ?? 'rows';
$user_id = $_SESSION['user_id'];

// Use main categories table
$sql = "SELECT id, category, type, created_at FROM categories WHERE type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $type);
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
while ($row = $result->fetch_assoc()) {
  $categories[] = $row;
}

$stmt->close();
$conn->close();

// 👇 Output logic should go here — depending on `output`
if ($output === 'options') {
  echo get_category_options($categories);
  exit;
}
function get_category_options($categories) {
  $output = '';
  foreach ($categories as $cat) {
    $output .= '<option value="' . htmlspecialchars($cat['category']) . '">' . htmlspecialchars($cat['category']) . '</option>';
  }
  return $output;
}

if (count($categories) > 0) {
  echo get_category_rows($categories);
} else {
  echo '<div class="row"><div class="body-cell">No ' . htmlspecialchars($type) . ' categories found.</div></div>';
}



function get_category_rows($categories) {
  ob_start();
  $i = 1;
  foreach ($categories as $cat) {
    ?>
    <div class="row">
      <div class="body-cell small"><?= $i++ ?></div>
      <div class="body-cell extra-large"><?= htmlspecialchars($cat['category']) ?></div>
      <div class="body-cell extra-small">
        <div class="circle-wrap">
          <div class="circle"></div>
          <div class="circle"></div>
          <div class="circle"></div>
          <div class="actions-wrap">
            <div class="edit"><p>edit</p></div>
            <div class="line"></div>
            <div class="delete"><p>delete</p></div>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
  return ob_get_clean();
}



?>
