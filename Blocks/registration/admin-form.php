<?php
include('db.php');
require_once('utils/helpers.php');

// Initialize error array
$errors = [
    'name' => '',
    'email' => '',
    'password' => '',
    'check' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_GET['user'];
    $valid = true;

    // Validate each field
    $fullName = trim($_POST['name'] ?? '');
    if (empty($fullName)) {
        $errors['name'] = 'Name is required';
        $valid = false;
    }

    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $errors['email'] = 'Email is required';
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
        $valid = false;
    } else {
        // Check if email already exists in the database
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors['email'] = 'This email is already registered';
            $valid = false;
        }
        $stmt->close();
    }

    $password = $_POST['password'] ?? '';
    if (empty($password)) {
        $errors['password'] = 'Password is required';
        $valid = false;
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
        $valid = false;
    }

    $check = $_POST['check'] ?? '';
    if (empty($check)) {
        $errors['check'] = 'You must agree to receive updates';
        $valid = false;
    }

    // If all validation passed
    if ($valid) {
        // 1. Get user data
        $fullName = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // 2. Create user in DB
        $user_id = createUser($conn, $fullName, $email, $password, $role);

        // 3. Insert meta data (if needed)
        // insertUserMeta($conn, $user_id, $meta);

        // 4. Redirect or show success message
        echo "<script>
        alert('" . $role . " registered successfully!');
        </script>";
    }
}
?>



<section class="registration-step-3 register-section">
  <div class="inner">
    <div class="content-wrap">
      <div class="heading-wrap">
        <!-- SVG and heading here -->
      </div>
      <div class="form-wrap">
        <div class="form-container">
          <form method="POST" action="registration.php?block=admin-form&user=admin">
            <div class="input-wrap">
              <label for="name">Name </label>
              <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" >
              <span class="error-message"><?php echo $errors['name']; ?></span>
            </div>

            <div class="input-wrap">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" >
              <span class="error-message"><?php echo $errors['email']; ?></span>
            </div>

            <div class="input-wrap password">
              <label for="password">Password</label>
              <div class="password-wrap">
                <input type="password" id="password" name="password" >
              </div>
              <span class="error-message"><?php echo $errors['password']; ?></span>
            </div>

            <div class="input-wrap checkbox">
              <div class="wrap-checkbox">
                <input type="checkbox" id="check" name="check" <?php echo isset($_POST['check']) ? 'checked' : ''; ?> >
                <label for="check">Send me updates and offers.
                  <span class="sub-text">
                    You can unsubscribe at any time.
                  </span>
                </label>
              </div>
              <span class="error-message"><?php echo $errors['check']; ?></span>
            </div>

            <div class="input-wrap">
              <button type="submit">Create Account</button>
            </div>

            <div class="text-wrap">
              <span>Already have an account?</span>
              <a href="registration.php?block=sign-in">Sign in here</a>
            </div>

            <div class="t-and-c-wrap">
              <span>By continuing, you confirm that you agree to our Privacy Policy and <a href="#">Terms of Service.</a></span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
