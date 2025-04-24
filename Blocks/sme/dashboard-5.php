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


<div class="dashboard-content bussinues-info-managment">
  <div class="inner">
    <h2 class="content-main-heading">
      Business Info Management
    </h2>
    <div class="details-container">
      <div class="bussines-name field-value-wrap">
        <p class="field-name">Business Name:</p>
        <p class="field-value"><?php echo $user[0]['name'] ?? 'N/A'; ?></p>
      </div>
      <div class="email field-value-wrap">
        <p class="field-name">Email:</p>
        <p class="field-value"><?php echo $user[0]['email'] ?? 'N/A'; ?></p>
      </div>
      <div class="phone field-value-wrap">
        <p class="field-name">Phone:</p>
        <p class="field-value"><?php echo $userMeta['phone'] ?? 'N/A'; ?></p>
      </div>
      <div class="website field-value-wrap">
        <p class="field-name">Website:</p>
        <p class="field-value"><?php echo $userMeta['website'] ?? 'N/A'; ?></p>
      </div>
      <div class="address field-value-wrap">
        <p class="field-name">Address:</p>
        <p class="field-value"><?php echo $userMeta['address'] ?? 'N/A'; ?></p>
      </div>
    </div>
    <div class="about-studio-container">
      <h3 class="about-studio-heading">
        About BreatheWell Studio
      </h3>
      <div class="para-wrapper">
        <p class="studio-para-1"><?php echo $userMeta['about'] ?? 'N/A'; ?></p>
        <p class="studio-para-2">Our mission is to make mindful living accessible to everyone—anytime, anywhere.</p>
      </div>
    </div>
    <div class="certifications">
      <h3 class="certifications-heading">
        Certifications
      </h3>
      <div class="cards-wrapper">
        <div class="each-card certified">
          <img src="./assets/certifiedImage.png" alt="certified">
        </div>
        <div class="each-card natural">
          <img src="./assets/naturalImage.png" alt="natural">
        </div>
        <div class="each-card organic">
          <img src="./assets/organic.png" alt="organic">
        </div>
      </div>
    </div>

  </div>

</div>