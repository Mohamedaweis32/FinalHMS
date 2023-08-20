<?php

//header('Content-Type: application/json');


include '../../../conn.php';

start_session();
if (!isset($_SESSION['email'])) {
    $result = [
        'message' => 'Email Not Found.',
        'status' => 404
    ];
    echo json_encode($result);
    exit;
}
$email = $_SESSION['email'];
$CustomerEmailQuery = "SELECT * FROM customers WHERE email='$email'";
$getCustomer = mysqli_query($conn, $CustomerEmailQuery);

if (!$getCustomer || mysqli_num_rows($getCustomer) === 0) {
    $result = [
        'message' => 'Customer ID Not Found.',
        'status' => 404
    ];
    echo json_encode($result);
    exit;
}

$data = mysqli_fetch_assoc($getCustomer);
$customerId = $data['custid'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming you have a table named 'employees' in your database
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Sanitize the input to prevent SQL injection (assuming 'startDate' and 'endDate' are date values)
    $startDate = mysqli_real_escape_string($conn, $startDate);
    $endDate = mysqli_real_escape_string($conn, $endDate);

    // Fetch data from the database based on the date range

    $sql = "SELECT * FROM transactions 
        WHERE custid = '$customerId'
        AND created_at BETWEEN '$startDate'  AND '$endDate' ";
   
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

