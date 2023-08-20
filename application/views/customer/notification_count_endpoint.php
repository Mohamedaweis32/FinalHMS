<?php
require_once "../../../conn.php"; // Include your database connection file

// Start the PHP session to access $_SESSION variables
session_start();

$email = $_SESSION['email'];
$count = 0;

$sql = "SELECT COUNT(*) as notification_count FROM bookings b
        LEFT JOIN customers c ON b.customer_id = c.custid
        WHERE booking_status in (1,2) AND c.email = '$email'";
$query = mysqli_query($conn, $sql);

if ($query && mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    $count = $row['notification_count'];
}

// Return the notification count as JSON
echo json_encode(
    ['count' => $count]);
?>
