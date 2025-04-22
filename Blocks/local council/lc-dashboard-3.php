<div class="dashboard-content my-listings">
  <div class="inner">
    <h2 class="content-main-heading">
      Manage Existing Areas Table
    </h2>
    <div class="table-wrap">
      <!-- please add sizes(class) for header-cell and body-cell -->
      <div class="table">
        <div class="header">
          <div class="row">
            <div class="header-cell medium">
              Area Name
            </div>
            <div class="header-cell medium">
              Postal Code
            </div>
            <div class="header-cell large">
              Region
            </div>
            <div class="header-cell medium">
              Date Added
            </div>
            <div class="header-cell extra-large">
              Brief Description
            </div>
            <div class="header-cell xs">

            </div>
          </div>
        </div>
        <div class="body" id="locations-body">
          <!-- <div class="row">
            <div class="body-cell medium">
              Northbridge
            </div>
            <div class="body-cell medium">
              NW10
            </div>
            <div class="body-cell large">
              Greater London
            </div>
            <div class="body-cell medium">
              07 Apr 2025
            </div>
            <div class="body-cell extra-large light">
              Suburban neighborhood
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
    $.get("./Blocks/local council /get_locations.php", function (data) {
      $("#locations-body").html(data);
    });
    $('.table').on('click', '.circle-wrap', function () {
      $(this).closest('.row').find('.actions-wrap').first().toggle();
    });
  });
</script>