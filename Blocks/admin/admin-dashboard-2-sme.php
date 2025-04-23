<div class="dashboard-content my-listings">
  <div class="inner">
    <h2 class="content-main-heading margin-20">
      User Management
    </h2>
    <h3 class="subheading">
      SMEs
    </h3>
    <div class="table-wrap">
      <!-- please add sizes(class) for header-cell and body-cell -->
      <div class="table">
        <div class="header">
          <div class="row">
            <div class="header-cell large">
              Business Name
            </div>
            <div class="header-cell extra-large">
              Email
            </div>
            <div class="header-cell large">
              Products Listed
            </div>
            <div class="header-cell medium">
              Total Votes
            </div>
            <div class="header-cell small">
              Yes Votes
            </div>
            <div class="header-cell small">
              No Votes
            </div>
            <div class="header-cell xs">

            </div>
          </div>
        </div>
        <div class="body">
          <!-- <div class="row">
            <div class="body-cell large">
              ZenGlow Yoga Studio
            </div>
            <div class="body-cell large">
              support@zenglow.co.uk
            </div>
            <div class="body-cell large">
              4
            </div>
            <div class="body-cell medium">
              388
            </div>
            <div class="body-cell small">
              255
            </div>
            <div class="body-cell small">
              113
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
          <?php include __DIR__ . '/create_business_table.php'; 
          ?>
        </div>
      </div>
    </div>
  </div>

</div>