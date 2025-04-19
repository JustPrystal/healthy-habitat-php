<?php
include_once './header.php';
session_start();
if (isset($_SESSION['login_error'])) {
    ?>
    <div class="error-wrap" style="min-height:60vh; display:flex;">
        <p>you ar eauthorized to accessthis page</p>
        <?php echo "<p style='color:red; margin:auto;'>" . $_SESSION['login_error'] . "</p>";
    ?>
    </div>
    <?php
        unset($_SESSION['login_error']);
}
include_once './footer.php';
?>