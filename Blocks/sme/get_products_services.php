<?php
require_once __DIR__ . '/../../db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function get_user_items($type, $auth_required = false)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    global $conn;

    $user_role = $_SESSION['user_role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    if ($auth_required) {
        if (!isset($_SESSION['user_id']) || !in_array($user_role, ['business', 'admin'])) {
            return ['error' => 'unauthorized'];
        }
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

    $sql = "SELECT id, name, type, category, price, description, benefits, image_path, created_at, upvotes, downvotes, user_id, status 
            FROM $table";

    // Conditions based on role
    if ($user_role === 'business') {
        $sql .= " WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    } elseif ($user_role === 'admin') {
        $sql .= " ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);
    } else {
        // Public view — only live items
        $sql .= " WHERE status = 'live' ORDER BY created_at DESC";
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