<?php
include_once('../../../conn.php');

// Check if the AJAX request contains the required data
if (isset($_POST['aproveid']) && isset($_POST['booking_status']) && ($_POST['booking_status'] === 'approve')) 
    {
    $aproveid = $_POST['aproveid'];
    $booking_status = 1;
    
    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE bookings SET booking_status = ? WHERE booking_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $booking_status, $aproveid);
    $query = mysqli_stmt_execute($stmt);
    
    if ($query) {
        $result = [
            'message' => 'Successfully Approved',
            'status' => 200
        ];
        echo json_encode($result);
        return;
    } else {
        $result = [
            'message' => 'Failed to Approve',
            'status' => 200
        ];
        echo json_encode($result);
        return;
    }
}


// For the Reject action
if (isset($_POST['rid']) && isset($_POST['booking_status']) && ($_POST['booking_status'] === 'reject')) {
    $rid = $_POST['rid'];
    $booking_status = 2;

    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE bookings SET booking_status = ? WHERE booking_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $booking_status, $rid);
    $query = mysqli_stmt_execute($stmt);
    
    if ($query) {
        $result = [
            'message' => 'Successfully Rejected this booking',
            'status' => 200
        ];
        echo json_encode($result);
        return;
    } else {
        $result = [
            'message' => 'Failed to Reject this booking',
            'status' => 200
        ];
        echo json_encode($result);
        return;
    }
}
?>
