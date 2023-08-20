<?php
include_once('../../../conn.php');

$sql = "SELECT * FROM bookings b LEFT JOIN customers c ON b.customer_id = c.custid
        WHERE b.booking_status = 0 and b.view_status = 0 LIMIT 4";
$query = mysqli_query($conn, $sql);

$notifications = array();
while ($row = mysqli_fetch_assoc($query)) {
    $notification = array(
        'firstname' => ucfirst($row['firstname']),
        'time' => date('H:i:s', strtotime($row['updated_at'])),
    );
    array_push($notifications, $notification);
}

echo json_encode($notifications);
?>
