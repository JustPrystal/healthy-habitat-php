<?php
require_once '../../db.php';
session_start();

// Ensure user is logged in and is a council
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'council') {
  echo '<div class="row"><div class="body-cell">You are not authorized to view this data.</div></div>';
  exit;
}

$user_id = $_SESSION['user_id'];

// Fetch locations added by this user
$sql = "SELECT id, name, postal_code, region, description, created_at 
        FROM locations 
        WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$locations = [];
while ($row = $result->fetch_assoc()) {
  $locations[] = $row;
}

$stmt->close();
$conn->close();

if (count($locations) > 0) {
  echo get_location_rows($locations);
} else {
  echo '<div class="row"><div class="body-cell">No areas found.</div></div>';
}

// ✅ This function should be *outside* the while loop
function get_location_rows($locations) {
  ob_start();
  foreach ($locations as $row) {
    ?>
    <div class="row" data-id="<?= $row['id'] ?>">
      <div class="body-cell medium" data-field="name"><?= htmlspecialchars($row['name']) ?></div>
      <div class="body-cell medium" data-field="postal-code"><?= htmlspecialchars($row['postal_code']) ?></div>
      <div class="body-cell large" data-field="region"><?= htmlspecialchars($row['region']) ?></div>
      <div class="body-cell medium"><?= date('d M Y', strtotime($row['created_at'])) ?></div>
      <div class="body-cell extra-large light" data-field="description"><?= htmlspecialchars($row['description']) ?></div>
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
