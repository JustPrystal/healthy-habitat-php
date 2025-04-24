<?php
session_start();
include('db.php');
require_once('utils/helpers.php');

include('./Blocks/registration/is_logged_in.php');

require_once("./helpers.php");
// Fetch locations
$locations = [];
$locationSql = "SELECT id, name FROM locations";
$locationResult = $conn->query($locationSql);
if ($locationResult && $locationResult->num_rows > 0) {
  while ($row = $locationResult->fetch_assoc()) {
    $locations[] = $row;
  }
}

// Fetch categories
$categories = [];
$categorySql = "SELECT id, category FROM categories";
$categoryResult = $conn->query($categorySql);
if ($categoryResult && $categoryResult->num_rows > 0) {
  while ($row = $categoryResult->fetch_assoc()) {
    $categories[] = $row;
  }
}



// Initialize error array
$errors = [
    'first-name' => '',
    'last-name' => '',
    'email' => '',
    'password' => '',
    'location' => '',
    'age-group' => '',
    'gender' => '',
    'areas-of-interest' => '',
    'check' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_GET['user'];
    $valid = true;

    // Validate each field
    $firstName = trim($_POST['first-name'] ?? '');
    if (empty($firstName)) {
        $errors['first-name'] = 'First name is required';
        $valid = false;
    }

    $lastName = trim($_POST['last-name'] ?? '');
    if (empty($lastName)) {
        $errors['last-name'] = 'Last name is required';
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
        // Check if email already exists in database
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

    $location = $_POST['location'] ?? '';
    if (empty($location)) {
        $errors['location'] = 'Location is required';
        $valid = false;
    }

    $ageGroup = $_POST['age-group'] ?? '';
    if (empty($ageGroup)) {
        $errors['age-group'] = 'Age group is required';
        $valid = false;
    }

    $gender = $_POST['gender'] ?? '';
    if (empty($gender)) {
        $errors['gender'] = 'Gender is required';
        $valid = false;
    }

    $areasOfInterest = $_POST['areas-of-interest'] ?? '';
    if (empty($areasOfInterest)) {
        $errors['areas-of-interest'] = 'Areas of interest are required';
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
        $firstName = $_POST['first-name'] ?? '';
        $lastName = $_POST['last-name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // 2. Combine names for the 'users' table
        $fullName = trim($firstName . ' ' . $lastName);

        // 3. Get meta data
        $meta = [
            'location' => $_POST['location'] ?? '',
            'age_group' => $_POST['age-group'] ?? '',
            'gender' => $_POST['gender'] ?? '',
            'areas_of_interest' => $_POST['areas-of-interest'] ?? ''
        ];

        // 4. Create user in DB
        $user_id = createUser($conn, $fullName, $email, $password, $role);

        // 5. Insert meta data
        insertUserMeta($conn, $user_id, $meta);

        // 6. Redirect or show success message
        echo "
        <script>alert('" . $role . " registered successfully!');
          window.location.href = '" . get_project_root_url() . "registration.php?block=sign-in';
        </script>";
    }
}
?>

<!-- The rest of your HTML form remains the same as in the previous answer -->
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
<<<<<<< HEAD
          <?php if (!$is_logged_in): ?>
            <form method="POST" action="registration.php?block=resident-form&user=resident">
              <div class="input-wrap half">
                <label for="name">First Name </label>
                <input type="text" id="first-name" name="first-name" required>
              </div>
              <div class="input-wrap half">
                <label for="name">Last Name </label>
                <input type="text" id="last-name" name="last-name" required>
              </div>
              <div class="input-wrap half">
                <label for="location">Location</label>
                <select name="location" id="location" required>
                  <option value="" disabled selected></option>
                  <?php foreach ($locations as $location): ?>
                    <option value="<?= htmlspecialchars($location['name']) ?>">
                      <?= htmlspecialchars($location['name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="input-wrap half">
                <label for="location">age group</label>
                <select name="age-group" id="age-group" required>
                <option value="under-18">Under 18</option>
                <option value="18-24">18 - 24</option>
                <option value="25-34">25 - 34</option>
                <option value="35-44">35 - 44</option>
                <option value="45-54">45 - 54</option>
                <option value="55-64">55 - 64</option>
                <option value="65-plus">65+</option>
                <option value="not-given">Prefer not to say</option>
                </select>
              </div>
              <div class="input-wrap half">
                <label for="gender">gender</label>
                <select name="gender" id="gender" required>
                  <option value="" disabled selected></option>
                  <option value="male">Male</option>
                  <option value="female">female</option>
                  <option value="not-given">Prefer not to say</option>
                </select>
              </div>
              <div class="input-wrap half">
                <label for="areas-of-interest">Areas of Interest</label>
                <select name="areas-of-interest" id="areas-of-interest" required>
                  <option value="" disabled selected></option>
                  <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['category']) ?>">
                      <?= htmlspecialchars($category['category']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
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
=======
          <form method="POST" action="registration.php?block=resident-form&user=resident">
            <div class="input-wrap half">
              <label for="name">First Name </label>
              <input type="text" id="first-name" name="first-name" value="<?php echo htmlspecialchars($_POST['first-name'] ?? ''); ?>" >
              <span class="error-message"><?php echo $errors['first-name']; ?></span>
            </div>
            <div class="input-wrap half">
              <label for="name">Last Name </label>
              <input type="text" id="last-name" name="last-name" value="<?php echo htmlspecialchars($_POST['last-name'] ?? ''); ?>" >
              <span class="error-message"><?php echo $errors['last-name']; ?></span>
            </div>
            <div class="input-wrap half">
              <label for="location">Location</label>
              <select name="location" id="location">
                <option value="" disabled selected></option>
                <?php foreach ($locations as $location): ?>
                  <option value="<?= htmlspecialchars($location['name']) ?>">
                    <?= htmlspecialchars($location['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="error-message"><?php echo $errors['location']; ?></span>
            </div>
            <div class="input-wrap half">
              <label for="location">age group</label>
              <select name="age-group" id="age-group" required>
              <option value="under-18">Under 18</option>
              <option value="18-24">18 - 24</option>
              <option value="25-34">25 - 34</option>
              <option value="35-44">35 - 44</option>
              <option value="45-54">45 - 54</option>
              <option value="55-64">55 - 64</option>
              <option value="65-plus">65+</option>
              <option value="not-given">Prefer not to say</option>
              </select>
              <span class="error-message"><?php echo $errors['age-group']; ?></span>
            </div>
            <div class="input-wrap half">
              <label for="gender">gender</label>
              <select name="gender" id="gender">
                <option value="" disabled selected></option>
                <option value="male">Male</option>
                <option value="female">female</option>
                <option value="not-given">Prefer not to say</option>
              </select>
              <span class="error-message"><?php echo $errors['gender']; ?></span>
            </div>
            <div class="input-wrap half">
              <label for="areas-of-interest">Areas of Interest</label>
              <select name="areas-of-interest" id="areas-of-interest">
                <option value="" disabled selected></option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= htmlspecialchars($category['category']) ?>">
                    <?= htmlspecialchars($category['category']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="error-message"><?php echo $errors['areas-of-interest']; ?></span>
            </div>

            <div class="input-wrap">
              <label for="email">email</label>
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
              <span class="error-message"><?php echo $errors['email']; ?></span>
            </div>
            <div class="input-wrap password">
              <label for="password">password</label>
              <div class="password-wrap">
                <input type="password" id="password" name="password" >
                <span id="togglePassword">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="#134027" d="M12 9.005a4 4 0 1 1 0 8a4 4 0 0 1 0-8M12 5.5c4.613 0 8.596 3.15 9.701 7.564a.75.75 0 1 1-1.455.365a8.504 8.504 0 0 0-16.493.004a.75.75 0 0 1-1.456-.363A10 10 0 0 1 12 5.5" />
                  </svg>
                </span>
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
>>>>>>> origin/main
        </div>
      </div>
    </div>
  </div>
</section>