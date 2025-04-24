<div class="dashboard-content my-listings">
  <div class="inner">
    <h2 class="content-main-heading">
      View & Manage My Listings
    </h2>
    <div class="table-wrap">
      <!-- please add sizes(class) for header-cell and body-cell -->
      <div class="table">
        <div class="header">
          <div class="row">
            <div class="header-cell medium">
              Name
            </div>
            <div class="header-cell small">
              type
            </div>
            <div class="header-cell large">
              Category
            </div>
            <div class="header-cell small">
              Price
            </div>
            <div class="header-cell small">
              Total Votes
            </div>
            <div class="header-cell small">
              Votes: Yes
            </div>
            <div class="header-cell small">
              Votes: No
            </div>
            <div class="header-cell small">
              Status
            </div>
            <div class="header-cell xs">

            </div>
          </div>
        </div>
        <div class="body" id="services-body">
          <!-- <div class="row">
            <div class="body-cell medium">
              Lorem Ipsum
            </div>
            <div class="body-cell small">   
              product
            </div>
            <div class="body-cell large">
              Lorem ipsum dolor sit
            </div>
            <div class="body-cell small">
              240$
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
          </div> -->
        </div>
      </div>
    </div>
  </div>

</div>
<script>
  $(document).ready(function () {
    $.get("./Blocks/sme /get_product_list.php?type=service&auth_required=true", function (data) {
      $("#services-body").html(data);
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
    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
      alert('Service has been submitted for review.')
    <?php endif; ?>
  });
</script>