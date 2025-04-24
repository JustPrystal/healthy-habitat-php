<?php
require_once 'db.php';

$user_id = $_SESSION['user_id'] ; // or get this from session: $_SESSION['user_id']

$stmt = $conn->prepare("SELECT meta_key, meta_value FROM user_meta WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$userMeta = [];
while ($row = $result->fetch_assoc()) {
    $userMeta[$row['meta_key']] = $row['meta_value'];
}

$stmt2 = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$user = [];
while ($row = $result2->fetch_assoc()) {
    $user[] = $row;
}


$conn->close();
?>


<div class="dashboard-content local-council">
    <div class="inner">
        <h2 class="content-main-heading">
            Admin Profile Settings
        </h2>
        <div class="lc-details-container">
            <div class="council-name field-value-wrap">
                <p class="field-name">Admin Name:</p>
                <p class="field-value"><?php echo $user[0]['name']; ?></p>
            </div>
            <div class="email field-value-wrap">
                <p class="field-name">Email:</p>
                <p class="field-value"><?php echo $user[0]['email']; ?></p>
            </div>
            <div class="password field-value-wrap">
                <p class="field-name">Password Change:</p>

                <form action="">
                    <div class="field-value name">
                        <input class="password-field" type="text" id="password" name="password" required>
                        <label class="password-label" for="name">Use 8 or more characters with a mix of letters,
                            numbers and symbols. Must not contain your name or username.</label>
                        <div class="btn-wrap">
                            <button type="submit">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>