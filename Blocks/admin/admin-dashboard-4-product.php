<?php
require_once './Blocks/sme/get_products_services.php';


// Load all business users into an associative array
$role = 'business';
require_once './Blocks/admin/get_user.php';
$businesses = getUsersData($conn, $role);
$business_map = [];
foreach ($businesses as $biz) {
  $business_map[$biz['id']] = $biz['name'];
}


$all_items = get_user_items('product');
?>

<div class="dashboard-content my-listings">
  <div class="inner">
    <h2 class="content-main-heading">
      Product Management
    </h2>
    <div class="table-wrap">
      <!-- please add sizes(class) for header-cell and body-cell -->
      <div class="table">
        <div class="header">
          <div class="row">
            <div class="header-cell large">
              Name
            </div>
            <div class="header-cell small">
              Type
            </div>
            <div class="header-cell large">
              Category
            </div>
            <div class="header-cell small">
              Price
            </div>
            <div class="header-cell large">
              SME Name
            </div>
            <div class="header-cell medium">
              Yes/No Votes
            </div>
            <div class="header-cell medium">
              Score
            </div>
            <div class="header-cell medium">
              Status
            </div>
            <div class="header-cell xs">

            </div>
          </div>
        </div>
        <div class="checkbox-wrap"
          style="display: flex; gap: 10px; flex-direction: row; margin-bottom: 10px; justify-content: flex-end;">
          <input id="sort-by-score" name="sort-by-score" type="checkbox">
          <label for="sort-by-score">Sort by score</label>
        </div>
        <div class="body">

          <?php foreach ($all_items as $item): ?>
            <?php
            // Get SME name by user_id (you may want to JOIN this in SQL instead)
            $total_votes = intval($item['upvotes']) + intval($item['downvotes']);
            $score = $total_votes > 0 ? (intval($item['upvotes']) / $total_votes) * 100 : 0; // Calculate percentage
            $sme_name = $business_map[$item['user_id']] ?? 'Unknown';
            ?>
            <div class="row" key="<?= htmlspecialchars($item['id']) ?>">
              <div class="body-cell large"><?= htmlspecialchars($item['name']) ?></div>
              <div class="body-cell small"><?= ucfirst($item['type']) ?></div>
              <div class="body-cell large"><?= htmlspecialchars($item['category']) ?></div>
              <div class="body-cell small">£<?= htmlspecialchars($item['price']) ?></div>
              <div class="body-cell large"><?= htmlspecialchars($sme_name) ?></div>
              <div class="body-cell medium"><?= intval($item['upvotes']) ?> / <?= intval($item['downvotes']) ?></div>
              <div class="body-cell medium"><?= number_format($score, 2) ?>%</div>
              <div class="body-cell medium status <?= htmlspecialchars($item['status']) ?>">
                <?= htmlspecialchars($item['status']) ?>
              </div>
              <div class="body-cell extra-small">
                <div class="circle-wrap">
                  <div class="circle"></div>
                  <div class="circle"></div>
                  <div class="circle"></div>
                  <div class="actions-wrap">
                    <?php if ($item['status'] == "pending") { ?>
                      <div class="line"></div>
                      <div class="approve">
                        <p>approve</p>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  $(document).ready(function () {

    $('.body .row').each(function (index) {
      $(this).attr('data-original-index', index);
    });

    $('.table').on('click', '.circle-wrap', function (e) {
      e.stopPropagation(); // Prevent bubbling to document

      const $popup = $(this).closest('.row').find('.actions-wrap').first();

      // If the clicked popup is already visible, hide it
      if ($popup.is(':visible')) {
        $popup.hide();
      } else {
        $('.actions-wrap').hide(); // Hide others
        $popup.show(); // Show the current one
      }
    });

    // Close all popups when clicking outside
    $(document).on('click', function () {
      $('.actions-wrap').hide();
    });

    $('.approve').click(function (e) {
      e.stopPropagation();

      const $row = $(this).closest('.row');
      const itemId = $row.attr('key');

      $.post('./Blocks/admin/approve.php', { id: itemId, type: "product" })
        .done(function (response) {
          console.log(response);
          alert("Item approved!");
          location.reload();
        })
        .fail(function (xhr) {
          console.error(xhr.responseText);
          alert("Failed to approve item.");
        });
    });


    // Sort by score functionality
    $('#sort-by-score').on('change', function () {
      const $rows = $('.body .row');

      if ($(this).is(':checked')) {
        const sorted = $rows.sort(function (a, b) {
          const aScore = parseFloat($(a).find('.body-cell.medium').eq(1).text()) || 0;
          const bScore = parseFloat($(b).find('.body-cell.medium').eq(1).text()) || 0;
          return bScore - aScore; // Sort by score descending
        });

        $('.body').html(sorted); // Show sorted
      } else {
        const reset = $rows.sort(function (a, b) {
          return $(a).data('original-index') - $(b).data('original-index');
        });

        $('.body').html(reset); // Show original order
      }
    });

  });
</script>