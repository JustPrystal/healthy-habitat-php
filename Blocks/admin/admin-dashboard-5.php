<div class="dashboard-content my-listings">
  <div class="inner">
    <h2 class="content-main-heading">
      Area Management
    </h2>
    <div class="table-wrap">
      <!-- please add sizes(class) for header-cell and body-cell -->
      <div class="table">
        <div class="header">
          <div class="row">
            <div class="header-cell medium">
              Area Name
            </div>
            <div class="header-cell small">
              Type
            </div>
            <div class="header-cell large">
              region
            </div>
            <div class="header-cell large">
              Population Estimate
            </div>
            <div class="header-cell extra-large">
              Assigned Council
            </div>
            <div class="header-cell xs">

            </div>
          </div>
        </div>
        <div class="body" id="location-area">
          <!-- <div class="row">
            <div class="body-cell medium">
              Northbridge
            </div>
            <div class="body-cell small">
              Urban
            </div>
            <div class="body-cell large">
              Greater London
            </div>
            <div class="body-cell large">
              12,400
            </div>
            <div class="body-cell extra-large">
              Camden Borough Council
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
    $.get("./Blocks/admin/get_locations.php", function (data) {
      $("#location-area").html(data);
    });
    $('.table').on('click', '.circle-wrap', function () {
      $(this).closest('.row').find('.actions-wrap').first().toggle();
    });
  });
</script>