<?php
require_once 'db.php'; // adjust path if needed

// Optional: Start session if you're using session data
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo '<p>Please <a href="/registration.php?block=sign-in">sign in</a> to view your dashboard.</p>';
    exit;
}

// Query to count rows in the locations table
$query = "SELECT COUNT(*) AS total_locations FROM locations";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $totalLocations = $row['total_locations'];
} else {
    echo "Query failed: " . $conn->error;
}

// Residents Registered in Your Areas
$queryRegisteredAreaResidents = "
 SELECT COUNT(*) AS registered_residents_in_area FROM user_meta um WHERE um.meta_key='location' AND um.meta_value IN (SELECT name FROM locations l WHERE l.user_id=$user_id);";

$RegisteredAreaResidentTopInterest = $conn->query($queryRegisteredAreaResidents);

if ($RegisteredAreaResidentTopInterest && $row = $RegisteredAreaResidentTopInterest->fetch_assoc()) {
    $registerdUser      = $row['registered_residents_in_area'];
} else {
    $registerdUser      = null;
}


// your residents average age 
$queryresidentsAge = "
SELECT 
    meta_value AS age_group,
    COUNT(*) AS frequency
FROM 
    user_meta
WHERE 
    meta_key = 'age_group' 
    AND user_id IN (
        SELECT user_id 
        FROM user_meta um 
        WHERE um.meta_key = 'location' 
        AND um.meta_value IN (
            SELECT name 
            FROM locations l 
            WHERE l.user_id =$user_id
        )
    )
GROUP BY 
    meta_value
ORDER BY 
    frequency DESC
LIMIT 1;";

$residentsAge = $conn->query($queryresidentsAge);

if ($residentsAge && $row = $residentsAge->fetch_assoc()) {
    $areaAge      = $row['age_group'];
} else {
    $areaAge      = null;
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

if ($serviceVotes >= $ProductVotes) {
    $name = $serviceName;
    $votes = $serviceVotes;
    $image = $serviceImage;
} else {
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
                    Residents Registered: <?php echo $registerdUser; ?>
                </p>
            </div>
            <div class="card total-products">
                <h3 class="card-heading">
                    Average Residents Age Group from Your Area
                </h3>
                <p class="total- total">
                    Age Group: <?php echo $areaAge; ?>
                </p>
            </div>
            <div class="card total-votes">
                <h3 class="card-heading">
                    Top Interest Among Your Residents
                </h3>
                <p class="total-votes total">
                    Top Interest: <?php echo $areaOfInterest; ?> with <br class="word-break"> <span>(<?php echo $countAreaOfInterest; ?> residents)</span>
                </p>
            </div>
        </div>
        <div class="most-popular">
            <div class="card-content-wrapper">
                <div class="card-left">
                    <div class="card total-votes">
                        <h3 class="card-heading">
                            Most Popular Product/Service 
                        </h3>
                        <p class="total-votes total">
                            Top Voted Item: <?php echo $name; ?> with <span> (<?php echo $votes; ?> votes) </span>

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