<?php
include('db.php');
require_once('utils/helpers.php');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$is_logged_in = isset($_SESSION['user_id']);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $role = $_GET['user'];

  error_log("Asdasdasdasd");

  // 1. Get user data
  $councilName = $_POST['council-name'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  // 3. Get meta data
  $meta = [
    'contact_person_name' => $_POST['contact-person-name'] ?? '',
    'phone_number' => $_POST['phone-number'] ?? '',
    'region' => $_POST['region'] ?? '',
    'designation' => $_POST['designation'] ?? '',
    'council_website' => $_POST['council-website'] ?? ''
  ];

  // 4. Create user in DB
  $user_id = createUser($conn, $councilName, $email, $password, $role);

  // 5. Insert meta data
  insertUserMeta($conn, $user_id, $meta);

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

  // 6. Redirect or show success message
  echo "<script>
  alert('" . $role . " registered successfully!');
  </script>";
}
?>


<section class="registration-step-3 register-section">
  <div class="inner">
    <div class="content-wrap">
      <div class="heading-wrap">
        <svg xmlns="http://www.w3.org/2000/svg" width="179" height="80" viewBox="0 0 179 80" fill="none">
          <path
            d="M18.656 41.856V80H0.48V0.895996H18.656V38.912H37.984V0.895996H56.16V80H37.984V41.856H18.656ZM83.281 41.856V80H65.105V0.895996H83.281V38.912H102.609V0.895996H120.785V80H102.609V41.856H83.281ZM132.418 12.928V53.888C132.503 56.0213 133.314 58.0693 134.85 60.032C136.471 61.9093 138.221 63.872 140.098 65.92C141.975 67.968 143.682 70.144 145.218 72.448C146.754 74.6667 147.522 77.184 147.522 80H129.73V0.895996H145.474L175.938 67.2V26.88C175.853 24.7467 174.999 22.7413 173.378 20.864C171.842 18.9013 170.135 16.9387 168.258 14.976C166.381 12.928 164.674 10.7947 163.138 8.576C161.602 6.272 160.834 3.712 160.834 0.895996H178.626V80H163.394L132.418 12.928Z"
            fill="#FCFCF2" />
        </svg>
        <h2 class="heading">
          Welcome to Healthy Habitat Network.
        </h2>
      </div>
      <div class="form-wrap">
        <div class="form-container">
        <?php if (!$is_logged_in): ?>
          <form method="POST" action="registration.php?block=lc-form&user=council">
            <div class="input-wrap">
              <label for="council-name">Council Name </label>
              <input type="text" id="council-name" name="council-name" required>
            </div>
            <div class="input-wrap">
              <label for="contact-person-name">contact person name </label>
              <input type="text" id="contact-person-name" name="contact-person-name" required>
            </div>
            <div class="input-wrap half">
              <label for="phone-number">Phone Number </label>
              <input type="tel" id="phone-number" name="phone-number" required>
            </div>
            <div class="input-wrap half">
              <label for="region">region </label>
              <input type="text" id="region" name="region" required>
            </div>
            <div class="input-wrap half">
              <label for="designation">designation </label>
              <input type="text" id="designation" name="designation" required>
            </div>
            <div class="input-wrap half">
              <label for="council-website">council website </label>
              <input type="url" id="council-website" name="council-website" required>
            </div>
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
                    <path fill="#134027" d="M12 9.005a4 4 0 1 1 0 8a4 4 0 0 1 0-8M12 5.5c4.613 0 8.596 3.15 9.701 7.564a.75.75 0 1 1-1.455.365a8.504 8.504 0 0 0-16.493.004a.75.75 0 0 1-1.456-.363A10 10 0 0 1 12 5.5" />
                  </svg>
                </span>
              </div>
            </div>
            <div class="input-wrap checkbox">
              <input type="checkbox" id="check" name="check" required>
              <label for="check">Send me updates and offers.
                <span class="sub-text">
                  You can unsubscribe at any time.
                </span>
              </label>
            </div>
            <div class="input-wrap">
              <button type="submit">create account</button>
            </div>
            <div class="text-wrap">
              <span>Already have an account?</span>
              <a href="registration.php?block=sign-in">Sign in here</a>
            </div>
            <div class="t-and-c-wrap">
              <span>By continuing, you confirm that you agree to our Privacy Policy and <a href="#">Terms of
                  Service.</a></span>
            </div>
          </form>
          <?php else: ?>
            <!-- 🔒 Show this message if logged in -->
            <div class="already-logged-in">
              <p>You are already logged in.</p>

              <a href="./logout.php" class="log-out">Log out</a>
              <?php 
                $dashboard_url = '#'; // Default/fallback
                if (isset($_SESSION['user_role'])) {
                  switch ($_SESSION['user_role']) {
                    case 'council':
                      $dashboard_url = 'lc.php';
                      break;
                    case 'business':
                      $dashboard_url = 'sme.php';
                      break;
                    case 'admin':
                      $dashboard_url = 'admin.php';
                      break;
                    case 'resident':
                      $dashboard_url = 'index.php';
                      break;
                  }
                }
              ?>
              <a href="<?= $dashboard_url ?>" class="redirect"><?php if ($_SESSION['user_role'] === 'resident') {
                  echo 'Go to Site.';
                } else {
                  echo 'Go to dashboard';
                }?></a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>