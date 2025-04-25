<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/get_user.php';


$role = 'resident';
$users = getUsersData($conn, $role);

if (!is_array($users)) {
    echo '<p>⚠️ Failed to load resident data.</p>';
    return;
}
foreach ($users as $row) {
    echo '
    <div class="row">
      <div class="body-cell medium">' . htmlspecialchars($row['name']) . '</div>
      <div class="body-cell email large">' . htmlspecialchars($row['email']) . '</div>
      <div class="body-cell medium">' . htmlspecialchars($row['location']) . '</div>
      <div class="body-cell small">' . htmlspecialchars($row['age_group']) . '</div>
      <div class="body-cell large light">' . htmlspecialchars($row['interests']) . '</div>
    </div>';
}
