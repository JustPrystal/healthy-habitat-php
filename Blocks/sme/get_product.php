<?php
require_once '../../db.php';
session_start();

// Ensure user is logged in and is a business
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'business') {
  echo '<div class="row"><div class="body-cell">You are not authorized to view this data.</div></div>';
  exit;
}

$user_id = $_SESSION['user_id'];

// Determine whether to load from products or services table
$type = $_GET['type'] ?? 'product';

// Validate type and set table name
$table = '';
switch ($type) {
  case 'product':
    $table = 'products';
    break;
  case 'service':
    $table = 'services';
    break;
  default:
    echo '<div class="row"><div class="body-cell">Invalid type specified.</div></div>';
    exit;
}



// Fetch product/services added by this user
$sql = "SELECT name, type, category, price, description, benefits, image_path, created_at 
        FROM $table 
        WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
  $items[] = $row;
}

$stmt->close();
$conn->close();

if (count($items) > 0) {
  echo get_items_rows($items);
} else {
  echo '<div class="row"><div class="body-cell">No products/services found.</div></div>';
}

function get_items_rows($items) {
  ob_start();
  foreach ($items as $row) {
    ?>
   
    <div class="row">
        <div class="body-cell medium">
            <?= htmlspecialchars($row['name']) ?>
        </div>
        <div class="body-cell small">   
            <?= htmlspecialchars($row['type']) ?>
        </div>
        <div class="body-cell large">
            <?= htmlspecialchars($row['category']) ?>
        </div>
        <div class="body-cell small">
            <?= htmlspecialchars($row['price']) ?>
        </div>
        <div class="body-cell small">
            1.4k
        </div>
        <div class="body-cell small">
            962
        </div>
        <div class="body-cell small">
            438
        </div>
        <div class="body-cell small">
            Pending
        </div>
        <div class="body-cell extra-small">
            <div class="circle-wrap">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="actions-wrap">
                <div class="edit">
                <p>edit</p>
                </div>
                <div class="line"></div>
                <div class="delete">
                <p>delete</p>
                </div>
            </div>
            </div>
        </div>
    </div>
    <?php
  }
  return ob_get_clean();
}

?>
