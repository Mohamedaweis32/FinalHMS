<?php
require_once "conn.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
      // Get form data
      $fullName = $_POST['name'];
      $email = $_POST['email'];
      $address = $_POST['Address']; // Note the uppercase 'A' in 'Address'
      $phone = $_POST['Phone']; // Note the uppercase 'P' in 'Phone'
      $password = $_POST['password'];
      $confirmPassword = $_POST['confirmPassword'];
      $date = date('Y-m-d'); // Use uppercase 'Y' for full year
      $status = 0; // Assuming 0 for inactive users
      $type = "customer";

    // Perform form validation (You can add more validation as needed)
    if (empty($fullName) || empty($email) || empty($address) || empty($phone) || empty($password) || empty($confirmPassword)) {
        $response = [
            'status' => 404,
            'message' => 'All fields are required.'
        ];
        echo json_encode($response);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = [
            'status' => 404,
            'message' => 'Invalid email format.'
        ];
        echo json_encode($response);
        exit;
    }

    if ($password !== $confirmPassword) {
        $response = [
            'status' => 404,
            'message' => 'Passwords do not match.'
        ];
        echo json_encode($response);
        exit;
    }

    // Hash the password
    //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // If no validation errors, proceed with user creation
    $sql = "INSERT INTO users (username, password, email, type, status, date) 
            VALUES ('$fullName', '$password', '$email', '$type', '$status', '$date')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // User created successfully
        $insertCustomers = "INSERT INTO customers (firstname, phone, address, email, date) 
                            VALUES ('$fullName', '$phone', '$address', '$email', '$date')";
        $success = mysqli_query($conn, $insertCustomers);
        if ($success) {
            $response = [
                'status' => 200,
                'message' => 'User created successfully.'
            ];
            echo json_encode($response);
        } else {
            // Failed to create customer
            $response = [
                'status' => 404,
                'message' => 'Failed to create user. Please try again later.'
            ];
            echo json_encode($response);
        }
    } else {
        // Failed to create user
        $response = [
            'status' => 404,
            'message' => 'Failed to create user. Please try again later.'
        ];
        echo json_encode($response);
    }
}
?>
