<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/get_user.php';


$role = 'business';
$businesses = getUsersData($conn, $role);

foreach ($businesses as $biz) {
  echo 
  '<div class="row">
    <div class="body-cell large">' . htmlspecialchars($biz['name']) . '</div>
    <div class="body-cell extra-large email">' . htmlspecialchars($biz['email']) . '</div>
    <div class="body-cell large">4</div>
    <div class="body-cell medium">388</div>
    <div class="body-cell small">255</div>
    <div class="body-cell small">113</div>
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
