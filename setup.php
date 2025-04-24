<!-- 
$drop_table_sql = "DROP TABLE IF EXISTS table_name";
if (!$conn->query($drop_table_sql)) {
    die("❌ Failed to drop 'table_name' table: " . $conn->error);
}
echo "🗑️ Table 'table_name' dropped (if existed).<br>"; -->

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


// Product table
$product_sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,   
    name VARCHAR(255) NOT NULL,
    type ENUM('product', 'service') NOT NULL,
    category VARCHAR(100),
    price DECIMAL(10,2),
    description TEXT,
    benefits TEXT,
    image_path VARCHAR(255),
    stock INT DEFAULT 0,
    upvotes INT DEFAULT 0,
    downvotes INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";
if (!$conn->query($product_sql)) {
    die("Products table creation failed: " . $conn->error);
}
echo "✅ Table 'products' created!<br>";


// Services table
$service_sql = "CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,   
    name VARCHAR(255) NOT NULL,
    type ENUM('product', 'service') NOT NULL,
    category VARCHAR(100),
    price DECIMAL(10,2),
    description TEXT,
    benefits TEXT,
    image_path VARCHAR(255),
    stock INT DEFAULT 0,
    upvotes INT DEFAULT 0,
    downvotes INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";
if (!$conn->query($service_sql)) {
    die("Services table creation failed: " . $conn->error);
}
echo "✅ Table 'services' created!<br>";

// Local Councils table 

$locations_sql = "CREATE TABLE IF NOT EXISTS locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    postal_code VARCHAR(50) NOT NULL,
    region VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($locations_sql)) {
    die("locations table creation failed: " . $conn->error);
}
echo "✅ Table 'locations' created!<br>";

$categories_sql = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('product', 'service') NOT NULL,
    category VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($categories_sql)) {
    die("categories table creation failed: " . $conn->error);
}
echo "✅ Table 'Categories' created!<br>";

// Certifications table
$certifications_sql = "CREATE TABLE IF NOT EXISTS certifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    issuer VARCHAR(255) NOT NULL,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if (!$conn->query($certifications_sql)) {
    die("Certifications table creation failed: " . $conn->error);
}
echo "✅ Table 'certifications' created!<br>";


// Done!
echo "<br>🎉 Setup complete! You're ready to roll.";
$conn->close();
?>