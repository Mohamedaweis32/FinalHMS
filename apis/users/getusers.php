<?php
// Check if the form is submitted

require '../../conn.php';


if (isset($_POST['user_id'])) {
        $id = $_POST['user_id'];
        $id = mysqli_real_escape_string($conn, $id);
        $sql = "SELECT * FROM users WHERE user_id='$id' ";
        $result = mysqli_query($conn, $sql);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
    
            $USerData = [
                'name' => $row['username'],
                'id' => $row['user_id'],
                'pass' => $row['password'],
                'email' => $row['email'],
                'type' => $row['type'],
                'status' => $row['status'],
                
            ];
            echo json_encode($USerData);
        } else {
            echo json_encode(['error' => 'Customer Not found']);
        }
    }