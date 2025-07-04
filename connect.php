<?php
// connect.php
// Pro-level DB connection script

// Database credentials
$host = 'localhost';
$username = 'root';
$password = ''; // Default XAMPP password is empty
$database = 'IS1ProjectDbase'; // <-- Replace this with your DB name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Optional: Uncomment this for debugging
// echo "Connected successfully";
?>
