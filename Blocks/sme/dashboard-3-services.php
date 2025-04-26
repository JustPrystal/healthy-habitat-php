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
            <div class="header-cell medium">
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
      <!-- Edit Popup Modal -->
      <div id="edit-modal" class="modal hidden">
        <div class="modal-content">
          <span class="close" onclick="closeModal()">&times;</span>
          <h3 class="heading">Edit Service</h3>
          <form id="edit-form">
            <input type="hidden" name="id" id="edit-id">
            <input type="hidden" name="table" value="services">
            <div class="input-wrap">
              <label for="edit-name">Edit Name</label>
              <input type="text" name="name" id="edit-name" placeholder="Name" required>
            </div>
            <div class="input-wrap">
              <label for="edit-category">Edit Category</label>
              <select name="category" id="edit-category" required>
                <option value="">Loading categories...</option>
              </select>
            </div>
            <div class="input-wrap">
              <label for="edit-price">Edit Price</label>
              <input type="number" name="price" id="edit-price" placeholder="Price" required>
            </div>
            <div class="input-wrap">
              <label for="edit-description">Edit description</label>
              <textarea rows="5" name="description" id="edit-description" placeholder="Description" required></textarea>
            </div>
            <div class="input-wrap">
              <label for="edit-benefits">Edit benifits</label>
              <textarea rows="5" name="benefits" id="edit-benefits" placeholder="Benefits" required></textarea>
            </div>
            <button type="submit">Save Changes</button>
          </form>
        </div>
      </div>

      <!-- Simple Delete Confirmation -->
      <div id="delete-modal" class="modal hidden">
        <div class="modal-content">
          <span class="close" onclick="closeModal()">&times;</span>
          <p>Are you sure you want to delete this item?</p>
          <button id="confirm-delete">Yes, Delete</button>
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
    <?php if (isset($_GET['edited']) && $_GET['edited'] === 'success'): ?>
      alert('Service has been edited.')
    <?php endif; ?>
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] === 'success'): ?>
      alert('Service has been deleted.')
    <?php endif; ?>



     /*Edit table logic*/
     function loadCategoriesIntoSelect(callback) {
      $.get('./Blocks/admin/get_categories.php', { type: 'service', output: 'options' }, function (data) {
        $('#edit-category').html(data); // Fill select with <option>s
        if (callback) callback(); // Callback after loading
      });
    }

    let currentId = null;

    // Use event delegation for dynamically generated rows
    $('#services-body'  ).on('click', '.circle-wrap .actions-wrap .edit', function () {
      const row = $(this).closest('.row');
      currentId = row.data('id');

      //prepend values in form
      $('#edit-id').val(currentId);
      row.find('.body-cell').each(function () {
        const field = $(this).data('field');
        if (field) {
          $(`#edit-${field}`).val($(this).text().trim());
        }
      });
      $('body').addClass('noscroll');

      loadCategoriesIntoSelect(function () {
        const currentCategory = row.find('.body-cell').eq(2).text().trim();
        $('#edit-category').val(currentCategory);
      });

      $('#edit-modal').addClass('show');
    });

    $('#services-body').on('click', '.delete', function () {
      const row = $(this).closest('.row');
      currentId = row.data('id');
      $('#delete-modal').addClass('show');
      $('body').addClass('noscroll');
    });

    $(document).on('click', '.close', function () {
      $('.modal').removeClass('show');
      $('body').removeClass('noscroll');
    });
    const baseUrl = window.location.origin + window.location.pathname;
    $('#edit-form').submit(function (e) {
      e.preventDefault();

      $.post('./Blocks/sme/update_item.php', $(this).serialize(), function (res) {
        // location.reload();
        window.location.href = `${baseUrl}?block=dashboard-3-services&edited=success`;
      }).fail(function () {
        alert('❌ Update failed');
      });
    });

    $('#confirm-delete').click(function () {
      const tableName = $('#edit-modal input[name="table"]').val(); 
      $.post('./Blocks/sme/delete_item.php', {
        id: currentId,
        table: tableName
      }, function (res) {
        console.log(res);
        // location.reload();
        window.location.href = `${baseUrl}?block=dashboard-3-services&deleted=success`;
      }).fail(function () {
        alert('❌ Delete failed');
      });
    });
    /*Edit table logic End*/
  });
</script>