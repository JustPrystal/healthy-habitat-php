<!-- <?php
    include_once './header.php';

        include './Blocks/registration/step-1.php';
        include './Blocks/registration/sign-in.php';
        include './Blocks/registration/step-3.php';

    include_once './footer.php';
?> -->




<?php
include_once './Blocks/registration/registration-header.php';

// Default block if none selected
$block = $_GET['block'] ?? 'select-role';

// Sanitize allowed blocks (whitelist)
$allowedBlocks = [
    'select-role',
    'sign-in',
    'registration-form',
];

if (in_array($block, $allowedBlocks)) {
    include "./Blocks/registration/$block.php";
} else {
    echo "<p>Block not found or not allowed.</p>";
}
?>
