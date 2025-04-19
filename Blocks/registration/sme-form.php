<?php
include('db.php');
require_once('utils/helpers.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $role = $_GET['user'];

  error_log("Asdasdasdasd");

  // 1. Get user data
  $businessName = $_POST['business-name'] ?? '';
//   $lastName = $_POST['last-name'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';


  // 3. Get meta data
  $meta = [
    'phone' => $_POST['phone-number'] ?? '',
    'website' => $_POST['website'] ?? '',
    'address' => $_POST['address'] ?? '',
    'about' => $_POST['about'] ?? '',
  ];

  // 4. Create user in DB
  $user_id = createUser($conn, $businessName, $email, $password, $role);

  // 5. Insert meta data
  insertUserMeta($conn, $user_id, $meta);

  // 6. Redirect or show success message
  echo "<script>
  alert('" . $role . " registered successfully!');
  </script>";
}
?>


<section class="sme-step-3 register-section">
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
          <form method="POST" action="registration.php?block=sme-form&user=business">
            <div class="input-wrap">
              <label for="business-name">business Name </label>
              <input type="text" id="business-name" name="business-name" required>
            </div>
            <div class="input-wrap half">
              <label for="phone-number">Phone Number </label>
              <input type="text" id="phone-number" name="phone-number" required>
            </div>
            <div class="input-wrap half">
                <label for="website">website</label>
                <input type="text" name="website" id="website" >
            </div>
            <div class="input-wrap">
              <label for="email">email</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div class="input-wrap">
              <label for="address">address</label>
              <input type="text" id="address" name="address">
            </div>
            <div class="input-wrap">
              <label for="about">about</label>
              <textarea placeholder="Tell us about your business" type="text" id="about" name="about" rows="5"></textarea>
            </div>
            <div class="input-wrap">
              <label for="password">password</label>
              <input type="password" id="password" name="password" required>
              <span class="sub-text">
                Use 8 or more characters with a mix of letters, numbers and symbols. Must not contain your name or
                username.
              </span>
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
        </div>
      </div>
    </div>
  </div>
</section>