<?php
require '../../../conn.php';


if (isset($_POST['rid'])) {
    $id = $_POST['rid'];
    $id = mysqli_real_escape_string($conn, $id);



SELECT start_date, end_date, starttime, endtime FROM hbs.bookings b LEFT JOIN hbs.customers c ON c.custid = b.customer_id WHERE b.booking_id ='$id';
    
 
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $bdata = [
           'start_date'  =>$row['start_date'],
            'end_date'  => $row['end_date'],
            'starttime'  => $row['starttime'],
            'endtime'  => $row['endtime'],
            
        ];
        echo json_encode($bdata);
    } else {
        echo json_encode(['error' => 'Booking Not found']);
    }
}