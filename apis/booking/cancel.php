<?php
require '../../conn.php';
require '../functions.php';

if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];
    
    // Use prepared statement to prevent SQL injection
    $sql = "UPDATE bookings SET booking_status  = 2 WHERE booking_id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $itemId);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = [
            'message' => 'Record has been cancelled .',
            'status' => 200,
       
         ];
         echo json_encode($result);
    } else {
        $result = [
            'message' => 'Failed TO Cancell Record .',
            'status' => 404,
  
         ];
         echo json_encode($result);
    }
    
    mysqli_stmt_close($stmt);
}
?>
