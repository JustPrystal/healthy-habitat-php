<?php
include('db.php');
require_once('utils/helpers.php');

require_once("./helpers.php");

// Initialize errors
$errors = [
    'business-name' => '',
    'phone-number' => '',
    'email' => '',
    'password' => '',
    'check' => '',
    'website' => '',
    'about' => '',
    'address' => '' 
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_GET['user'];
    $valid = true;

    // Business Name
    $businessName = trim($_POST['business-name'] ?? '');
    if (empty($businessName)) {
        $errors['business-name'] = 'Business name is required';
        $valid = false;
    }

    // Phone Number
    $phoneNumber = trim($_POST['phone-number'] ?? '');
    if (empty($phoneNumber)) {
        $errors['phone-number'] = 'Phone number is required';
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
        // Check if email exists
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

     // Website (optional, but must be valid if entered)
     $website = trim($_POST['website'] ?? '');
     if (!empty($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
         $errors['website'] = 'Please enter a valid website URL';
         $valid = false;
     }
 
    // Address
    $address = trim($_POST['address'] ?? '');
    if (empty($address)) {
        $errors['address'] = 'Address is required';
        $valid = false;
    }

     // About (optional, but min 10 characters if filled)
     $about = trim($_POST['about'] ?? '');
     if (!empty($about) && strlen($about) < 10) {
         $errors['about'] = 'Tell us more about your business (min 10 characters)';
         $valid = false;
     }

    // Checkbox
    $check = $_POST['check'] ?? '';
    if (empty($check)) {
        $errors['check'] = 'You must agree to receive updates';
        $valid = false;
    }

    // If all fields are valid, register user
    if ($valid) {
        $meta = [
            'phone' => $phoneNumber,
            'website' => $website,
            'address' => $address,
            'about' => $about
        ];

        $user_id = createUser($conn, $businessName, $email, $password, $role);
        insertUserMeta($conn, $user_id, $meta);

        echo "
        <script>alert('" . $role . " registered successfully!');
          window.location.href = '" . get_project_root_url() . "registration.php?block=sign-in';
        </script>";
    }
}
?>


<section class="sme-step-3 register-section">
  <div class="inner">
    <div class="content-wrap">
      <div class="heading-wrap">
        <!-- SVG and heading here -->
      </div>
      <div class="form-wrap">
        <div class="form-container">
        <form method="POST" action="registration.php?block=sme-form&user=business">
  <div class="input-wrap">
    <label for="business-name">Business Name</label>
    <input type="text" id="business-name" name="business-name" value="<?php echo htmlspecialchars($_POST['business-name'] ?? ''); ?>">
    <span class="error-message"><?php echo $errors['business-name']; ?></span>
  </div>

  <div class="input-wrap half">
    <label for="phone-number">Phone Number</label>
    <input type="text" id="phone-number" name="phone-number" value="<?php echo htmlspecialchars($_POST['phone-number'] ?? ''); ?>">
    <span class="error-message"><?php echo $errors['phone-number']; ?></span>
  </div>

  <div class="input-wrap half">
    <label for="website">Website</label>
    <input type="text" name="website" id="website" value="<?php echo htmlspecialchars($_POST['website'] ?? ''); ?>">
    <span class="error-message"><?php echo $errors['website']; ?></span>
  </div>

  <div class="input-wrap">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
    <span class="error-message"><?php echo $errors['email']; ?></span>
  </div>

  <div class="input-wrap">
  <label for="address">Address</label>
  <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($_POST['address'] ?? ''); ?>">
  <span class="error-message"><?php echo $errors['address']; ?></span>
</div>

  <div class="input-wrap">
    <label for="about">About</label>
    <textarea id="about" name="about" rows="5"><?php echo htmlspecialchars($_POST['about'] ?? ''); ?></textarea>
    <span class="error-message"><?php echo $errors['about']; ?></span>
  </div>

  <div class="input-wrap password">
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
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

</form>

        </div>
      </div>
    </div>
  </div>
</section>
