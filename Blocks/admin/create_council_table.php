<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/get_user.php';


$role = 'council';
$councils = getUsersData($conn, $role);



foreach ($councils as $council) {
  echo 
  '<div class="row">
    <div class="body-cell extra-large">' . htmlspecialchars($council['name']) . '</div>
    <div class="body-cell large">' . htmlspecialchars($council['contact_person']) . ' </div>
    <div class="body-cell medium">
        5
    </div>
    <div class="body-cell large">
        ' . htmlspecialchars($council['region']) . '
    </div>
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
  </div>';
}
