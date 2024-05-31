<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match";
        header("Location: index.html");
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $hashedConfirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);


    // Save user data to a database 
    $dbconnect = mysqli_connect('localhost', 'root', 'password', 'miles_builders');

    if($dbconnect) {
        // echo "DB connected successfully";

        $sql = "INSERT INTO `registration` (`firstname`, `lastname`, `username`, `email`, `password`, `confirm-password`) 
                VALUES ('$firstName', '$lastName', '$username', '$email', '$hashedPassword', '$hashedConfirmPassword')";
        
        $dataInsert = mysqli_query($dbconnect, $sql);

        if ($dataInsert) {
            echo "Data inserted to DB Successfully";
        } else {
            die("Data insertion failed: " . mysqli_error($dbconnect));
        }

    } else {
        die("Database connection failed: " . mysqli_error($dbconnect));
    }


    // Redirect to login page after successful registration
    $_SESSION['success'] = "Registration successful! You can now login.";
    header("Location: http://localhost/xampp-miles/index.html");
    exit();
} else {
    // Handle the case if the form is not submitted properly
    $_SESSION['error'] = "Invalid form submission";
    header("Location: http://localhost/xampp-miles/account.html");
    exit();
}

?>