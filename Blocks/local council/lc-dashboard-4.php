<?php
require_once 'db.php';

$user_id = $_SESSION['user_id'] ; // or get this from session: $_SESSION['user_id']

$stmt = $conn->prepare("SELECT meta_key, meta_value FROM user_meta WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$userMeta = [];
while ($row = $result->fetch_assoc()) {
    $userMeta[$row['meta_key']] = $row['meta_value'];
}

$stmt2 = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$user = [];
while ($row = $result2->fetch_assoc()) {
    $user[] = $row;
}


$conn->close();
?>





<div class="dashboard-content local-council">
    <div class="inner">
        <h2 class="content-main-heading">
            Local Council
        </h2>
        <div class="lc-details-container">
            <div class="council-name field-value-wrap">
                <p class="field-name">Council Name:</p>
                <p class="field-value"><?php echo $user[0]['name'] ?? 'N/A'; ?></p>
            </div>
            <div class="email field-value-wrap">
                <p class="field-name">Email Address:</p>
                <p class="field-value"><?php echo $user[0]['email'] ?? 'N/A'; ?></p>
            </div>
            <div class="phone field-value-wrap">
                <p class="field-name">Phone Number:</p>
                <p class="field-value"><?php echo $userMeta['phone_number'] ?? 'N/A'; ?></p>
            </div>
            <div class="contact field-value-wrap">
                <p class="field-name">Contact Person Name:</p>
                <p class="field-value"> <?php echo $userMeta['contact_person_name'] ?? 'N/A'; ?></p>
            </div>
            <div class="designation field-value-wrap">
                <p class="field-name">Designation:</p>
                <p class="field-value"><?php echo $userMeta['designation'] ?? 'N/A'; ?></p>
            </div>
            <div class="country field-value-wrap">
                <p class="field-name">Region/County:</p>
                <p class="field-value"><?php echo $userMeta['region'] ?? 'N/A'; ?></p>
            </div>
            <div class="website field-value-wrap">
                <p class="field-name">Council Website:</p>
                <p class="field-value"><?php echo $userMeta['council_website'] ?? 'N/A'; ?></p>
            </div>
        </div>
    </div>

</div>