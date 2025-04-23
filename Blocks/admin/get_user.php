<?php
require_once __DIR__ . '/../../db.php';

function getUsersData($conn, $role) {
    $sql = "
    SELECT 
        u.id, u.name, u.email, 
        MAX(CASE WHEN um.meta_key = 'location' THEN um.meta_value END) AS location,
        MAX(CASE WHEN um.meta_key = 'age_group' THEN um.meta_value END) AS age_group,
        MAX(CASE WHEN um.meta_key = 'areas_of_interest' THEN um.meta_value END) AS interests,
        MAX(CASE WHEN um.meta_key = 'contact_person_name' THEN um.meta_value END) AS contact_person,
        MAX(CASE WHEN um.meta_key = 'region' THEN um.meta_value END) AS region
    FROM users u
    LEFT JOIN user_meta um ON u.id = um.user_id
    WHERE u.role = ?  
    GROUP BY u.id, u.name, u.email
    ORDER BY u.name ASC
    ";

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
