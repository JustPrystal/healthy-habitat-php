<?php
include_once './header.php';
?>

<div class="error-wrap" style="min-height:60vh; display:flex;">
    <?php
    if (isset($_SESSION['login_error'])) {
        echo "<p style='color:red; margin:auto;'>" . $_SESSION['login_error'] . "</p>";
        unset($_SESSION['login_error']);
    } else {
        echo "<p style='margin:auto;'>You are not authorized to access this page.</p>";
    }
    ?>
</div>

<?php include_once './footer.php'; ?>
