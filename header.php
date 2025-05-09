<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthy Habitat Network</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/script.js"></script>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
</head>
<body>

<?php
session_start(); // make sure session is started

?>

<section class="header landing-page-header">
        <div class="inner">
            <div class="logo-wrap">
                <a href="index.php">
                    <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="113" height="50" viewBox="0 0 113 50"
                        fill="none">
                        <path
                            d="M12.16 26.16V50H0.8V0.559998H12.16V24.32H24.24V0.559998H35.6V50H24.24V26.16H12.16ZM52.5506 26.16V50H41.1906V0.559998H52.5506V24.32H64.6306V0.559998H75.9906V50H64.6306V26.16H52.5506ZM83.2613 8.08V33.68C83.3146 35.0133 83.8213 36.2933 84.7813 37.52C85.7946 38.6933 86.8879 39.92 88.0613 41.2C89.2346 42.48 90.3013 43.84 91.2613 45.28C92.2213 46.6667 92.7013 48.24 92.7013 50H81.5813V0.559998H91.4213L110.461 42V16.8C110.408 15.4667 109.875 14.2133 108.861 13.04C107.901 11.8133 106.835 10.5867 105.661 9.36C104.488 8.08 103.421 6.74667 102.461 5.36C101.501 3.92 101.021 2.32 101.021 0.559998H112.141V50H102.621L83.2613 8.08Z"
                            fill="#134027"></path>
                    </svg>
                </a>
            </div>
            <div class="link-wrap">
                <a href="#Home" class="link">Home</a>
                <a href="#About" class="link">About</a>
                <a href="#solutions" class="link">Solutions</a>
            </div>
            
            <div class="button-wrap">
                <?php if (isset($_SESSION['user_name'])): ?>
                    <a 
                    href="
                        <?php
                        if ($_SESSION['user_role'] == 'business') {
                            echo 'sme.php';
                        } elseif ($_SESSION['user_role'] == 'admin') {
                            echo 'admin.php';
                        } elseif ($_SESSION['user_role'] == 'council') {
                            echo 'lc.php';
                        } else {
                            echo 'index.php';
                        }
                        ?>                    
                    ">
                       <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </a>

                    <a href="#" id="logout-link" class="btn button">Logout</a>
                <?php else: ?>
                    <a href="registration.php?block=sign-in" class="sign-in">
                        Sign in
                    </a>
                    <a href="registration.php?block=select-role" class="button">
                        Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="inner-mobile">
            <div class="logo-wrap">
                <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="113" height="50" viewBox="0 0 113 50"
                    fill="none">
                    <path
                        d="M12.16 26.16V50H0.8V0.559998H12.16V24.32H24.24V0.559998H35.6V50H24.24V26.16H12.16ZM52.5506 26.16V50H41.1906V0.559998H52.5506V24.32H64.6306V0.559998H75.9906V50H64.6306V26.16H52.5506ZM83.2613 8.08V33.68C83.3146 35.0133 83.8213 36.2933 84.7813 37.52C85.7946 38.6933 86.8879 39.92 88.0613 41.2C89.2346 42.48 90.3013 43.84 91.2613 45.28C92.2213 46.6667 92.7013 48.24 92.7013 50H81.5813V0.559998H91.4213L110.461 42V16.8C110.408 15.4667 109.875 14.2133 108.861 13.04C107.901 11.8133 106.835 10.5867 105.661 9.36C104.488 8.08 103.421 6.74667 102.461 5.36C101.501 3.92 101.021 2.32 101.021 0.559998H112.141V50H102.621L83.2613 8.08Z"
                        fill="#134027"></path>
                </svg>
            </div>
            <div class="hamburger-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                    role="img" class="iconify iconify--charm icon" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.5" d="M2.75 12.25h10.5m-10.5-4h10.5m-10.5-4h10.5"></path>
                </svg>
            </div>
        </div>
        
</section>
    
</body>
</html>