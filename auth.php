<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Not logged in
    header("Location: registration.php?block=sign-in");
    exit();
}


// Optional: restrict access based on role
function require_role($requiredRole) {
    if ($_SESSION['user_role'] !== $requiredRole) {
        // Get the correct redirect based on their actual role
        $redirectUrl = 'index.php'; // fallback
        switch ($_SESSION['user_role']) {
            case 'council':
                $redirectUrl = 'lc.php';
                break;
            case 'business':
                $redirectUrl = 'sme.php';
                break;
            case 'resident':
                $redirectUrl = 'index.php';
                break;
            case 'admin':
                $redirectUrl = 'admin.php';
                break;
        }

        echo "<script>
            alert('You are not authorized for this role.');
            window.location.href = '$redirectUrl';
        </script>";
        exit();
    }
}
?>
