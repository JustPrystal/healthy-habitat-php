<?php
require_once __DIR__ . '/../../db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function get_user_items($auth_required = false)
{
    if ($auth_required) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'business') {
            return ['error' => 'unauthorized'];
        }
        $user_id = $_SESSION['user_id'];
    }


    global $conn;

    $params = [];
    $types = "";

    $sql1 = "SELECT id, name, type, category, price, description, benefits, image_path, created_at, upvotes, downvotes, user_id 
          FROM products";
    $sql2 = "SELECT id, name, type, category, price, description, benefits, image_path, created_at, upvotes, downvotes, user_id 
          FROM services";
    
    if ($auth_required) {
        $sql1 .= " WHERE user_id = ?";
        $sql2 .= " WHERE user_id = ?";
        $params[] = $_SESSION['user_id'];
        $params[] = $_SESSION['user_id'];
        $types = "ii";
    }
    $final_query = "$sql1 UNION ALL $sql2";

    $stmt = $conn->prepare($final_query);

    // Bind parameters if needed
    if ($auth_required) {
        $stmt->bind_param($types, ...$params);
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