<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $nid = $_POST['nid'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $property = $_POST['property'];
    // Handle file uploads
    $avatar = $_FILES['avatar']['name'];
    $avatar_tmp = $_FILES['avatar']['tmp_name'];
    $document = $_FILES['document']['name'];
    $document_tmp = $_FILES['document']['tmp_name'];
    $message = $_POST['message'];
    
    // Set the recipient email address
    $to = "nusaibasafants@gmail.com"; // Change this to your desired email address
    
    // Set the email subject
    $subject = "New Real Estate Booking";

    // Establish database connection
    $dbconnect = mysqli_connect('localhost', 'root', 'password', 'miles_builders');

    if($dbconnect) {
        // Prepare and execute SQL query
        $sql = "INSERT INTO `booking` (`name`, `nid`, `email`, `phone`, `property`, `avatar`, `document`, `message`) 
                VALUES ('$name', '$nid', '$email', '$phone', '$property', '$avatar', '$document', '$message')";
        
        $dataInsert = mysqli_query($dbconnect, $sql);

        if ($dataInsert) {
            echo "Data inserted to DB Successfully";
        } else {
            die("Data insertion failed: " . mysqli_error($dbconnect));
        }
    } else {
        die("Database connection failed: " . mysqli_error($dbconnect));
    }

    // Move uploaded files to desired directory
    move_uploaded_file($avatar_tmp, "avatars/$avatar");
    move_uploaded_file($document_tmp, "documents/$document");

    // Redirect after successful submit
    header("Location: http://localhost/xampp-miles/sell-property.html?success=1");
    exit();
} else {
    // Redirect if form is not submitted properly
    header("Location: http://localhost/xampp-miles/sell-property.html");
    exit();
}
?>