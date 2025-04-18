<?php 
    session_start();
?>
<section class="register-section sign-in">
    <div class="inner">
        <div class="content-wrap">
            <div class="form-wrap">
                <div class="form-container">
                    <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="113" height="50" viewBox="0 0 113 50" fill="none">
                        <path d="M12.16 26.16V50H0.8V0.559998H12.16V24.32H24.24V0.559998H35.6V50H24.24V26.16H12.16ZM52.5506 26.16V50H41.1906V0.559998H52.5506V24.32H64.6306V0.559998H75.9906V50H64.6306V26.16H52.5506ZM83.2613 8.08V33.68C83.3146 35.0133 83.8213 36.2933 84.7813 37.52C85.7946 38.6933 86.8879 39.92 88.0613 41.2C89.2346 42.48 90.3013 43.84 91.2613 45.28C92.2213 46.6667 92.7013 48.24 92.7013 50H81.5813V0.559998H91.4213L110.461 42V16.8C110.408 15.4667 109.875 14.2133 108.861 13.04C107.901 11.8133 106.835 10.5867 105.661 9.36C104.488 8.08 103.421 6.74667 102.461 5.36C101.501 3.92 101.021 2.32 101.021 0.559998H112.141V50H102.621L83.2613 8.08Z" fill="#134027"></path>
                    </svg>
                    <h3 class="heading">
                        Welcome to Healthy Habitat Network.
                    </h3>
                    <?php
                        if (isset($_SESSION['login_error'])) {
                            echo '<div class="error-message">'.$_SESSION['login_error'].'</div>';
                            unset($_SESSION['login_error']);
                        }
                    ?>
                    <form method="POST" action="./login-handler.php">
                        <div class="input-wrap">
                            <label for="email">email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="input-wrap password">
                            <label for="password">password</label>
                            <input type="password" id="password" name="password" required>
                            <a href="#" class="forgot-pass">
                                Forgot your passwrord?
                            </a>
                        </div>

                        <div class="input-wrap">
                            <button type="submit">Sign in</button>
                        </div>
                        <div class="text-wrap">
                            <a href="registration.php?block=select-role">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>