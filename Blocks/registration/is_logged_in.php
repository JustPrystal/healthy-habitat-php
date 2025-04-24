<?php
    // Check if user is already logged in
    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
        // Redirect to dashboard or home page
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    
    
        if (isset($_SESSION['user_role'])) {
            switch($_SESSION['user_role']) {
                case 'business':
                    header("Location: sme.php");
                    break;
                case 'admin':
                    header("Location: admin.php");
                    break;
                case 'council':
                    header("Location: lc.php");
                    break;
            
            }
            exit();
        }
    
        exit();
  }

?>