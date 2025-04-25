<?php
session_start();

include('./Blocks/registration/is_logged_in.php');

include('./Blocks/registration/is_logged_in.php');
include('db.php');
require_once('utils/helpers.php');

require_once("./helpers.php");

// Initialize errors
$errors = [
    'council-name' => '',
    'contact-person-name' => '',
    'phone-number' => '',
    'region' => '',
    'designation' => '',
    'council-website' => '',
    'email' => '',
    'password' => '',
    'check' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_GET['user'];
    $valid = true;

    // Council Name
    $councilName = trim($_POST['council-name'] ?? '');
    if (empty($councilName)) {
        $errors['council-name'] = 'Council name is required';
        $valid = false;
    }

    // Contact Person Name
    $contactPerson = trim($_POST['contact-person-name'] ?? '');
    if (empty($contactPerson)) {
        $errors['contact-person-name'] = 'Contact person name is required';
        $valid = false;
    }

    // Phone Number
    $phoneNumber = trim($_POST['phone-number'] ?? '');
    if (empty($phoneNumber)) {
        $errors['phone-number'] = 'Phone number is required';
        $valid = false;
    }

    // Region
    $region = trim($_POST['region'] ?? '');
    if (empty($region)) {
        $errors['region'] = 'Region is required';
        $valid = false;
    }

    // Designation (optional)
    $designation = trim($_POST['designation'] ?? '');

    // Council Website (optional but must be valid if entered)
    $councilWebsite = trim($_POST['council-website'] ?? '');
    if (!empty($councilWebsite) && !filter_var($councilWebsite, FILTER_VALIDATE_URL)) {
        $errors['council-website'] = 'Please enter a valid URL';
        $valid = false;
    }

    // Email
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $errors['email'] = 'Email is required';
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
        $valid = false;
    } else {
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

    // Password
    $password = $_POST['password'] ?? '';
    if (empty($password)) {
        $errors['password'] = 'Password is required';
        $valid = false;
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
        $valid = false;
    }

    // Checkbox
    $check = $_POST['check'] ?? '';
    if (empty($check)) {
        $errors['check'] = 'You must agree to receive updates';
        $valid = false;
    }

    // If valid, insert user
    if ($valid) {
        $meta = [
            'contact_person_name' => $contactPerson,
            'phone_number' => $phoneNumber,
            'region' => $region,
            'designation' => $designation,
            'council_website' => $councilWebsite
        ];

        $user_id = createUser($conn, $councilName, $email, $password, $role);
        insertUserMeta($conn, $user_id, $meta);

        echo "
        <script>alert('" . $role . " registered successfully!');
          window.location.href = '" . get_project_root_url() . "registration.php?block=sign-in';
        </script>";
    }
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
        <form method="POST" action="registration.php?block=lc-form&user=council">
  <div class="input-wrap">
    <label for="council-name">Council Name</label>
    <input type="text" id="council-name" name="council-name" value="<?php echo htmlspecialchars($_POST['council-name'] ?? ''); ?>" >
    <span class="error-message"><?php echo $errors['council-name'] ?? ''; ?></span>
  </div>

  <div class="input-wrap">
    <label for="contact-person-name">Contact Person Name</label>
    <input type="text" id="contact-person-name" name="contact-person-name" value="<?php echo htmlspecialchars($_POST['contact-person-name'] ?? ''); ?>" >
    <span class="error-message"><?php echo $errors['contact-person-name'] ?? ''; ?></span>
  </div>

  <div class="input-wrap half">
    <label for="phone-number">Phone Number</label>
    <input type="tel" id="phone-number" name="phone-number" value="<?php echo htmlspecialchars($_POST['phone-number'] ?? ''); ?>" >
    <span class="error-message"><?php echo $errors['phone-number'] ?? ''; ?></span>
  </div>

  <div class="input-wrap half">
    <label for="region">Region</label>
    <input type="text" id="region" name="region" value="<?php echo htmlspecialchars($_POST['region'] ?? ''); ?>" >
    <span class="error-message"><?php echo $errors['region'] ?? ''; ?></span>
  </div>

  <div class="input-wrap half">
    <label for="designation">Designation</label>
    <input type="text" id="designation" name="designation" value="<?php echo htmlspecialchars($_POST['designation'] ?? ''); ?>">
    <span class="error-message"><?php echo $errors['designation'] ?? ''; ?></span>
  </div>

  <div class="input-wrap half">
    <label for="council-website">Council Website</label>
    <input type="url" id="council-website" name="council-website" value="<?php echo htmlspecialchars($_POST['council-website'] ?? ''); ?>">
    <span class="error-message"><?php echo $errors['council-website'] ?? ''; ?></span>
  </div>

  <div class="input-wrap">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" >
    <span class="error-message"><?php echo $errors['email'] ?? ''; ?></span>
  </div>

  <div class="input-wrap password">
    <label for="password">Password</label>
    <div class="password-wrap">
      <input type="password" id="password" name="password" >
      <span id="togglePassword">
        <!-- Eye icon SVG -->
        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
          <path fill="#134027" d="M12 9.005a4 4 0 1 1 0 8a4 4 0 0 1 0-8M12 5.5c4.613 0 8.596 3.15 9.701 7.564a.75.75 0 1 1-1.455.365a8.504 8.504 0 0 0-16.493.004a.75.75 0 0 1-1.456-.363A10 10 0 0 1 12 5.5" />
        </svg> -->
      </span>
    </div>
    <span class="error-message"><?php echo $errors['password'] ?? ''; ?></span>
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
    <span>By continuing, you confirm that you agree to our <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a>.</span>
  </div>
</form>


        </div>
      </div>
    </div>
  </div>
</section>