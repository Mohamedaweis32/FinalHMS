<?php
// Start the session
session_start();

require_once '../../../conn.php';



// Check if the user is logged in and has necessary IDs in session
if (isset($_SESSION['email'])) {
    $email=$_SESSION['email'];
    $CusQuery="select * from customers where email='$email'";
    $exCustomer=mysqli_query($conn,$CusQuery);
    $UserQuery="select * from users where email='$email'";
    $exUser=mysqli_query($conn,$UserQuery);
    if($exCustomer && $exUser && mysqli_num_rows($exCustomer) > 0 && mysqli_num_rows($exUser) > 0){
        $result=mysqli_fetch_array($exCustomer);
        $cid=$result['custid'];

        
    // Gather updated information from POST data
    $updatedFullName = $_POST['fullName'];
    $updatedEmail = $_POST['email'];
    $updatedPhone = $_POST['phone'];
    $updatedPass = $_POST['pass'];

    // Update user information
    $sqlUpdateUser = "UPDATE users SET username = ?, email = ? , password= ?   WHERE email = ?";
    $stmtUpdateUser = $conn->prepare($sqlUpdateUser);
    $stmtUpdateUser->bind_param("ssss", $updatedFullName, $updatedEmail, $updatedPass, $email);
    $updateUserResult = $stmtUpdateUser->execute();
    
    
    // Update customer information
    $sqlUpdateCustomer = "UPDATE customers SET firstname = ?, email = ?, phone = ? WHERE custid = ?";
    $stmtUpdateCustomer = $conn->prepare($sqlUpdateCustomer);
    $stmtUpdateCustomer->bind_param("sssi", $updatedFullName, $updatedEmail, $updatedPhone, $cid);
    $updateCustomerResult = $stmtUpdateCustomer->execute();

    // Check if updates were successful
    if ($updateUserResult && $updateCustomerResult) {
        // Updates were successful
        $response = [
            'status' => 200,
            'message' => 'Profile updated successfully.'
        ];
    } else {
        // Updates failed
        $response = [
            'status' => 404,
            'message' => 'An error occurred while updating profile.'
        ];
    }

    // Close prepared statements
    $stmtUpdateUser->close();
    $stmtUpdateCustomer->close();

    // Close the database connection
    $conn->close();

    // Return the JSON response

    echo json_encode($response);
} else {
    // User is not logged in or IDs are missing in session
    $response = [
        'status' => 500,
        'message' => 'Unauthorized'
    ];


    echo json_encode($response);
}
    }

   

?>
