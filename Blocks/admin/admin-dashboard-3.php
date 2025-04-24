<div class="dashboard-content my-listings add-new-product add-new-category">
  <div class="inner">
    <h2 class="content-main-heading">
      Categories
    </h2>
    <h3 class="subheading">
      Add Categories
    </h3>
    <div class="form-container">
      <form action="./Blocks/admin/add_category.php" method="POST" enctype="multipart/form-data">

        <div class="input-wrap type">
          <span class="type-label">Type</span>
          <div class="radio-wrap">
            <div class="field-wrap">
              <input type="radio" id="product" name="type" value="product" required>
              <label for="product">product</label>
            </div>
            <div class="field-wrap">
              <input type="radio" id="service" name="type" value="service" required>
              <label for="service">service</label>
            </div>
          </div>
        </div>
        <div class="input-wrap name">
          <label for="category">Category </label>
          <input type="text" id="category" name="category"  placeholder="Category  e.g., Organic Personal Care" required>
        </div>
        <div class="input-wrap">
          <button type="submit">Add Category</button>
        </div>
      </form>
    </div>

    <div class="categories">
      <div class="table-wrap">
        <!-- please add sizes(class) for header-cell and body-cell -->
        <div class="table">
          <div class="header">
            <div class="row">
              <div class="header-cell small">
                S No
              </div>
              <div class="header-cell extra-large">
                Product
              </div>
              <div class="header-cell extra-small">
              </div>
            </div>
          </div>
          <div class="body" id="product-categories-body">
            <!-- <div class="row">
              <div class="body-cell small">
                1
              </div>
              <div class="body-cell extra-large">
                Organic Personal Care
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
      <div class="table-wrap">
        <!-- please add sizes(class) for header-cell and body-cell -->
        <div class="table">
          <div class="header">
            <div class="row">
              <div class="header-cell small">
                S No
              </div>
              <div class="header-cell extra-large">
                Service
              </div>
              <div class="header-cell extra-small">
              </div>
            </div>
          </div>
          <div class="body" id="service-categories-body">
            <!-- <div class="row">
              <div class="body-cell small">
                1
              </div>
              <div class="body-cell extra-large">
                Organic Personal Care
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
</div>

</div>

<script>
    $.get("./Blocks/admin/get_categories.php?type=product", function (data) {
     $("#product-categories-body").html(data);
    });

    // For service categories
    $.get("./Blocks/admin/get_categories.php?type=service", function (data) {
      $("#service-categories-body").html(data);
    });

    // Actions menu toggle
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
</script>