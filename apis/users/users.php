<?php
require '../../conn.php';
require '../functions.php';

// Retrieve form data
$uname = $_POST['uname'];
$userid = $_POST['userid'];
$upass = $_POST['upass'];
$email = $_POST['email'];
$type = $_POST['type'];
$date = date('y-m-d');

if (empty($userid)) {
    // Validate required fields
    if (empty($upass) || empty($uname) || empty($email) || empty($type)) {
        $result = [
            'message' => 'All fields are required.',
            'status' => 404 // Use 400 Bad Request for validation errors
        ];
        echo json_encode($result);
        return;
    }

    // Validate password
    if (!isPasswordValid($upass)) {
        $result = [
            'message' => 'Password does not meet criteria.',
            'status' => 404 // Use 400 Bad Request for validation errors
        ];
        echo json_encode($result);
        return;
    }

    // Check if email or username already exists
    if (isEmailRegistered($email, $conn) || isUserExists($uname, $conn)) {
        $result = [
            'message' => 'Email or username already exists.',
            'status' => 404 // Use 400 Bad Request for validation errors
        ];
        echo json_encode($result);
        return;
    }

    // Insert new user
    $sql = "INSERT INTO `users`(`user_id`, `username`, `password`, `email`, `type`, `date`) VALUES(null,'$uname', '$upass', '$email', '$type', '$date')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        // Insert successful
        $result = [
            'message' => 'User created successfully.',
            'status' => 200
        ];
        echo json_encode($result);
        return;
    } else {
        // Insert failed
        $result = [
            'message' => 'Failed to create user.',
            'status' => 404 // Use 500 Internal Server Error for database errors
        ];
        echo json_encode($result);
        return;
    }
} else {
    // Update existing user
    $sql = "UPDATE users SET username='$uname', password='$upass', email='$email', type='$type' WHERE user_id='$userid'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        // Update successful
        $result = [
            'message' => 'User updated successfully.',
            'status' => 200
        ];
        echo json_encode($result);
        return;
    } else {
        // Update failed
        $result = [
            'message' => 'Failed to update user.',
            'status' => 404 // Use 500 Internal Server Error for database errors
        ];
        echo json_encode($result);
        return;
    }
}
?>