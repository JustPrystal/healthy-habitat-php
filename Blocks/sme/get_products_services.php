<?php
require_once __DIR__ . '/../../db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function get_user_items($type, $auth_required = false)
{
    if ($auth_required) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'business') {
            return ['error' => 'unauthorized'];
        }
        $user_id = $_SESSION['user_id'];
    }


    switch ($type) {
        case 'product':
            $table = 'products';
            break;
        case 'service':
            $table = 'services';
            break;
        default:
            return ['error' => 'invalid_type'];
    }

    global $conn;
    $sql = "SELECT id, user_id, name, type, category, price, description, benefits, image_path, created_at, upvotes, downvotes 
          FROM $table";
    
    if ($auth_required) {
        $sql .= " WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    } else {
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    $stmt->close();
    return $items;
}
?>