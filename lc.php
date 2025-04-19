<?php

require_once('auth.php');
require_role('council'); 

include_once './Blocks/local council/lc-sidenav.php';
include 'header-dashboard.php';
// Default block if none selected
$block = $_GET['block'] ?? 'lc-dashboard-1';

// Sanitize allowed blocks (whitelist)
$allowedBlocks = [
  'lc-dashboard-1',
  'lc-dashboard-2',
  'lc-dashboard-3',
  'lc-dashboard-4',
  'dashboard-6'
];

if (in_array($block, $allowedBlocks)) {
    include "./Blocks/local council/$block.php";
} else {
    echo "<p>Block not found or not allowed.</p>";
}
?>
