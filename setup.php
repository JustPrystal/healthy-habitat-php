<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "healthy_habitat";

// Connect to MySQL (no DB selected yet)
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create DB if not exists
$sql = "CREATE DATABASE IF NOT EXISTS `$database`";
if (!$conn->query($sql)) {
    die("Database creation failed: " . $conn->error);
}
echo "✅ Database '$database' ready!<br>";

// Select the DB
$conn->select_db($database);

// Create `users` table
$sql_users = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('resident', 'council', 'business', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($sql_users)) {
    die("Users table creation failed: " . $conn->error);
}
echo "✅ Table 'users' is good to go!<br>";

// Create `user_meta` table
$sql_meta = "
CREATE TABLE IF NOT EXISTS user_meta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    meta_key VARCHAR(100) NOT NULL,
    meta_value TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";
if (!$conn->query($sql_meta)) {
    die("User meta table creation failed: " . $conn->error);
}
echo "✅ Table 'user_meta' is ready for action!<br>";

// Done!
echo "<br>🎉 Setup complete! You're ready to roll.";
$conn->close();
?>
