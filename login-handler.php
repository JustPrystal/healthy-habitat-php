
<?php
session_start();

require_once('./db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            //Redirect based on role
            switch ($user['role']) {
                case 'council':
                    header("Location: lc.php");
                    break;
                case 'business':
                    header("Location: sme.php");
                    break;
                case 'admin':
                    header("Location: admin.php");
                    break;
                case 'resident':
                    header("Location: index.php");
                    break;
            }
            exit();
        } else {
            $_SESSION['login_error'] = "Incorrect password.";
        }
    } else {
        $_SESSION['login_error'] = "User not found.";
    }

    $stmt->close();
    $conn->close();

    header("Location: registration.php?block=sign-in");
    exit();
}
?>
