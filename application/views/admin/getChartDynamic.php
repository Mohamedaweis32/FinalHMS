<?php
// Include the necessary files and establish a database connection
include '../../../conn.php';

// Query to retrieve the pending halls count from the database
$sql = "SELECT count(*) as total FROM bookings WHERE booking_status = 0";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pendingCount = $row['total'];
} else {
    $pendingCount = 0;
}

// Query to retrieve the approved halls count from the database
$sql = "SELECT count(*) as total FROM bookings WHERE booking_status = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ApprovedCount = $row['total'];
} else {
    $ApprovedCount = 0;
}

// Query to retrieve the cancelled halls count from the database
$sql = "SELECT count(*) as total FROM bookings WHERE booking_status NOT IN (0, 1)";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $CancelledCount = $row['total'];
} else {
    $CancelledCount = 0;
}

// Query to retrieve the total halls count from the database
$sql = "SELECT count(*) as total FROM bookings";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $TotalCount = $row['total'];
} else {
    $TotalCount = 0;
}

// Close the database connection
$conn->close();

// Prepare the data for JSON response
$data = array(
    'series' => [
        intval($pendingCount),
        intval($ApprovedCount),
        intval($CancelledCount),
        intval($TotalCount),
    ],
    'labels' => ['Pending Halls', 'Approved Halls', 'Cancelled Halls', 'Total Halls'],
);
// Convert the data to JSON format and send the response
header('Content-Type: application/json');
echo json_encode($data);
?>
