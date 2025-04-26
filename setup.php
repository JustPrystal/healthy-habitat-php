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

// Add Mock Data

echo "<br>➕ Inserting mock users...<br>";

// 1. Residents
$residents = [
    ["Sarah Mitchell", "sarah.m@gmail.com", "Northbridge", "25–34", "Fitness, Nutrition"],
    ["James Iqbal", "james.iqbal92@live.co.uk", "Willow Heights", "35–44", "Sustainable Living, Mental Health"],
    ["Lina Chow", "lina.chow@email.com", "Riverdale", "18–24", "Personal Care, Mindfulness"],
    ["David Brooks", "d.brooks@hhnmail.org", "Greenfield", "45–54", "Fitness, Organic Products"],
    ["Ayesha Khan", "ayesha.khan@yahoo.com", "Meadowridge", "25–34", "Healthy Eating, Meditation"]
];

// Set a default password for all users
$defaultPassword = 'password123';

foreach ($residents as $r) {
    $name = $conn->real_escape_string($r[0]);
    $email = $conn->real_escape_string($r[1]);
    $area = $conn->real_escape_string($r[2]);
    $ageGroup = $conn->real_escape_string($r[3]);
    $interests = $conn->real_escape_string($r[4]);
    
    // Hash the password
    $hashed_password = password_hash($defaultPassword, PASSWORD_DEFAULT);

    // Insert into users table
    $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', 'resident')");

    // Get inserted user ID
    $user_id = $conn->insert_id;

    // Insert into user_meta (optional, assuming you have these fields)
    $conn->query("INSERT INTO user_meta (user_id, meta_key, meta_value) VALUES 
        ($user_id, 'location', '$area'),
        ($user_id, 'age_group', '$ageGroup'),
        ($user_id, 'areas_of_interest', '$interests')
    ");
}

echo "Residents inserted successfully.";

// 2. SMEs (Business)
$smes = [
    [
        "ZenGlow Yoga Studio", "07912345678", "https://zenglow.co.uk", "support@zenglow.co.uk",
        "12 Wellness Street, Northbridge", "We help people reconnect mind and body through yoga and mindfulness.",
        "password123"
    ],
    [
        "PureThread Organics", "02079461234", "https://purethread.co.uk", "hello@purethread.co.uk",
        "8 Organic Lane, Southbridge", "Eco-friendly clothing made with natural fibers and low-impact dyes.",
        "password123"
    ],
    [
        "BreatheWell Studio", "01612345678", "https://breathewellstudio.com", "admin@breathewellstudio.com",
        "3 Calm Road, Westfield", "Breathing-focused wellness classes and workshops.",
        "password123"
    ],
    [
        "EcoMaid Solutions", "01134567890", "https://ecomaid.co.uk", "team@ecomaid.co.uk",
        "44 Green Ave, Eastfield", "Eco-conscious cleaning solutions for homes and businesses.",
        "password123"
    ]
];

foreach ($smes as $sme) {
    [$business_name, $phone, $website, $email, $address, $about, $raw_password] = $sme;

    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    // Escape input
    $name = $conn->real_escape_string($business_name);
    $email = $conn->real_escape_string($email);
    $phone = $conn->real_escape_string($phone);
    $website = $conn->real_escape_string($website);
    $address = $conn->real_escape_string($address);
    $about = $conn->real_escape_string($about);

    // Insert user
    $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', 'business')");
    $user_id = $conn->insert_id;

    // Insert user_meta
    $conn->query("INSERT INTO user_meta (user_id, meta_key, meta_value) VALUES
        ($user_id, 'phone', '$phone'),
        ($user_id, 'website', '$website'),
        ($user_id, 'address', '$address'),
        ($user_id, 'about', '$about')
    ");
}

echo "SMEs inserted successfully.";

// 3. Councils
$councils = [
    ["Camden Borough Council", "Sarah Thompson", "07912345687", 5, "Greater London", "https://camden.gov.uk", "council1@demo.com", "password123"],
    ["Manchester City Council", "Abdul Karim", "02079461321", 3, "North West", "https://manchester.gov.uk", "council2@demo.com", "password123"],
    ["Luton Council", "Emily Carter", "01612345456", 2, "East of England", "https://luton.gov.uk", "council3@demo.com", "password123"],
    ["Leeds Local Council", "Rajesh Nair", "01134567890", 4, "Yorkshire", "https://leeds.gov.uk", "council4@demo.com", "password123"],
    ["Oxfordshire Council", "Hannah Reid", "01124667890", 6, "South East", "https://oxfordshire.gov.uk", "council5@demo.com", "password123"]
];

foreach ($councils as $council) {
    [$name, $contact_person, $phone, $designation, $region, $website, $email, $raw_password] = $council;

    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    // Escape inputs
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $phone = $conn->real_escape_string($phone);
    $website = $conn->real_escape_string($website);
    $region = $conn->real_escape_string($region);
    $designation = $conn->real_escape_string($designation);
    $contact_person = $conn->real_escape_string($contact_person);

    // Insert into users table
    $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', 'council')");
    $user_id = $conn->insert_id;

    // Insert meta
    $conn->query("INSERT INTO user_meta (user_id, meta_key, meta_value) VALUES
        ($user_id, 'contact_person', '$contact_person'),
        ($user_id, 'phone', '$phone'),
        ($user_id, 'designation', '$designation'),
        ($user_id, 'region', '$region'),
        ($user_id, 'website', '$website')
    ");
}

echo "Councils inserted successfully.";


// 4. Areas (locations)
$areas = [
    ["Northbridge", "Urban", "Greater London", "12400", "Camden Borough Council"],
    ["Meadowridge", "Rural", "South East", "8200", "Oxfordshire Council"],
    ["Willow Heights", "Rural", "Yorkshire", "3100", "Leeds Local Council"],
    ["Greenfield", "Urban", "North West", "9750", "Manchester City Council"],
    ["Riverdale", "Rural", "East Midlands", "6600", "Oxfordshire Council"],
    ["Birchwood Edge", "Rural", "East of England", "2400", "Luton Council"],
    ["Sunnydale", "Urban", "Greater London", "11050", "Camden Borough Council"]
];

foreach ($areas as $area) {
    [$name, $location_type, $region, $postal_code, $council_name] = $area;

    // Escape input
    $name = $conn->real_escape_string($name);
    $location_type = $conn->real_escape_string($location_type);
    $region = $conn->real_escape_string($region);
    $postal_code = $conn->real_escape_string($postal_code);
    $council_id = "NULL";

    if ($council_name) {
        $council_name = $conn->real_escape_string($council_name);
        $result = $conn->query("SELECT id FROM users WHERE name = '$council_name' AND role = 'council'");

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $council_id = (int) $row['id'];
        }
    }

    // Insert area
    $conn->query("
        INSERT INTO locations (name, location_type, region, postal_code, user_id)
        VALUES ('$name', '$location_type', '$region', '$postal_code', $council_id)
    ");
}

echo "Areas inserted successfully.";

// 5. Products & Services
$items = [
    ["PureAir HEPA Filter Purifier", "product", "Home Wellness", 65.00, "ZenGlow Yoga Studio", 412, 39, "live"],
    ["NatureMat Cork Yoga Mat", "product", "Eco-Friendly Fitness Gear", 32.00, "PureThread Organics", 306, 21, "live"],
    ["ZenGlow Yoga Classes", "service", "Fitness and Wellness", 35.00, "BreatheWell Studio", 388, 45, "live"],
    ["HerbalWhiff Toothpaste Tabs", "product", "Organic Personal Care", 6.00, "EcoMaid Solutions", 129, 12, "pending"],
    ["EcoClean Home Services", "service", "Sustainable Living", 50.00, "ZenGlow Yoga Studio", 143, 27, "pending"],
    ["AloeSheer Body Lotion", "product", "Organic Personal Care", 11.50, "BreatheWell Studio", 221, 19, "live"],
    ["UrbanSprout Gardening Workshops", "service", "Sustainable Living", 30.00, "PureThread Organics", 197, 10, "live"]
];

foreach ($items as $item) {
    [$name, $type, $category, $price, $user_name, $upvotes, $downvotes, $status] = $item;

    // Escape the user_name
    $user_name = $conn->real_escape_string($user_name);
    $user_id = null;

    // Lookup user_id from users table
    $result = $conn->query("SELECT id FROM users WHERE name = '$user_name'");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = (int) $row['id'];
    }

    // Skip insertion if user not found
    if (!$user_id) {
        echo "❌ User not found: $user_name<br>";
        continue;
    }

    // Other mock fields
    $description = "Description for $name";
    $benefits = "Benefits of $name";
    $image_path = "images/$name.jpg"; // sanitize if needed
    $status_stock = $status;

    // Prepare SQL
    if ($type === 'product') {
        $stmt = $conn->prepare("INSERT INTO products (name, type, category, price, description, benefits, image_path, status, upvotes, downvotes, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    } else {
        $stmt = $conn->prepare("INSERT INTO services (name, type, category, price, description, benefits, image_path, status, upvotes, downvotes, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    }

    // Bind and execute
    $stmt->bind_param("sssdssssiii", $name, $type, $category, $price, $description, $benefits, $image_path, $status_stock, $upvotes, $downvotes, $user_id);
    $stmt->execute();
}

echo "✅ Products & services inserted successfully.<br>";




// Done!
echo "<br>🎉 Setup complete! You're ready to roll.";
$conn->close();
?>