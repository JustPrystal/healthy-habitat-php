<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/get_user.php';

function getLocationCountsByUser($conn) {
  $sql = "SELECT user_id, COUNT(*) as location_count FROM locations GROUP BY user_id";
  $result = $conn->query($sql);

  $counts = [];
  while ($row = $result->fetch_assoc()) {
      $counts[$row['user_id']] = $row['location_count'];
  }

  return $counts;
}


$role = 'council';
$councils = getUsersData($conn, $role);
$locationCounts = getLocationCountsByUser($conn);



foreach ($councils as $council) {
  $locationCount = $locationCounts[$council['id']] ?? 0;
  echo 
  '<div class="row">
    <div class="body-cell extra-large">' . htmlspecialchars($council['name']) . '</div>
    <div class="body-cell large">' . htmlspecialchars($council['contact_person']) . ' </div>
    <div class="body-cell medium">
        ' . $locationCount . '
    </div>
    <div class="body-cell large">
        ' . htmlspecialchars($council['region']) . '
    </div>
  </div>';
}
