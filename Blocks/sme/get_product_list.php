<?php
require_once '../../db.php';
require_once './get_products_services.php';

$type = $_GET['type'] ?? 'product';
$auth_required = $_GET['auth_required'] ?? false;
$data = get_user_items($type, $auth_required);

if (isset($data['error'])) {
  if ($data['error'] === 'unauthorized') {
    echo '<div class="row"><div class="body-cell">You are not authorized to view this data.</div></div>';
  } elseif ($data['error'] === 'invalid_type') {
    echo '<div class="row"><div class="body-cell">Invalid type specified.</div></div>';
  }
  exit;
}

if (count($data) > 0) {
  echo get_items_rows($data);
} else {
  echo '<div class="row"><div class="body-cell">No products/services found.</div></div>';
}

function get_items_rows($items)
{
  ob_start();
  foreach ($items as $row) {
    ?>
    <div class="row" data-id="<?= $row['id'] ?>">
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
        <?= htmlspecialchars($row['upvotes'] + $row['downvotes']) ?>
      </div>
      <div class="body-cell small">
        <?= htmlspecialchars($row['upvotes']) ?>
      </div>
      <div class="body-cell small">
        <?= htmlspecialchars($row['downvotes']) ?>
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
            <div class="edit"><p>edit</p></div>
            <div class="line"></div>
            <div class="delete"><p>delete</p></div>
          </div>
        </div>
      </div>
      <div class="body-cell small hidden">
        <?= htmlspecialchars($row['description']) ?>
      </div>
      <div class="body-cell small hidden">
        <?= htmlspecialchars($row['benefits']) ?>
      </div>
    </div>
    <?php
  }
  ?>
    
    <script>
        $('#products-body').on('click', '.circle-wrap .actions-wrap .edit', function () {
          console.log('hello');
        });
    </script>
  <?php
  return ob_get_clean();
}
?>
