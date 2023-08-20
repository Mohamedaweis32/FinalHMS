<?php

require '../../conn.php';
require '../functions.php';
    // Retrieve form data
    $uname = $_POST['uname'];
    $userid = $_POST['userid'];
    $upass = $_POST['upass'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    $status =$_POST['status'];
    $date = date('y-m-d');

    if (empty($userid)){

        $sql="select * from users where email='$email'";
        $query=mysqli_query($conn,$sql);
        if($query && mysqli_num_rows($query)>0){
            $result = [
            'message' => 'User Already exists.',
            'status' => 404
            ];
        }

        else{
    $sql = "INSERT INTO users VALUES (null,'$uname', '$upass', '$email', '$type', '$status','$date')";
    $query = mysqli_query($conn, $sql);

    // Check if the insert was successful
    if ($query) {
        // Insert successful
        $result = [
            'message' => 'User created successfully.',
            'status' => 200
        ];
        echo json_encode($result);
    } else {
        // Insert failed
        $result = [
            'message' => 'Failed to create user.',
            'status' => 404
        ];
        echo json_encode($result);
    }
}
    }
    else{
        
    $sql = "UPDATE users SET username='$uname', password='$upass', 
    email='$email', type='$type', status='$status' WHERE user_id='$userid'";
    $query = mysqli_query($conn, $sql);

    // Check if the update was successful
    if ($query) {
        // Update successful
        $result = [
            'message' => 'User updated successfully.',
            'status' => 200
        ];
        echo json_encode($result);
    } else {
        // Update failed
        $result = [
            'message' => 'Failed to update user.',
            'status' => 404
        ];
        echo json_encode($result);
    }
    }



  
?>
