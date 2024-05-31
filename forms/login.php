<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from form submission
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Connect to the database (replace these credentials with your actual database connection details)
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = 'password';
    $db_name = 'miles_builders';

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check for database connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to fetch user credentials from the database
    $stmt = $conn->prepare("SELECT username, password FROM registration WHERE username = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if user exists and verify password
    if ($user && password_verify($input_password, $user['password'])) {
        // Authentication successful, set session variable
        $_SESSION['username'] = $input_username;

        // Redirect to homepage after successful login
        header("Location: http://localhost/xampp-miles/index.html");
        exit();
    } else {
        // Authentication failed, set error message
        $_SESSION['error'] = "Invalid username or password";
    }

    // Close database connection
    $stmt->close();
    $conn->close();
}

// Redirect back to login page if form is not submitted or authentication fails
header("Location: http://localhost/xampp-miles/account.html");
exit();
?>