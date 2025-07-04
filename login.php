<?php
session_start();
require 'connect.php'; // This should establish the $conn mysqli connection

if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
    // Get user input from the form
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
}
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "Please submit the form.";
    exit;
}
 // Use the $conn variable (your mysqli connection)
// and mysqli's prepare() method
$stmt = $conn->prepare("SELECT * FROM users WHERE user_email = ?");
$stmt->execute([$user_email]);
$user = $stmt->fetch();
if (!$user) {
    echo "User not found.";
    exit;
}

//Check if the prepare statement was successful 
 if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

// Bind parameters
$stmt->bind_param("s", $username); // "s" indicates the type is string
// Execute the statement
$stmt->execute();
// Fetch the result
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // Use fetch_assoc() to get an associative array
// Close the statement
$stmt->close();
  // ... rest of your login logic
    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php"); // Redirect to a dashboard or home page
        exit();
    } else {
        // Login failed
        $error_message = "Invalid username or password.";
    }

// Close the database connection
$conn->close();
?>
