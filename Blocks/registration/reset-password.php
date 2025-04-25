<?php
session_start();
require 'db.php';

// Enable error reporting for production debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$token = trim($_GET['token'] ?? '');
$valid_token = false;
$email = '';

if (!empty($token)) {
    try {
        // Use binary comparison for exact token matching
        $stmt = $conn->prepare("SELECT email FROM users WHERE BINARY reset_token = ? AND reset_expiry > UTC_TIMESTAMP()");
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }
        
        $stmt->bind_param("s", $token);
        if (!$stmt->execute()) {
            throw new Exception("Execution error: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $email = $user['email'];
            $valid_token = true;
            
            // Log successful validation (remove in production if not needed)
            error_log("Password reset token validated for: " . $email);
        }
        
    } catch (Exception $e) {
        // Log the error but don't show to users
        error_log("Token validation error: " . $e->getMessage());
        
        // For debugging only - remove in production
        if (isset($_GET['debug'])) {
            echo "<pre>Error: " . htmlspecialchars($e->getMessage()) . "</pre>";
        }
    }
}

// Rest of your form rendering code...
?>

<section class="register-section forgot-password">
    <div class="inner">
        <div class="content-wrap">
            <div class="form-wrap">
                <div class="form-container">
                    <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="113" height="50" viewBox="0 0 113 50" fill="none">
                        <path d="M12.16 26.16V50H0.8V0.559998H12.16V24.32H24.24V0.559998H35.6V50H24.24V26.16H12.16ZM52.5506 26.16V50H41.1906V0.559998H52.5506V24.32H64.6306V0.559998H75.9906V50H64.6306V26.16H52.5506ZM83.2613 8.08V33.68C83.3146 35.0133 83.8213 36.2933 84.7813 37.52C85.7946 38.6933 86.8879 39.92 88.0613 41.2C89.2346 42.48 90.3013 43.84 91.2613 45.28C92.2213 46.6667 92.7013 48.24 92.7013 50H81.5813V0.559998H91.4213L110.461 42V16.8C110.408 15.4667 109.875 14.2133 108.861 13.04C107.901 11.8133 106.835 10.5867 105.661 9.36C104.488 8.08 103.421 6.74667 102.461 5.36C101.501 3.92 101.021 2.32 101.021 0.559998H112.141V50H102.621L83.2613 8.08Z" fill="#134027"></path>
                    </svg>
                    
                    <h3 class="heading">Reset Your Password</h3>
                    
                    <?php if ($valid_token): ?>
                        <form method="POST" action="reset-password-handler.php">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                            
                            <div class="input-wrap password">
                                <label for="password">New Password</label>
                                <div class="password-wrap">
                                    <input type="password" id="password" name="password" required minlength="8">
                                    <span class="toggle-password">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path fill="#134027" d="M12 9.005a4 4 0 1 1 0 8a4 4 0 0 1 0-8M12 5.5c4.613 0 8.596 3.15 9.701 7.564a.75.75 0 1 1-1.455.365a8.504 8.504 0 0 0-16.493.004a.75.75 0 0 1-1.456-.363A10 10 0 0 1 12 5.5"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="input-wrap password">
                                <label for="confirm_password">Confirm New Password</label>
                                <div class="password-wrap">
                                    <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                                    <span class="toggle-password">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path fill="#134027" d="M12 9.005a4 4 0 1 1 0 8a4 4 0 0 1 0-8M12 5.5c4.613 0 8.596 3.15 9.701 7.564a.75.75 0 1 1-1.455.365a8.504 8.504 0 0 0-16.493.004a.75.75 0 0 1-1.456-.363A10 10 0 0 1 12 5.5"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="input-wrap">
                                <button type="submit">Reset Password</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="message error">
                            Invalid or expired password reset link. Please request a new one.
                        </div>
                        <div class="text-wrap">
                            <a href="registration.php?block=forgot-password">Request New Reset Link</a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['reset_message'])): ?>
                        <div class="message <?php echo $_SESSION['reset_message_class'] ?? 'info'; ?>">
                            <?php echo $_SESSION['reset_message']; ?>
                        </div>
                        <?php unset($_SESSION['reset_message'], $_SESSION['reset_message_class']); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(function(icon) {
        icon.addEventListener('click', function() {
            const input = this.closest('.password-wrap').querySelector('input');
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
        });
    });
});

</script>