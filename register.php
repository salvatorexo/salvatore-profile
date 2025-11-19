echo "Connecting to database: $dbname<br>";

<?php
// Database connection details
$servername = "localhost";
$username = "root";       // default XAMPP username
$password = "";           // default XAMPP password is blank
$dbname = "registration"; // ✅ matches your phpMyAdmin database name
// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data safely
$fullname = $_POST['fullname'] ?? '';
$age = $_POST['age'] ?? '';
$nationality = $_POST['nationality'] ?? '';
$id_number = $_POST['id_number'] ?? '';
$password = $_POST['password'] ?? '';

// Hash the password before storing (for security)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into the database using prepared statements (to prevent SQL injection)
$stmt = $conn->prepare("INSERT INTO users (fullname, age, nationality, id_number, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sisss", $fullname, $age, $nationality, $id_number, $hashed_password);

if ($stmt->execute()) {
    echo "<h3>Registration Successful!</h3>";
    echo "<a href='Login.html'>Click here to log in</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
