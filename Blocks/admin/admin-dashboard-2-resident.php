<div class="dashboard-content my-listings">
  <div class="inner">
    <h2 class="content-main-heading margin-20">
      User Management
    </h2>
    <h3 class="subheading">
      Residents
    </h3>
    <div class="table-wrap">
      <!-- please add sizes(class) for header-cell and body-cell -->
      <div class="table">
        <div class="header">
          <div class="row">
            <div class="header-cell medium">
              Name
            </div>
            <div class="header-cell large">
              Email
            </div>
            <div class="header-cell medium">
              Area
            </div>
            <div class="header-cell small">
              Age Group
            </div>
            <div class="header-cell large">
              Interests
            </div>
            <div class="header-cell xs">

            </div>
          </div>
        </div>
        <div class="body" id="residents">
          <!-- <div class="row">
            <div class="body-cell medium">
              Sarah Mitchell
            </div>
            <div class="body-cell large">
              sarah.m@gmail.com
            </div>
            <div class="body-cell medium">
              Northbridge
            </div>
            <div class="body-cell small">
              25–34
            </div>
            <div class="body-cell large light">
              Fitness, Nutrition
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
    $.get("./Blocks/admin/get_user.php?role=residents", function (data) {
     $("#residents").html(data);
    });

    // For service categories

    // Actions menu toggle
    $('.table').on('click', '.circle-wrap', function () {
      $(this).closest('.row').find('.actions-wrap').first().toggle();
    });
</script>