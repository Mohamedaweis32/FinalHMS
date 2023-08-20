<?php

//header('Content-Type: application/json');


include '../../../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming you have a table named 'employees' in your database
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Sanitize the input to prevent SQL injection (assuming 'startDate' and 'endDate' are date values)
    $startDate = mysqli_real_escape_string($conn, $startDate);
    $endDate = mysqli_real_escape_string($conn, $endDate);

    // Fetch data from the database based on the date range
    $sql = "SELECT b.booking_id,c.firstname,h.hall_type,
    CASE 
        WHEN b.booking_status = 0 THEN 'pending'
        WHEN b.booking_status = 1 THEN 'approved'
        ELSE 'unknown'
    END AS booking_status,
    b.Rate,f.foodType,b.start_date,b.end_date 
    FROM bookings b
    JOIN customers c ON c.custid = b.customer_id
    JOIN food f ON f.foodId = b.foodId
    JOIN halls h ON h.hall_id = b.hall_id
    WHERE b.created_at BETWEEN '$startDate' AND '$endDate'";

    $result = mysqli_query($conn, $sql);

    $data = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    // Close the database connection
    mysqli_close($conn);

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);

}
?>

