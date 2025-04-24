<?php
session_start();

require_once('../db.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $return_url = $_GET['return'] ?? '../registration.php?block=forgot-password';
    
    try {
        // Validate email
        if (empty($email)) {
            throw new Exception('Please enter your email address');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address');
        }

        // Check if user exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }
        
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 0) {
            throw new Exception('No account found with that email address');
        }

        // Generate token (using proper random_bytes)
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiration
        
        // Update user record with correct column names
        $update = $conn->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE email = ?");
        if (!$update) {
            throw new Exception("Database error: " . $conn->error);
        }
        
        $update->bind_param("sss", $token, $expires, $email);
        if (!$update->execute()) {
            throw new Exception("Database error: " . $update->error);
        }

        // In production, you would send an email here
        $base_path = dirname($_SERVER['PHP_SELF']); // gets /healthy-habitat or similar
        $reset_link = "http://".$_SERVER['HTTP_HOST'].$base_path."/registration.php?block=reset-password&token=$token";
        
        $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'zeeshan.prystech@gmail.com'; // Your email
                    $mail->Password = 'zwkkwidyvcfgeayu'; // Your password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                      // Sender & recipient
                        $mail->setFrom('zeeshan.prystech@gmail.com', 'Healthy Habitat');
                        $mail->addAddress($email); // Sending to user’s email

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset Request';
                    $mail->Body = "Hi there,<br><br>You requested a password reset. Click the link below to reset your password:<br><br>
                        <a href='$reset_link'>$reset_link</a><br><br>
                        If you did not request this, you can safely ignore this email.<br><br>Thanks!";

                    $mail->send();
                } catch (Exception $e) {
                    throw new Exception("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
                }
        $_SESSION['reset_message'] = "Password reset link sent.";
        $_SESSION['reset_message_class'] = 'success';
        
    } catch (Exception $e) {
        $_SESSION['reset_message'] = $e->getMessage();
        $_SESSION['reset_message_class'] = 'error';
        error_log("Password Reset Error: " . $e->getMessage());
    }
    
    header("Location: $return_url");
    exit();
}

header("Location: ../registration.php?block=forgot-password");
exit();
?>
