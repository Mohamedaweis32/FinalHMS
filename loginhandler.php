<?php
 session_start();
require_once 'conn.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["Email"];
    $pass = $_POST["password"];

    // Perform basic server-side validation (you can add more validation)
    if (empty($email) || empty($pass)) {
        $response = array("status" => 404, "message" => "Please fill in all fields.");
        echo json_encode($response);
        exit();
    }

//     // Handle empty email or password here
 else {
    // Sanitize user input to prevent SQL injection (recommended)
    $email = mysqli_real_escape_string($conn, $email);
    $pass = mysqli_real_escape_string($conn, $pass);

    // Check user credentials in the database
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $type = $row['type'];
        $_SESSION['user_id'] = $row['user_id']; // Store the user ID in the session
        $_SESSION['type'] = $type; // Store the user type in the session
        $_SESSION['email'] = $row['email']; // Store the user type in the session

        if ($type == "admin") {
            $response = array("status" => 300, "message" => "Login successful for regular user.");
            echo json_encode($response);
            exit();
           

        } else {
             // If the user is an admin
             $response = array("status" => 500, "message" => "Login successful for admin.");
             echo json_encode($response);
         

             exit();
        }
    } else {
        $response = array("status" => 404, "message" => "Invalid email or password.");
        echo json_encode($response);
        
        exit();
    }
}
}
?>