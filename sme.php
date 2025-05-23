<?php

require_once('auth.php');
require_role('business'); 

include_once './Blocks/sme/sme-sidenav.php';
include 'header-dashboard.php';
// Default block if none selected
$block = $_GET['block'] ?? 'dashboard-1';

// Sanitize allowed blocks (whitelist)
$allowedBlocks = [
  'dashboard-1',
  'dashboard-2',
  'dashboard-3-products',
  'dashboard-3-services',
  'dashboard-4',
  'dashboard-5',
  'dashboard-6',
  'add_certificate_form',
];

if (in_array($block, $allowedBlocks)) {
    include "./Blocks/sme/$block.php";
} else {
    echo "<p>Block not found or not allowed.</p>";
}

include './Blocks/logout-modal.php'; 
?>
