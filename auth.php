<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Not logged in
    header("Location: login.php");
    exit();
}

// Optional: restrict access based on role
function require_role($role) {
    if ($_SESSION['user_role'] !== $role) {
        header("Location: unauthorized.php"); // or redirect somewhere else
        exit();
    }
}
?>
