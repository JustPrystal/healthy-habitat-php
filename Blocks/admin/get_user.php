<?php
require_once __DIR__ . '/../../db.php';

function getUsersData($conn, $role)
{
    $sql = "
SELECT 
    u.id AS user_id,
    u.name,
    u.email,
    u.role,
    um.meta_key,
    um.meta_value
FROM 
    users u
LEFT JOIN 
    user_meta um ON u.id = um.user_id
WHERE 
    u.role = ?
ORDER BY 
    u.name ASC, um.meta_key";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $role);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}
