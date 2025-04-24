<?php
require_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Products
$queryproduct = "SELECT COUNT(*) AS total_product FROM products";
$resultproduct = $conn->query($queryproduct);
$totalproducts = ($resultproduct) ? $resultproduct->fetch_assoc()['total_product'] : 0;

// Services
$queryservice = "SELECT COUNT(*) AS total_services FROM services";
$resultservice = $conn->query($queryservice);
$totalservices = ($resultservice) ? $resultservice->fetch_assoc()['total_services'] : 0;

$totalProductsandServices = $totalproducts + $totalservices;

// Residents
$queryresidents = "SELECT COUNT(*) AS total_residents FROM users WHERE role='resident'";
$resultresidents = $conn->query($queryresidents);
$totalresidents = ($resultresidents) ? $resultresidents->fetch_assoc()['total_residents'] : 0;

// SMEs
$querysme = "SELECT COUNT(*) AS total_smes FROM users WHERE role='business'";
$resultsme = $conn->query($querysme);
$totalsmes = ($resultsme) ? $resultsme->fetch_assoc()['total_smes'] : 0;

// Councils
$querylc = "SELECT COUNT(*) AS total_lc FROM users WHERE role='council'";
$resultlc = $conn->query($querylc);
$totallcs = ($resultlc) ? $resultlc->fetch_assoc()['total_lc'] : 0;

$conn->close();
?>




<div class="dashboard-content admin-dashboard-overview">
    <div class="overview-container">
        <div class="heading-container">
            <h2 class="content-main-heading">
                Dashboard Overview
            </h2>
        </div>
        <div class="admin-card-container">
            <div class="card total-residents">
                <h3 class="card-heading">
                    Total Residents
                </h3>
                <p class="total-registerd total">
                    Registered individuals who vote on products/services
                </p>
                <h4 class="count">
                <?php echo $totalresidents; ?>
                </h4>
            </div>
            <div class="card total-smes">
                <h3 class="card-heading">
                    Total SMEs
                </h3>
                <p class="total-approved total">
                    Approved wellness product and service providers
                </p>
                <h4 class="count">
                <?php echo $totalsmes; ?>
                </h4>
            </div>
            <div class="card total-coucil">
                <h3 class="card-heading">
                    Total Councils
                </h3>
                <p class="total-local total">
                    Local councils that have onboarded and added areas
                </p>
                <h4 class="count">
                <?php echo $totallcs; ?>
                </h4>
            </div>
            <div class="card total-products">
                <h3 class="card-heading">
                    Total Products/Services
                </h3>
                <p class="total-combine total">
                    Combined number of listed wellness offerings
                </p>
                <h4 class="count">
                <?php echo $totalProductsandServices; ?>
                </h4>
            </div>
            <div class="card total-votes">
                <h3 class="card-heading">
                    Total Votes
                </h3>
                <p class="total-cast total">
                    All Yes/No votes cast by residents so far
                </p>
                <h4 class="count">
                    15,874
                </h4>
            </div>
            <div class="card total-top">
                <h3 class="card-heading">
                    Top Voted Product
                </h3>
                <p class="total-412 total">
                    With 412 Yes votes and 39 No votes
                </p>
                <h4 class="count">
                    PureAir HEPA Filter Purifier
                </h4>
            </div>
        </div>

    </div>
</div>
</div>