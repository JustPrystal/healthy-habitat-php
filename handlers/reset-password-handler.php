<?php
session_start();

require_once('../db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    try {
        // Validate inputs
        if (empty($token) || empty($email)) {
            throw new Exception('Invalid reset request');
        }
        
        if (empty($password) || empty($confirm_password)) {
            throw new Exception('Please fill in all fields');
        }
        
        if ($password !== $confirm_password) {
            throw new Exception('Passwords do not match');
        }
        
        if (strlen($password) < 8) {
            throw new Exception('Password must be at least 8 characters');
        }
        
        // Verify token is still valid
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND reset_token = ? AND reset_expiry > NOW()");
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }
        
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows !== 1) {
            throw new Exception('Invalid or expired reset link');
        }
        
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Update password and clear reset token
        $update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE email = ?");
        if (!$update) {
            throw new Exception("Database error: " . $conn->error);
        }
        
        $update->bind_param("ss", $hashed_password, $email);
        if (!$update->execute()) {
            throw new Exception("Database error: " . $update->error);
        }
        
        $_SESSION['reset_message'] = 'Your password has been reset successfully. You can now login with your new password.';
        $_SESSION['reset_message_class'] = 'success';
        header("Location: registration.php?block=sign-in");
        exit();
        
    } catch (Exception $e) {
        $_SESSION['reset_message'] = $e->getMessage();
        $_SESSION['reset_message_class'] = 'error';
        header("Location: registration.php?block=reset-password&token=" . urlencode($token));
        exit();
    }
}

header("Location: registration.php?block=forgot-password");
exit();
?>