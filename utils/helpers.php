<?php
// File: utils/helpers.php

function createUser($conn, $name, $email, $password, $role)
{
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $passwordHash, $role);
    $stmt->execute();
    return $stmt->insert_id;
}

function insertUserMeta($conn, $user_id, $meta_array)
{
    $stmt = $conn->prepare("INSERT INTO user_meta (user_id, meta_key, meta_value) VALUES (?, ?, ?)");
    foreach ($meta_array as $meta_key => $meta_value) {
        $stmt->bind_param("iss", $user_id, $meta_key, $meta_value);
        $stmt->execute();
    }
}

?>