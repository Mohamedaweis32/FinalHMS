<?php
if (!empty($_POST['bid'])) {
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $id = $_POST['bid'];
 if(empty($id)){
    $result = [
        'message' => 'id is empty.',
        'status' => 200,
      
    ];
    echo json_encode($result);
 }

 else{

    $sql = "UPDATE bookings SET start_date ='$start_date', end_date ='$end_date',
     starttime ='$startTime', endtime ='$endTime' WHERE booking_id='$id'";

    $query = mysqli_query($conn, $sql);

    // Send back a response
    if ($query) {
        $result = [
            'message' => 'Adjustment Done successfully.',
            'status' => 200,
          
        ];
        echo json_encode($result);
    } else {
        $result = [
            'message' => 'Adjustment Failed.',
            'status' => 200,
          
        ];
        echo json_encode($result);
    }
}

 }
?>
