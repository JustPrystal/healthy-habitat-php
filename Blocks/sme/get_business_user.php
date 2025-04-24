<?php
require_once '../../db.php';

function getBusinessUserById($id)
{
    global $conn;

    $id = intval($id);
    if ($id <= 0) {
        return null;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND role = 'business'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = ($result->num_rows > 0) ? $result->fetch_assoc() : null;

    $stmt->close();
    return $user;
}
