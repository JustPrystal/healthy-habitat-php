<?php
require_once 'db.php'; // adjust path if needed

// Optional: Start session if you're using session data
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Query to count rows in the locations table
$query = "SELECT COUNT(*) AS total_locations FROM locations";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $totalLocations = $row['total_locations'];
    echo "Total rows in locations table: " . $totalLocations;
} else {
    echo "Query failed: " . $conn->error;
}




$conn->close();
?>




<div class="dashboard-content lc-dashboard-overview">
    <div class="overview-container">
        <div class="heading-container">
            <h2 class="content-main-heading">
                Dashboard Overview
            </h2>
            <p class="content-text">
                Welcome, Camden Council. Add and manage your local areas to ensure better community
                participation in Healthy Habitat Network.</p>
        </div>
        <div class="lc-card-container">
            <div class="card total-products">
                <h3 class="card-heading">
                    Total Areas Added
                </h3>
                <p class="total-areas total">
                    Total Areas Added:<?php echo $totalLocations; ?>
                </p>
            </div>
            <div class="card total-votes">
                <h3 class="card-heading">
                    Residents Registered in Your Areas
                </h3>
                <p class="total-registered total">
                    Residents Registered: 346
                </p>
            </div>
            <div class="card total-products">
                <h3 class="card-heading">
                    Total Votes from Your Areas
                </h3>
                <p class="total- total">
                    Votes Cast: 1,129
                </p>
            </div>
            <div class="card total-votes">
                <h3 class="card-heading">
                    Top Interest Area Among Residents
                </h3>
                <p class="total-votes total">
                    Top Interest: Mental Health & <br class="word-break"> Mindfulness (128 residents)
                </p>
            </div>
        </div>
        <div class="most-popular">
            <div class="card-content-wrapper">
                <div class="card-left">
                    <div class="card total-votes">
                        <h3 class="card-heading">
                        Most Popular Product/Service <br class="word-break">in Your Areas
                        </h3>
                        <p class="total-votes total">
                            Top Voted Item: PureAir HEPA Filter Purifiers (182 votes)
                        </p>
                    </div>
                </div>
                <div class="card-right">
                    <img src="./assets/mostPopular.png" alt="air Purifier" class="card-image">
                </div>
            </div>
        </div>

    </div>
</div>
</div>