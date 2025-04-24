<?php
require_once '../../db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        die("❌ User not logged in.");
    }
    $name = $_POST['name'];
    $type = $_POST['type']; // "product" or "service"
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $benefits = $_POST['health-benefits'];
    

    // --- Image Upload Handling ---
    $base_dir = '../../uploads/';
    $base_url = './uploads/';

    $image_name = time() . '_' . basename($_FILES['img']['name']);

    // 👇 Set subfolder based on type
    if ($type === 'product') {
        $upload_folder = 'products/';
    } elseif ($type === 'service') {
        $upload_folder = 'services/';
    } else {
        die("❌ Invalid type!");
    }

    $target_dir = $base_dir . $upload_folder;
    $public_path = $base_url . $upload_folder . $image_name;

    // Make sure the folder exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . $image_name;

    if (!move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
        die("❌ Failed to move uploaded file.");
    }

    if ($type === 'product') {
        $stmt = $conn->prepare("INSERT INTO products (user_id, name, type,  category, price, description, benefits, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssdsss", $user_id, $name, $type, $category, $price, $description, $benefits, $public_path);
    } elseif ($type === 'service') {
        $stmt = $conn->prepare("INSERT INTO services (user_id, name, type, category, price, description, benefits, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssdsss", $user_id, $name, $type, $category, $price, $description, $benefits, $public_path);
    }

    if ($stmt->execute()) {
        if ($type === 'product') {
            header("Location: ../../sme.php?block=dashboard-3-products&status=success");
        } elseif ($type === 'service') {
            header("Location: ../../sme.php?block=dashboard-3-services&status=success");
        }
        
        ?>
        <?php
        
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
