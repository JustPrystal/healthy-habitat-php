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
                    <form method="POST" action="./login-handler.php">
                        <div class="input-wrap">
                            <label for="email">email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="input-wrap password">
                            <label for="password">password</label>
                            <div class="password-wrap">
                                <input type="password" id="password" name="password" required>
                                <span id="togglePassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="#134027" d="M11.5 18c4 0 7.46-2.22 9.24-5.5C18.96 9.22 15.5 7 11.5 7s-7.46 2.22-9.24 5.5C4.04 15.78 7.5 18 11.5 18m0-12c4.56 0 8.5 2.65 10.36 6.5C20 16.35 16.06 19 11.5 19S3 16.35 1.14 12.5C3 8.65 6.94 6 11.5 6m0 2C14 8 16 10 16 12.5S14 17 11.5 17S7 15 7 12.5S9 8 11.5 8m0 1A3.5 3.5 0 0 0 8 12.5a3.5 3.5 0 0 0 3.5 3.5a3.5 3.5 0 0 0 3.5-3.5A3.5 3.5 0 0 0 11.5 9" />
                                    </svg>
                                </span>
                            </div>
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
                    <script>
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePassword');
    const iconSvgPath = toggleIcon.querySelector('path');

    const eye = "M11.5 18c4 0 7.46-2.22 9.24-5.5C18.96 9.22 15.5 7 11.5 7s-7.46 2.22-9.24 5.5C4.04 15.78 7.5 18 11.5 18m0-12c4.56 0 8.5 2.65 10.36 6.5C20 16.35 16.06 19 11.5 19S3 16.35 1.14 12.5C3 8.65 6.94 6 11.5 6m0 2C14 8 16 10 16 12.5S14 17 11.5 17S7 15 7 12.5S9 8 11.5 8m0 1A3.5 3.5 0 0 0 8 12.5a3.5 3.5 0 0 0 3.5 3.5a3.5 3.5 0 0 0 3.5-3.5A3.5 3.5 0 0 0 11.5 9";
    const eyeOff = "M2 4.27L3.28 3 21 20.72 19.73 22l-2.14-2.14C15.61 20.57 13.62 21 11.5 21c-4.56 0-8.5-2.65-10.36-6.5a10.06 10.06 0 0 1 2.33-3.24L2 4.27M11.5 5c4.56 0 8.5 2.65 10.36 6.5a10.057 10.057 0 0 1-2.89 3.49L15.17 12c.22-.5.33-1.03.33-1.5A3.5 3.5 0 0 0 12 7c-.47 0-.93.11-1.33.3L8.2 4.83C9.2 4.58 10.32 5 11.5 5m0 12a3.5 3.5 0 0 0 3.27-2.17l-1.7-1.7A1.5 1.5 0 0 1 11.5 15a1.5 1.5 0 0 1-1.5-1.5c0-.28.08-.54.22-.76l-1.6-1.6c-.38.55-.62 1.22-.62 1.86a3.5 3.5 0 0 0 3.5 3.5Z";

    toggleIcon.addEventListener('click', function () {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        iconSvgPath.setAttribute('d', isPassword ? eyeOff : eye);
    });
</script>

                    <div class="error-wrap">
                        <?php
                        if (isset($_SESSION['login_error'])) {
                            echo '<div class="error-message">' . $_SESSION['login_error'] . '</div>';
                            unset($_SESSION['login_error']);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>