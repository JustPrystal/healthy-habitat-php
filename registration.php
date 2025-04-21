<?php
include_once './Blocks/registration/registration-header.php';

// Default block if none selected
$block = $_GET['block'] ?? 'select-role';

// Sanitize allowed blocks (whitelist)
$allowedBlocks = [
    'select-role',
    'sign-in',
    'resident-form',
    'sme-form',
    'lc-form',
    'admin-form'
];

if (in_array($block, $allowedBlocks)) {
    include "./Blocks/registration/$block.php";
} else {
    echo "<p>Block not found or not allowed.</p>";
}
?>
