<?php
require_once __DIR__ . '/../../db.php';
session_start();
?>
    <script>
        console.log('in update');
    </script>
<?php

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'council') {
    http_response_code(403);
    echo "Unauthorized";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $postal_code = $_POST['postal-code'];
    $region = $_POST['region'];
    $description = $_POST['description']; 

    $sql = "UPDATE locations SET name = ?, postal_code = ?, region = ?, description = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $name, $postal_code, $region, $description, $id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        echo "✅ Updated successfully";
    } else {
        http_response_code(500);
        echo "❌ Update failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
