<?php
require_once '../../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("❌ Invalid request");
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("❌ User not logged in.");
}

// grab only what the form actually sends
$title = $_POST['title'];
$issuer = $_POST['issuer'];
// we'll store issuer in the `description` field; rename or add a column if you want it separate

// — Image Upload Handling —
$base_dir = '../../uploads/';
$base_url = './uploads/';
$upload_folder = 'certificates/';

$image_name = time() . '_' . basename($_FILES['certificate_img']['name']);
$target_dir = $base_dir . $upload_folder;
$public_path = $base_url . $upload_folder . $image_name;

if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if (!move_uploaded_file($_FILES['certificate_img']['tmp_name'], $target_dir . $image_name)) {
    die("❌ Failed to upload image.");
}

// finally, insert into the correct table with the right columns
$stmt = $conn->prepare("
    INSERT INTO certifications
      (user_id, title, issuer, image_path)
    VALUES
      (?, ?, ?, ?)
");
$stmt->bind_param("isss", $user_id, $title, $issuer, $public_path);

if ($stmt->execute()) {
    header("Location: ../../sme.php?block=dashboard-5");
    exit;
} else {
    echo "❌ Error: " . htmlspecialchars($stmt->error);
}

$stmt->close();
$conn->close();
