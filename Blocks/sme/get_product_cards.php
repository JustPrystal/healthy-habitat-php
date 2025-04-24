<?php
require_once '../../db.php';
require_once './get_products_services.php';
require_once './get_business_user.php';
require_once '../../helpers.php';


$type = $_GET['type'] ?? 'product';
$data = get_user_items($type);

if (isset($data['error'])) {
  if ($data['error'] === 'unauthorized') {
    echo '<div class="row"><div class="body-cell">You are not authorized to view this data.</div></div>';
  } elseif ($data['error'] === 'invalid_type') {
    echo '<div class="row"><div class="body-cell">Invalid type specified.</div></div>';
  }
  exit;
}

if (count($data) > 0) {
  echo get_items_cards($data, $type);
} else {
  echo '<div class="row"><div class="body-cell">No products/services found.</div></div>';
}

function get_items_cards($items, $type)
{
  ob_start();
  foreach ($items as $row) {
    ?>
    <div class="card">
      <div class="image-wrap">
        <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="background image">
        <div class="tags">
          <div class="wrap">
            <div class=" yes up vote-count">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M13.7949 0.750967C13.9262 0.91171 14 1.1297 14 1.35699C14 1.58428 13.9262 1.80226 13.7949 1.96301L5.38967 12.249C5.25832 12.4097 5.08019 12.5 4.89446 12.5C4.70873 12.5 4.5306 12.4097 4.39925 12.249L0.196621 7.10602C0.0690307 6.94436 -0.00156941 6.72783 2.64784e-05 6.50309C0.00162237 6.27834 0.0752865 6.06335 0.205153 5.90442C0.33502 5.7455 0.510699 5.65535 0.694352 5.6534C0.878004 5.65144 1.05494 5.73784 1.18704 5.89398L4.89936 10.437L12.8143 0.750967C12.9457 0.590272 13.1238 0.5 13.3095 0.5C13.4952 0.5 13.6734 0.590272 13.8047 0.750967H13.7949Z"
                  fill="white" />
              </svg>
              <span>
                <?= htmlspecialchars($row['upvotes']) ?>
              </span>
            </div>
            <div class="no down vote-count">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none">
                <path d="M13 13.5L1 1.5M13 1.5L1 13.5" stroke="white" stroke-width="2" stroke-linecap="round" />
              </svg>
              <span>
                <?= htmlspecialchars($row['downvotes']) ?>
              </span>
            </div>
          </div>
          <div class="category">
            <?= htmlspecialchars($row['category']) ?>
          </div>
        </div>
      </div>
      <div class="content-wrap">
        <h4 class="heading">
          <?= htmlspecialchars($row['name']) ?>
        </h4>
        <p class="text">
          <?= htmlspecialchars($row['description']) ?>
        </p>
        <p class="price text">
          <?= '£' . htmlspecialchars($row['price']) . ($type === 'service' ? '/week' : '') ?>
        </p>
        <div class="vote-wrap">
          <span class="text">
            Vote:
          </span>
          <button class="vote-button <?= $type ?> yes" data-id="<?= $row['id'] ?>" data-vote="up" data-type="<?= $type ?>">
            Yes
          </button>
          <button class="vote-button <?= $type ?> no" data-id="<?= $row['id'] ?>" data-vote="down" data-type="<?= $type ?>">
            No
          </button>
        </div>
        <div class="offer-wrap">
          <p class="offer text">
            Offered by: <?= getBusinessUserById($row['user_id'])['name'] ?>
          </p>
        </div>
      </div>
    </div>
    <?php
  }
  ?>
  <script>
    document.querySelectorAll(".vote-button.<?= $type ?>").forEach(button => {
      button.addEventListener("click", async function () {
        const id = this.getAttribute("data-id");
        const type = this.getAttribute("data-type");
        const vote = this.getAttribute("data-vote");
        const parentCard = this.closest(".card");
        const voteWrap = this.closest(".vote-wrap");
        const countSpan = parentCard?.querySelector(`.vote-count.${vote} span`);

        // 🌀 Add loading state
        this.disabled = true;
        this.classList.add("disabled");

        try {
          const response = await fetch('./Blocks/sme/vote.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&type=${type}&vote=${vote}`
          });

          if (response.status === 401) {
            alert("⚠️ You need to be logged in to vote.");
            window.location.href = '<?= get_project_root_url() ?>registration.php?block=sign-in';
            return;
          }

          const data = await response.json();

          if (data.success && countSpan) {
            countSpan.textContent = parseInt(countSpan.textContent) + 1;
            voteWrap.innerText = "Thank you for vote!";
          } else if (data.error) {
            alert(`⚠️ ${data.error}`);
          }
        } catch (error) {
          console.error("Voting failed:", error);
          alert("⚠️ A network error occurred. Please try again.");
        } finally {
          this.disabled = false;
          this.classList.remove("disabled");
        }
      });
    });

  </script>
  <?php
  return ob_get_clean();
}
?>