<?php
require_once './db.php';

// Make sure user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  // You can redirect or show an error
  echo '<p>Please <a href="/registration.php?block=sign-in">sign in</a> to view your certifications.</p>';
  return;
}

// Fetch all certifications for this business
$stmt = $conn->prepare("
  SELECT title, image_path, issuer, DATE_FORMAT(created_at, '%M %Y') AS issued
    FROM certifications
   WHERE user_id = ?
   ORDER BY created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$certs = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
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
        <p class="field-value">BreatheWell Studio</p>
      </div>
      <div class="email field-value-wrap">
        <p class="field-name">Email:</p>
        <p class="field-value">info@breathewellstudio.com</p>
      </div>
      <div class="phone field-value-wrap">
        <p class="field-name">Phone:</p>
        <p class="field-value">+44 20 7946 0322</p>
      </div>
      <div class="website field-value-wrap">
        <p class="field-name">Website:</p>
        <p class="field-value"> www.breathewellstudio.com</p>
      </div>
      <div class="address field-value-wrap">
        <p class="field-name">Address:</p>
        <p class="field-value">18 Willow Lane, Camden, London, NW1 7JD, UK</p>
      </div>
    </div>
    <div class="about-studio-container">
      <h3 class="about-studio-heading">
        About BreatheWell Studio
      </h3>
      <div class="para-wrapper">
        <p class="studio-para-1">BreatheWell Studio is a holistic wellness space dedicated to helping individuals find
          balance through mindful movement and breathing. Offering both in-person and online yoga and meditation
          classes, our programs are designed to support mental clarity, physical flexibility, and emotional resilience.
          Whether you're a beginner or an experienced practitioner, BreatheWell provides inclusive, expert-led sessions
          in a serene environment tailored for all levels.</p>
        <p class="studio-para-2">Our mission is to make mindful living accessible to everyone—anytime, anywhere.</p>
      </div>
    </div>
    <div class="certifications">
      <div class="wrap" style="">
        <h3 class="certifications-heading">
          Certifications
        </h3>
        <div class="certifications-btn-wrapper" >
          <a href="sme.php?block=add_certificate_form" class="add-certification-btn">
            Add Certification
          </a>
        </div>
      </div>

      <?php if (count($certs) === 0): ?>
        <p>No certifications added yet.</p>
      <?php else: ?>
        <div class="cards-wrapper">
          <?php foreach ($certs as $cert): ?>
            <div class="each-card">
              <img src="<?= htmlspecialchars($cert['image_path']) ?>" alt="<?= htmlspecialchars($cert['title']) ?>">
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>