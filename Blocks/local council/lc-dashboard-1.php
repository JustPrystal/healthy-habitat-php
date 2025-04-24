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


// Area Of Interest
$queryTopInterest = "
  SELECT
    meta_value AS area_of_interest,
    COUNT(*)   AS usage_count
  FROM user_meta
  WHERE meta_key = 'areas_of_interest'
  GROUP BY meta_value
  ORDER BY usage_count DESC
  LIMIT 1;
";

$resultTopInterest = $conn->query($queryTopInterest);

if ($resultTopInterest && $row = $resultTopInterest->fetch_assoc()) {
    $areaOfInterest      = $row['area_of_interest'];
    $countAreaOfInterest = $row['usage_count'];
} else {
    $areaOfInterest      = null;
    $countAreaOfInterest = 0;
}

// Top Products
$queryTopProduct = "SELECT
  name         AS product_name,
  upvotes      AS product_votes,
  image_path   AS image_url
FROM products
WHERE upvotes = (
  SELECT MAX(upvotes)
  FROM products
);
";

$resultTopProduct = $conn->query($queryTopProduct);

if ($resultTopProduct && $row = $resultTopProduct->fetch_assoc()) {
    $productName      = $row['product_name'];
    $ProductVotes = $row['product_votes'];
    $productImage = $row['image_url'];
} else {
    $productName      = null;
    $ProductVotes = 0;
    $productImage      = null;

}

// Top service
$queryTopService = "SELECT
  name         AS service_name,
  upvotes      AS service_votes,
  image_path   AS image_url
FROM services
WHERE upvotes = (
  SELECT MAX(upvotes)
  FROM services
);
";

$resultTopService = $conn->query($queryTopService);

if ($resultTopService && $row = $resultTopService->fetch_assoc()) {
    $serviceName      = $row['service_name'];
    $serviceVotes = $row['service_votes'];
    $serviceImage = $row['image_url'];
} else {
    $serviceName      = null;
    $serviceVotes = 0;
    $serviceImage      = null;

}

if ($serviceVotes >= $ProductVotes){
    $name = $serviceName;
    $votes = $serviceVotes;
    $image = $serviceImage;
}
else{
    $name = $productName;
    $votes = $productVotes;
    $image = $productImage;
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
                    Top Interest: <?php echo $areaOfInterest; ?> & <br class="word-break"> (<?php echo $countAreaOfInterest; ?> residents)
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
                            Top Voted Item: <?php echo $name; ?> (<?php echo $votes; ?> votes)
                            
                        </p>
                    </div>
                </div>
                <div class="card-right">
                    <img src="<?php echo $image; ?>" alt="air Purifier" class="card-image">
                </div>
            </div>
        </div>

    </div>
</div>
</div>