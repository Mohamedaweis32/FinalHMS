<?php
// Include the database connection file
require_once("../../conn.php"); // Update the path accordingly

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // Assuming the email is submitted through AJAX

    // Escape the email input to prevent SQL injection
    $safeEmail = mysqli_real_escape_string($conn, $email);
    
    $sql = "SELECT * FROM Users WHERE email='$safeEmail'";
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $record = mysqli_fetch_assoc($result);

        if ($record) {
            echo "email_exists";
        } else {
            echo "email_not_found";
        }
    } else {
        echo "Query failed: " . mysqli_error($conn);
    }

    // Don't forget to close the database connection when you're done
    mysqli_close($conn);
}
?>