<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/get_user.php';


$role = 'business';
$businesses = getUsersData($conn, $role);

foreach ($businesses as $biz) {
  $userId = $biz['id'];

  // Count products and services + sum upvotes/downvotes
  $stmt = $conn->prepare("
      SELECT 
          'product' as type, COUNT(*) as count, 
          SUM(upvotes) as upvotes, 
          SUM(downvotes) as downvotes 
      FROM products 
      WHERE user_id = ?
      UNION ALL
      SELECT 
          'service' as type, COUNT(*) as count, 
          SUM(upvotes), 
          SUM(downvotes) 
      FROM services 
      WHERE user_id = ?
  ");
  $stmt->bind_param("ii", $userId, $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  // Default values
  $productCount = $serviceCount = 0;
  $upvotes = $downvotes = 0;

  while ($row = $result->fetch_assoc()) {
      if ($row['type'] === 'product') {
          $productCount = $row['count'];
      } elseif ($row['type'] === 'service') {
          $serviceCount = $row['count'];
      }

      $upvotes += (int)$row['upvotes'];
      $downvotes += (int)$row['downvotes'];
  }

  $totalItems = $productCount + $serviceCount;
  $totalVotes = $upvotes + $downvotes;

  echo 
  '<div class="row">
    <div class="body-cell large">' . htmlspecialchars($biz['name']) . '</div>
    <div class="body-cell extra-large email">' . htmlspecialchars($biz['email']) . '</div>
    <div class="body-cell large">'. $totalItems .'</div>
    <div class="body-cell medium">'. $totalVotes .'</div>
    <div class="body-cell small">'. $upvotes .'</div>
    <div class="body-cell small">'. $downvotes .'</div>
  </div>';
}
