<?php
require_once '../../db.php';
session_start();

// Optional: Check if user is logged in (remove this if you want public access)
if (!isset($_SESSION['user_id'])) {
    echo '<div class="row"><div class="body-cell">You are not authorized to view this data.</div></div>';
    exit;
}

// Fetch all locations (no user filter)
$sql = "SELECT name, region FROM locations";
$result = $conn->query($sql);

$locations = [];
while ($row = $result->fetch_assoc()) {
    $locations[] = $row;
}

$conn->close();

if (count($locations) > 0) {
    echo get_location_rows($locations);
} else {
    echo '<div class="row"><div class="body-cell">No areas found.</div></div>';
}

function get_location_rows($locations)
{
    ob_start();
    foreach ($locations as $row) {
?>
        <div class="row">
            <div class="body-cell medium"><?= htmlspecialchars($row['name']) ?></div>
            <div class="body-cell small">urban</div>
            <div class="body-cell large"><?= htmlspecialchars($row['region']) ?></div>
            <div class="body-cell large">12,400</div>
            <div class="body-cell extra-large">Camden Borough Council</div>
            <div class="body-cell extra-small">
                <div class="circle-wrap">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="actions-wrap">
                        <div class="edit"><p>edit</p></div>
                        <div class="line"></div>
                        <div class="delete"><p>delete</p></div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
    return ob_get_clean();
}
?>
