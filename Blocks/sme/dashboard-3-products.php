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
        <div class="body" id="products-body">
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
          <h3>Edit Product/Service</h3>
          <form id="edit-form">
            <input type="hidden" name="id" id="edit-id">
            <input type="text" name="name" id="edit-name" placeholder="Name" required>
            <input type="text" name="category" id="edit-category" placeholder="Category" required>
            <input type="number" name="price" id="edit-price" placeholder="Price" required>
            <textarea name="description" id="edit-description" placeholder="Description" required></textarea>
            <button type="submit">Save Changes</button>
          </form>
        </div>
      </div>

      <!-- Simple Delete Confirmation -->
      <div id="delete-modal" class="modal hidden">
        <div class="modal-content">
          <span class="close" onclick="closeModal()">&times;</span>
          <p>Are you sure you want to delete this item?</p>
          <button id="confirm-delete">Yes</button>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  $(document).ready(function () {
    $.get("./Blocks/sme /get_product_list.php?type=product&auth_required=true", function (data) {
      $("#products-body").html(data);
    });
    $('.table').on('click', '.circle-wrap', function () {
      $(this).closest('.row').find('.actions-wrap').first().toggle();
    });
    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
      alert('Product has been submitted for review.')
    <?php endif; ?>


    /*Edit logic*/
    let currentId = null;

  // Show edit modal
  $('.edit').click(function () {
    const row = $(this).closest('.row');
    currentId = row.data('id');

    $('#edit-id').val(currentId);
    $('#edit-name').val(row.find('.body-cell').eq(0).text().trim());
    $('#edit-category').val(row.find('.body-cell').eq(2).text().trim());
    $('#edit-price').val(row.find('.body-cell').eq(3).text().trim());
    $('#edit-description').val(row.find('.body-cell').eq(4).text().trim() || '');

    $('#edit-modal').addClass('show');
  });

  // Show delete modal
  $('.delete').click(function () {
    const row = $(this).closest('.row');
    currentId = row.data('id');

    $('#delete-modal').addClass('show');
  });

  // Close modal
  $('.close').click(function () {
    $('.modal').removeClass('show');
  });

  // Handle edit form submit
  $('#edit-form').submit(function (e) {
    e.preventDefault();

    $.post('./update_item.php', $(this).serialize(), function (res) {
      location.reload(); // refresh after edit
    }).fail(function () {
      alert('❌ Update failed');
    });
  });

  // Handle delete confirm
  $('#confirm-delete').click(function () {
    $.post('./delete_item.php', { id: currentId }, function (res) {
      location.reload(); // refresh after delete
    }).fail(function () {
      alert('❌ Delete failed');
    });
  }); 
  });
</script>