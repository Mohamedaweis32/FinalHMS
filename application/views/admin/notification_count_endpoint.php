<?php
require_once "../../../conn.php"; // Include your database connection file

// Start the PHP session to access $_SESSION variables
session_start();

$email = $_SESSION['email'];
$count = 0;
$newNotification="";
$sql = "SELECT COUNT(*) as notification_count FROM bookings  WHERE booking_status = 0 and view_status = 0";
$query = mysqli_query($conn, $sql);

if ($query && mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    $count = $row['notification_count'];
    $newNotification="newNotification";
}

// Return the notification count as JSON
echo json_encode(['count' => $count,
'newNotification'=>$newNotification
]);
?>
