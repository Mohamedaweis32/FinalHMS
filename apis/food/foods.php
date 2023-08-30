<?php
require_once "../../conn.php";
require_once "../functions.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$fid = @$_POST['fid'];
$fprice = @$_POST['fprice'];
$ftype = @$_POST['ftype'];
$date = date('y-m-d');

// Ensure proper values are received
if (empty($ftype) || empty($fprice)) {
    $result = [
        'message' => 'Food type and price are required.',
        'status' => 404
    ];
    echo json_encode($result);
    return;
}

// Construct the SQL query
if (empty($fid)) {
    $sql = "INSERT INTO food (foodType, foodPrice, date) VALUES ('$ftype', '$fprice', '$date')";
} else {
    $sql = "UPDATE food SET foodType = '$ftype', foodPrice = '$fprice' WHERE foodId  = '$fid'";
}

// Log the SQL query for debugging
error_log("SQL Query: $sql");

// Execute the SQL query
$query = mysqli_query($conn, $sql);

// Check if the query was successful
if ($query) {
    $result = [
        'message' => empty($fid) ? 'Food created successfully.' : 'Food updated successfully.',
        'status' => 200
    ];
    echo json_encode($result);
} else {
    $result = [
        'message' => empty($fid) ? 'Failed to create food.' : 'Failed to update food.',
        'status' => 404
    ];
    echo json_encode($result);
}
?>