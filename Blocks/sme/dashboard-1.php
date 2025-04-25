<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  echo '<p>Please <a href="/registration.php?block=sign-in">sign in</a> to view your dashboard.</p>';
  exit;
}

/**
 * Fetch COUNT, SUM(upvotes) and SUM(downvotes) for a given table.
 */
function fetchUserStats(mysqli $conn, string $table, int $userId): array
{
  $sql = "
        SELECT
            COUNT(*)                      AS total_count,
            COALESCE(SUM(upvotes), 0)     AS yes_votes,
            COALESCE(SUM(downvotes), 0)   AS no_votes
        FROM `$table`
        WHERE user_id = ?
    ";

  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    throw new RuntimeException("Prepare failed for {$table}: " . $conn->error);
  }

  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc()
    ?: ['total_count' => 0, 'yes_votes' => 0, 'no_votes' => 0];

  $stmt->close();
  return [
    'total' => (int) $row['total_count'],
    'yes' => (int) $row['yes_votes'],
    'no' => (int) $row['no_votes'],
  ];
}

/**
 * Fetch the top‐voted item (product or service) for the given user,
 * returning name, up/down votes, image URL, description, and price.
 */
function fetchTopItem(mysqli $conn, string $table, int $userId): array
{
  $sql = "
        SELECT
            name            AS item_name,
            upvotes         AS item_votes,
            downvotes       AS item_downvotes,
            image_path      AS item_image,
            description     AS item_description,
            price           AS item_price
        FROM `$table`
        WHERE user_id = ?
          AND upvotes = (
            SELECT COALESCE(MAX(upvotes), 0)
            FROM `$table`
            WHERE user_id = ?
          )
        LIMIT 1
    ";

  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    throw new RuntimeException("Prepare failed for {$table}: " . $conn->error);
  }

  // bind twice for outer query and subquery
  $stmt->bind_param('ii', $userId, $userId);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc()
    ?: [
      'item_name' => null,
      'item_votes' => 0,
      'item_downvotes' => 0,
      'item_image' => null,
      'item_description' => null,
      'item_price' => 0.00
    ];

  $stmt->close();
  return $row;
}

try {
  // Get aggregate stats
  $prodStats = fetchUserStats($conn, 'products', $user_id);
  $svcStats = fetchUserStats($conn, 'services', $user_id);

  // Get top‐voted items
  $prod = fetchTopItem($conn, 'products', $user_id);
  $svc = fetchTopItem($conn, 'services', $user_id);
} catch (RuntimeException $e) {
  // In production, log $e->getMessage() and show a generic error
  echo '<p>Sorry, something went wrong. Please try again later.</p>';
  exit;
}

$conn->close();

// Compute totals
$totalProducts = $prodStats['total'];
$totalServices = $svcStats['total'];
$totalItems = $totalProducts + $totalServices;
$totalYesVotes = $prodStats['yes'] + $svcStats['yes'];
$totalNoVotes = $prodStats['no'] + $svcStats['no'];

// Decide which item wins
if ($svc['item_votes'] >= $prod['item_votes']) {
  $name = $svc['item_name'];
  $description = $svc['item_description'];
  $price = $svc['item_price'];
  $priceDisplay = '£ ' . number_format($price, 2) . ' /week';
  $upvotes = $svc['item_votes'];
  $downvotes = $svc['item_downvotes'];
  $image = $svc['item_image'];
} else {
  $name = $prod['item_name'];
  $description = $prod['item_description'];
  $price = $prod['item_price'];
  $priceDisplay = number_format($price, 2) . ' £';
  $upvotes = $prod['item_votes'];
  $downvotes = $prod['item_downvotes'];
  $image = $prod['item_image'];
}


?>

<div class="dashboard-content dashboard-overview">
  <div class="overview-container">
    <div class="heading-container">
      <h2 class="content-main-heading">Dashboard Overview</h2>
      <p class="content-text">
        Welcome back, BreatheWell Studio! Let's check how your wellness offerings are doing.
      </p>
    </div>
    <div class="card-container">
      <div class="card total-products">
        <h3 class="card-heading">Total Products / Services Listed</h3>
        <p class="total-products total">
          <?= $totalItems ?>
        </p>
        <div class="product-stats">
          <p class="stats-text products-count">Products: <?= $totalProducts ?></p>
          <p class="stats-text services-count">Services: <?= $totalServices ?></p>
        </div>
      </div>

      <div class="card total-votes">
        <h3 class="card-heading">Total Votes Yes / No</h3>
        <p class="total-votes total">
          <?= $totalYesVotes + $totalNoVotes ?> votes
        </p>
        <div class="votes-stats">
          <p class="votes-text yes-count">Yes: <?= $totalYesVotes ?></p>
          <p class="votes-text no-count">No: <?= $totalNoVotes ?></p>
        </div>
      </div>
    </div>

    <!-- Highest-voted block left static here; replace with dynamic if needed -->
    <div class="highest-voted">
      <h3 class="voted-card-heading">
        Highest Voted Product/Service
      </h3>
      <div class="card-content-wrapper">
        <div class="card-left">
          <h4 class="left-heading">
            <?= $name ?>
          </h4>
          <p class="yoga-session">
            <?= $description ?>
          </p>
          <p class="yoga-amount">
            <?= $priceDisplay ?>
          </p>
          <div class="vote-btn-wrapper">
            <button class="vote-button yes-btn">
              <div class="btn-wrapper">
                <svg class="btn-vote-svg" xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13"
                  fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M13.7949 0.750967C13.9262 0.91171 14 1.1297 14 1.35699C14 1.58428 13.9262 1.80226 13.7949 1.96301L5.38967 12.249C5.25832 12.4097 5.08019 12.5 4.89446 12.5C4.70873 12.5 4.5306 12.4097 4.39925 12.249L0.196621 7.10602C0.0690307 6.94436 -0.00156941 6.72783 2.64784e-05 6.50309C0.00162237 6.27834 0.0752865 6.06335 0.205153 5.90442C0.33502 5.7455 0.510699 5.65535 0.694352 5.6534C0.878004 5.65144 1.05494 5.73784 1.18704 5.89398L4.89936 10.437L12.8143 0.750967C12.9457 0.590272 13.1238 0.5 13.3095 0.5C13.4952 0.5 13.6734 0.590272 13.8047 0.750967H13.7949Z"
                    fill="white" />
                </svg>
                <p class="btn-vote-count"><?= $upvotes ?></p>
              </div>
            </button>
            <button class="vote-button no-btn">
              <div class="btn-wrapper">
                <svg class="btn-vote-svg" xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"
                  fill="none">
                  <path d="M13 13.5L1 1.5M13 1.5L1 13.5" stroke="white" stroke-width="2" stroke-linecap="round" />
                </svg>
                <p class="btn-vote-count"><?= $downvotes ?></p>
              </div>
            </button>
          </div>
        </div>
        <div class="card-right">
          <?php if ($image) { ?>
            <img src="<?= $image ?>" alt="" class="card-image">
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>