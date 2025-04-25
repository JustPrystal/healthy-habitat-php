<div class="dashboard-content my-listings">
  <div class="inner">
    <h2 class="content-main-heading margin-20">
      User Management
    </h2>
    <h3 class="subheading">
      Local Councils
    </h3>
    <div class="table-wrap">
      <!-- please add sizes(class) for header-cell and body-cell -->
      <div class="table">
        <div class="header">
          <div class="row">
            <div class="header-cell extra-large">
              Council Name
            </div>
            <div class="header-cell large">
              Contact Person
            </div>
            <div class="header-cell medium">
              Areas Added
            </div>
            <div class="header-cell large">
              Region
            </div>
          </div>
        </div>
        <div class="body">
          <!-- <div class="row">
            <div class="body-cell extra-large">
              Camden Borough Council
            </div>
            <div class="body-cell large">
              Sarah Thompson
            </div>
            <div class="body-cell medium">
              5
            </div>
            <div class="body-cell large">
              Greater London
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
          </div> -->
          <?php include __DIR__ . '/create_council_table.php'; 
          ?>
      </div>
      </div>
    </div>
  </div>

</div>

<script>
  $(document).ready(function () {
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
  });
</script>