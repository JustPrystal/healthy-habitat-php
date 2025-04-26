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
    status ENUM('pending', 'live') DEFAULT 'pending',
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
    status ENUM('pending', 'live') DEFAULT 'pending',
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
    location_type VARCHAR(100) NOT NULL,
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


// Insert mock users
$pass1 = password_hash('resident123', PASSWORD_DEFAULT);
$pass2 = password_hash('council123', PASSWORD_DEFAULT);
$pass3 = password_hash('business123', PASSWORD_DEFAULT);
$pass4 = password_hash('admin123', PASSWORD_DEFAULT);
$conn->query("INSERT INTO users (name, email, password, role) VALUES 
    ('Alice Johnson', 'alice@gmail.com', '$pass1', 'resident'),
    ('Camden Borough Council', 'council@gmail.com', '$pass2', 'council'),
    ('ZenGlow Yoga Studio', 'sme@gmail.com', '$pass3', 'business'),
    ('Admin Joe', 'admin@gmail.com', '$pass4', 'admin'),
    ('HerbalWhiff Co.', 'info@herbalwhiff.org', '$pass4', 'business')
");

// Insert mock user_meta
$conn->query("INSERT INTO user_meta (user_id, meta_key, meta_value) VALUES
    (1, 'location', 'North Valley'),
    (1, 'age_group', '25–34'),
    (1, 'areas_of_interest', 'Home Wellness'),
    (1, 'gender', 'female'),
    (2, 'contact_person_name', 'Sarah Thompson'),
    (2, 'phone_number', '123-456-7890'),
    (2, 'designation', 'Community Wellness Officer'),
    (2, 'region', 'Greater London'),
    (2, 'council_website', 'www.camden.gov.uk'),
    (3, 'phone', '07912345678'),
    (3, 'website', 'https://zenglow.co.uk'),
    (3, 'address', '12 Wellness Street, Northbridge'),
    (3, 'about', 'We help people reconnect mind and body through yoga and mindfulness.'),
    (5, 'phone', '07932167854'),
    (5, 'website', 'https://herbalWhiff.org.uk'),
    (5, 'address', '18 Willow Lane, Camden, London, NW1 7JD, UK'),
    (5, 'about', 'We help people reconnect mind and body through organic fumes.')
");


// Insert mock categories
$conn->query("INSERT INTO categories (user_id, type, category) VALUES 
    (4, 'product', 'Home Wellness'),
    (4, 'product', 'Eco-Friendly Fitness Gear'),
    (4, 'service', 'Organic Personal Care'),
    (4, 'service', 'Sustainable Living')
");


// Insert mock products
$conn->query("INSERT INTO products (user_id, name, type, category, price, description, benefits, image_path, status, stock) VALUES 
    (3, 'PureAir HEPA Filter Purifier', 'product', 'Home Wellness', 4, 'Hepa filter description', 'It is very Eco-friendly and durable', './assets/wellness services/PureAir HEPA Filter Purifiers.png', 'live', 50),
    (3, 'NatureMat Cork Yoga Mat', 'product', 'Eco-Friendly Fitness Gear', 10, 'This is a very good mat', 'It is very sustainable and stylish', './assets/wellness services/NatureMat Cork Yoga Mats.png', 'pending', 100),
    (5, 'AloeSheer Body Lotion', 'product', 'Home Wellness', 12, 'This is a very good lotion.', 'It is very sustainable and organic', './assets/wellness services/AloeSheer Body Lotion.png', 'live', 70)
");

// Insert mock services
$conn->query("INSERT INTO services (user_id, name, type, category, price, description, benefits, image_path, status, stock) VALUES 
    (3, 'ZenGlow Yoga Studio', 'service', 'Organic Personal Care', 75.00, 'This is a very good yoga studio', 'It is very sustainable and stylish', './assets/wellness services/ZenGlow Yoga Studio.png', 'live', 10),
    (3, 'EcoClean Home Services', 'service', 'Sustainable Living', 50.00, 'Seasonal home maintenance', 'Experienced cleaners, Tools included', './assets/wellness services/GreenNest Home Cleaning.png', 'pending', 5),
    (5, 'UrbanSprout Gardening Workshops', 'service', 'Sustainable Living', 20.00, 'Seasonal garden maintenance', 'Experienced gardeners, Tools included', './assets/wellness services/PlantPure Subscription.png', 'live', 10)
");
// Insert mock certifications
$conn->query("INSERT INTO certifications (user_id, title, issuer, image_path) VALUES 
    (3, 'Eco Vendor Certified', 'ZenGlow Yoga Studio', './assets/certifiedImage.png'),
    (3, 'Sustainable Service Badge', 'ZenGlow Yoga Studio', './assets/naturalImage.png'),
    (5, 'HerbalWhiff Co.', 'HerbalWhiff Co.', './assets/organic.png')
");

// Insert mock locations
$conn->query("INSERT INTO locations (user_id, name, postal_code, region, location_type, description) VALUES 
    (2, 'North Valley', '12345', 'bedfordshire', 'urban', 'Serving North Valley residents'),
    (2, 'Eastside District', '67890', 'berkshire', 'rural', 'Serving Eastside communities')
");

echo "✅ Mock data inserted successfully!";

$conn->close();
?>