<?php
require '../../../conn.php';

if (isset($_POST['rid'])) {
    $id = $_POST['rid'];
    $id = mysqli_real_escape_string($conn, $id);

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT start_date, end_date, starttime, endtime,b.booking_id as bid FROM hbs.bookings b LEFT JOIN hbs.customers c ON c.custid = b.customer_id WHERE b.booking_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $bdata = [
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'starttime' => $row['starttime'],
            'endtime' => $row['endtime'],
            'bid' => $row['bid'],
        ];
        echo json_encode($bdata);
    } else {
        echo json_encode(['error' => 'Booking Not found']);
    }

    mysqli_stmt_close($stmt); // Close the prepared statement
}
?>