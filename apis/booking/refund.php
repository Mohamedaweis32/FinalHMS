<?php
require_once "../../conn.php";
require_once "../functions.php";

// Get form data
$refid = $_POST['refid'];
$refbid = $_POST['refbid'];
$rtype = $_POST['rtype'];
$refcname = $_POST['refcname'];
$refamount = $_POST['refamount'];
$refdue = $_POST['refdue'];
$date = date('Y-m-d'); // Get the current date
$userid = 1;
$totalDebit=0;


if (empty($refid)) {
    $cid = getCustomerID($conn, $refcname);
    // Insert operation
    $sql = "INSERT INTO refund (reftype, customer, amount, createdby, date)
            VALUES ('$rtype', '$cid', '$refamount', '$userid', '$date')";
    $query = mysqli_query($conn, $sql);
    $lastInsertedID = mysqli_insert_id($conn);

    if ($query) {
        // Insert successful
        $transactionSql = "INSERT INTO transactions (refID,tranType, custid, credit, transactionDate, debit) 
        VALUES ('$refbid', 'Refund','$cid', '$refamount', '$date', '$totalDebit')";
        $transactionQuery = mysqli_query($conn, $transactionSql);

        if ($transactionQuery) {
            $result = [
                'message' => 'Refund created successfully.',
                'status' => 200
            ];
            echo json_encode($result);
        } 
    } else {
        // Insert failed
        $result = [
            'message' => 'Failed to create Refund.',
            'status' => 404
        ];
        echo json_encode($result);
    }
} else {
    // Update operation
    $sql = "UPDATE refund
            SET reftype = '$rtype',
                customer = '$refcname',
                amount = '$refamount',
                createdby = '$userid',
                date = '$date'
            WHERE refundid = '$refid'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        // Update successful
        $result = [
            'message' => 'Refund Updated successfully.',
            'status' => 200
        ];
        echo json_encode($result);
    } else {
        // Update failed
        $result = [
            'message' => 'Failed to update Refund.',
            'status' => 404
        ];
        echo json_encode($result);
    }
}
?>
