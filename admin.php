<?php

require_once('auth.php');
require_role('admin'); 


include_once './Blocks/admin/admin-sidenav.php';
include 'header-dashboard.php';
// Default block if none selected
$block = $_GET['block'] ?? 'admin-dashboard-1';

// Sanitize allowed blocks (whitelist)
$allowedBlocks = [
  'admin-dashboard-1',
  'admin-dashboard-2-resident',
  'admin-dashboard-2-sme',
  'admin-dashboard-2-lc',
  'admin-dashboard-3',
  'admin-dashboard-4',
  'admin-dashboard-5',
  'admin-dashboard-6',
  'admin-dashboard-7',
  'admin-dashboard-8',
];

if (in_array($block, $allowedBlocks)) {
    include "./Blocks/admin/$block.php";
} else {
    echo "<p>Block not found or not allowed.</p>";
}
?>
