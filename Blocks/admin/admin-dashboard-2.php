

<?php
// Default block if none selected
$block = $_GET['block'] ?? 'admin-dashboard-2-resident';

// Sanitize allowed blocks (whitelist)
$allowedBlocks = [
  'admin-dashboard-2-resident',
  'admin-dashboard-2-sme.php',
  'admin-dashboard-2-lc',
];

if (in_array($block, $allowedBlocks)) {
    include "./admin-dashboard-2/$block.php";
} else {
    echo "<p>Block not found or not allowed.</p>";
}
?>



        // include './admin-dashboard-2/admin-dashboard-2-resident.php';
        // include './admin-dashboard-2/admin-dashboard-2-sme.php';
        // include './admin-dashboard-2/admin-dashboard-2-lc.php';

<!-- 
</body>

</html> -->