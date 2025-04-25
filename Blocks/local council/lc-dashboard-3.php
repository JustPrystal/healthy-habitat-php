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
              Type
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
       <!-- Edit Popup Modal -->
       <div id="edit-modal" class="modal hidden">
        <div class="modal-content">
          <span class="close" >&times;</span>
          <h3 class="heading">Edit Areas</h3>
          <form id="edit-location-form">
            <input type="hidden" name="id" id="edit-id">  
            <input type="hidden" name="table" value="locations">
            <div class="input-wrap">
              <label for="edit-name">Edit Name</label>
              <input type="text" name="name" id="edit-name" placeholder="Name" required>
            </div>
            <div class="input-wrap">
              <label for="edit-postal-code">Edit Postal Code</label>
              <input type="text" name="postal-code" id="edit-postal-code" placeholder="Postal Code" pattern="[0-9]*" required>
            </div>
            <div class="input-wrap">
              <label for="edit-region">Edit Region</label>
              <select name="region" id="edit-region" required>
                <option value="" disabled selected>E.g., Greater London, West Yorkshire, Lancashire</option>
                <option value="bedfordshire">Bedfordshire</option>
                <option value="berkshire">Berkshire</option>
                <option value="bristol">Bristol</option>
                <option value="buckinghamshire">Buckinghamshire</option>
                <option value="Cambridgeshire">Cambridgeshire</option>
                <option value="cheshire">Cheshire</option>
              </select>
            </div>
            <div class="input-wrap">
              <label for="edit-type">Edit type</label>
              <select name="type" id="edit-type" required>
                <option value="" disabled selected>Select Type</option>
                <option value="urban">Urban</option>
                <option value="rural">Rural</option>
              </select>
            </div>
            <div class="input-wrap">
              <label for="edit-description">Edit Description</label>
              <textarea rows="5" name="description" id="edit-description" placeholder="Brief Description" required></textarea>
            </div>
            <button type="submit">Save Changes</button>
          </form>
        </div>
      </div>

      <!-- Simple Delete Confirmation -->
      <div id="delete-modal" class="modal hidden">
        <div class="modal-content">
          <span class="close" >&times;</span>
          <p>Are you sure you want to delete this item?</p>
          <button id="confirm-delete">Yes, Delete</button>
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
      alert('Area has been added.')
    <?php endif; ?>
    <?php if (isset($_GET['edited']) && $_GET['edited'] === 'success'): ?>
      alert('Area has been edited.')
    <?php endif; ?>
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] === 'success'): ?>
      alert('Area has been deleted.')
    <?php endif; ?>


    /*Edit table logic*/
    let currentId = null;

    // Use event delegation for dynamically generated rows
    $('#locations-body'  ).on('click', '.circle-wrap .actions-wrap .edit', function () {
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

      $('#edit-modal').addClass('show');
    });

    $('#locations-body').on('click', '.delete', function () {
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
    $('#edit-location-form').submit(function (e) {
      console.log('submitting');
      e.preventDefault();
      $.post('./Blocks/local%20council/update_location.php', $(this).serialize(), function (res) {
        // location.reload();
        window.location.href = `${baseUrl}?block=lc-dashboard-3&edited=success`;
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
        window.location.href = `${baseUrl}?block=lc-dashboard-3&deleted=success`;
      }).fail(function () {
        alert('❌ Delete failed');
      });
    });
    /*Edit table logic End*/
  });
</script>