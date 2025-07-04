<?php
// Include your database connection file
// This file should establish a $conn variable for your mysqli connection
require 'connect.php';

$message = ''; // To store success or error messages

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve form data
    $user_email = trim($_POST['user_email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');

    // --- Basic Input Validation ---
    if (empty($user_name) || empty($user_email) || empty($password) || empty($confirm_password)) {
        $message = '<p class="error">All fields are required!</p>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = '<p class="error">Invalid email format.</p>';
    } elseif (strlen($password) < 8) {
        $message = '<p class="error">Password must be at least 8 characters long.</p>';
    } elseif ($password !== $confirm_password) {
        $message = '<p class="error">Passwords do not match.</p>';
    } else {
        // --- Check if username or email already exists ---
        // Prepare a statement to check for existing username or email
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        if ($check_stmt === false) {
            $message = '<p class="error">Database error: Could not prepare check statement.</p>';
        } else {
            $check_stmt->bind_param("ss", $user_email);
            $check_stmt->execute();
            $check_stmt->store_result(); // Store result to check number of rows

            if ($check_stmt->num_rows > 0) {
                $message = '<p class="error">Username or Email already exists. Please choose another.</p>';
            } else {
                // --- Hash the password ---
                // ALWAYS hash passwords before storing them in the database!
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // --- Insert new user into the database ---
                $insert_stmt = $conn->prepare("INSERT INTO users (username, email, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
                if ($insert_stmt === false) {
                    $message = '<p class="error">Database error: Could not prepare insert statement.</p>';
                } else {
                    $insert_stmt->bind_param("sssss", $user_email, $hashed_password, $first_name, $last_name);

                    if ($insert_stmt->execute()) {
                        $message = '<p class="success">Registration successful! You can now <a href="login.php">log in</a>.</p>';
                        // Optionally, redirect to login page after successful registration
                        // header("Location: login.php?signup=success");
                        // exit();
                    } else {
                        $message = '<p class="error">Error registering user: ' . $insert_stmt->error . '</p>';
                    }
                    $insert_stmt->close();
                }
            }
            $check_stmt->close();
        }
    }
}
?>

