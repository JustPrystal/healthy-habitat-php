<?php
require_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Products count
$queryproduct = "SELECT COUNT(*) AS total_product FROM products";
$resultproduct = $conn->query($queryproduct);

$totalproducts = 0; // default in case query fails
if ($resultproduct) {
    $row = $resultproduct->fetch_assoc();
    $totalproducts = $row['total_product'];
} else {
    echo "Product query failed: " . $conn->error;
}

// Services count
$queryservice = "SELECT COUNT(*) AS total_services FROM services";
$resultservice = $conn->query($queryservice);

$totalservices = 0; // default in case query fails
if ($resultservice) {
    $row = $resultservice->fetch_assoc();
    $totalservices = $row['total_services'];
} else {
    echo "Service query failed: " . $conn->error;
}

$totalProductsandServices = $totalproducts + $totalservices;

$conn->close();
?>



<div class="dashboard-content dashboard-overview">
      
      <div class="overview-container">
        <div class="heading-container">
          <h2 class="content-main-heading">
            Dashboard Overview
          </h2>
          <p class="content-text">
            Welcome back, BreatheWell Studio! Let's check how your wellness offerings are doing.
          </p>
        </div>
        <div class="card-container">
          <div class="card total-products">
            <h3 class="card-heading">
              Total Products/ Services Listed
            </h3>
            <p class="total-products total">
              Total Products/ Service: <?php echo $totalProductsandServices; ?>
            </p>
            <div class="product-stats">
              <p class="stats-text products-count">Products: <?php echo $totalproducts; ?></p>
              <p class="stats-text services-count">Services: <?php echo $totalservices; ?></p>
            </div>
          </div>
          <div class="card total-votes">
            <h3 class="card-heading">
              Total Votes <br class="votes-break"> Yes/NO
            </h3>
            <p class="total-votes total">
              Total votes: 1,734
            </p>
            <div class="votes-stats">
              <p class="votes-text yes-count">Yes: 1.4k</p>
              <p class="votes-text no-count">No: 343</p>
            </div>
          </div>
        </div>
        <div class="highest-voted">
          <h3 class="voted-card-heading">
            Highest Voted Product/Service
          </h3>
          <div class="card-content-wrapper">
            <div class="card-left">
              <h4 class="left-heading">
                ZenGlow Yoga Studio
              </h4>
              <p class="yoga-session">
                Stream calming yoga sessions or join in-studio classes led by certified instructors.
              </p>
              <p class="yoga-amount">
                £10/class, £35/month (online), £55/month (on-site)
              </p>
              <div class="vote-btn-wrapper">
                <button class="vote-button yes-btn">
                  <div class="btn-wrapper">
                    <svg class="btn-vote-svg" xmlns="http://www.w3.org/2000/svg" width="14" height="13"
                      viewBox="0 0 14 13" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M13.7949 0.750967C13.9262 0.91171 14 1.1297 14 1.35699C14 1.58428 13.9262 1.80226 13.7949 1.96301L5.38967 12.249C5.25832 12.4097 5.08019 12.5 4.89446 12.5C4.70873 12.5 4.5306 12.4097 4.39925 12.249L0.196621 7.10602C0.0690307 6.94436 -0.00156941 6.72783 2.64784e-05 6.50309C0.00162237 6.27834 0.0752865 6.06335 0.205153 5.90442C0.33502 5.7455 0.510699 5.65535 0.694352 5.6534C0.878004 5.65144 1.05494 5.73784 1.18704 5.89398L4.89936 10.437L12.8143 0.750967C12.9457 0.590272 13.1238 0.5 13.3095 0.5C13.4952 0.5 13.6734 0.590272 13.8047 0.750967H13.7949Z"
                        fill="white" />
                    </svg>
                    <p class="btn-vote-count">1.1k</p>
                  </div>
                </button>
                <button class="vote-button no-btn">
                  <div class="btn-wrapper">
                    <svg class="btn-vote-svg" xmlns="http://www.w3.org/2000/svg" width="14" height="15"
                      viewBox="0 0 14 15" fill="none">
                      <path d="M13 13.5L1 1.5M13 1.5L1 13.5" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <p class="btn-vote-count">247</p>
                  </div>
                </button>
              </div>
            </div>
            <div class="card-right">
              <img src="./assets/highest voted image.png" alt="" class="card-image">
            </div>
          </div>
        </div>

      </div>
    </div>