<?php

session_start(); // Make sure to start the session

// Include conn.php here if it's not already included
include '../../../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Sanitize the input to prevent SQL injection
    $startDate = mysqli_real_escape_string($conn, $startDate);
    $endDate = mysqli_real_escape_string($conn, $endDate);

    // Get the user's email from the session
    $userEmail = $_SESSION['email'];

    // Fetch data from the database based on the date range and user's email
    $sql = "SELECT c.custid, c.firstname, r.amount, t.refID, t.tranType, t.credit, t.transactionDate,
            SUM(r.amount - t.credit) AS Balance
            FROM transactions t
            JOIN customers c ON c.custid = t.custid
            JOIN receipt r ON r.customer = c.custid
            WHERE t.tranType = 'Receiption' 
            AND t.transactionDate BETWEEN '$startDate' AND '$endDate'
            AND c.email = '$userEmail'  -- Add this condition
            ORDER BY c.custid, t.transactionDate DESC";

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