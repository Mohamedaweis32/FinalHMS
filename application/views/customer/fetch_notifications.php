<?php
include_once('../../../conn.php');

session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $sql = "SELECT * FROM bookings b
            LEFT JOIN customers c ON b.customer_id = c.custid
            WHERE c.email = '$email' AND booking_status IN (1, 2)";
    $query = mysqli_query($conn, $sql);

    $notifications = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $bstatus = $row['booking_status'];
        $updatedAt = strtotime($row['updated_at']);
        $time = date('H:i:s', $updatedAt);

        $notification = [
            'status' => $bstatus,
            'firstname' => $row['firstname'],
            'time' => $time,
        ];

        array_push($notifications, $notification);
    }

    echo json_encode($notifications);
}
?>
