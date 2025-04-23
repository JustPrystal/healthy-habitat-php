<?php
require_once '../../db.php';

$sql = "
SELECT 
    u.id, u.name, u.email, 
    MAX(CASE WHEN um.meta_key = 'location' THEN um.meta_value END) AS location,
    MAX(CASE WHEN um.meta_key = 'age_group' THEN um.meta_value END) AS age_group,
    MAX(CASE WHEN um.meta_key = 'areas_of_interest' THEN um.meta_value END) AS interests,
    MAX(CASE WHEN um.meta_key = 'contact_person' THEN um.meta_value END) AS contact_person,
    MAX(CASE WHEN um.meta_key = 'region' THEN um.meta_value END) AS region
FROM users u
LEFT JOIN user_meta um ON u.id = um.user_id
WHERE u.role = 'resident'
GROUP BY u.id, u.name, u.email
ORDER BY u.name ASC
";

$result = $conn->query($sql);
$users = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
echo json_encode($users);
