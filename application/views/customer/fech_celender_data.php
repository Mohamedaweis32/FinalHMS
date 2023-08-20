<?php
// get_booking_info.php
require_once "../../../conn.php";

$bookingInfo = [];

$query = "SELECT b.start_date, b.end_date, c.firstname,  FROM bookings b
          LEFT JOIN customers c ON b.customer_id = c.custid";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bookingInfo[] = [
            'title' => $row['firstname'] ,
            'start' => $row['start_date'],
            'end' => $row['end_date'],
            'color' => 'red', // Set the color of booked events
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($bookingInfo);
?>
