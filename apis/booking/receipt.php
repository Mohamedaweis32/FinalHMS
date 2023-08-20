<?php
require_once "../../conn.php";
require_once "../functions.php";

// Get form data
$bid = $_POST['rbid'];   
$rid = $_POST['rid'];
$rtype = $_POST['rtype'];
$rcname = $_POST['rcname'];
$ramount = $_POST['ramount'];
$rdue = $_POST['rdue'];
$date = date('Y-m-d'); // Get the current date
$userid = 1;

$cid = getCustomerID($conn, $rcname);
if (empty($rid)) {

    if($ramount > $rdue){
        $result = [
            'message' => 'Please The amountpaid can exceed due amount.',
            'status' => 404
        ];
        echo json_encode($result);
    }
    if(empty($bid)){
        $result = [
            'message' => 'Please The amountpaid can exceed due amount.',
            'status' => 404
        ];
        echo json_encode($result);
    }

else{


    // Insert operation
    $sql = "INSERT INTO receipt (receipttype, customer, amount, receiptby, date)
            VALUES ('$rtype', '$cid', '$ramount', '$userid', '$date')";
    $query = mysqli_query($conn, $sql);
    $lastInsertedID = mysqli_insert_id($conn);

    if ($query) {
        $totalDebit = 0;
        $transactionSql = "INSERT INTO transactions (refID,tranType, custid, credit, transactionDate, debit) 
        VALUES ('$bid', 'Receiption','$cid', '$ramount', '$date', '$totalDebit')";
        $transactionQuery = mysqli_query($conn, $transactionSql);

        if ($transactionQuery) {
            $result = [
                'message' => 'Receipt created successfully.',
                'status' => 200,
                'id' => $cid
            ];
            echo json_encode($result);
        } else {
            // Insert failed
            $result = [
                'message' => 'Failed Receipt.',
                'status' => 404,
               
            ];
            echo json_encode($result);
        }
    }
}
}
 else {
    // Update operation
    $sql = "UPDATE receipt
            SET receipttype = '$rtype',
                customer = '$rcname',
                amount = '$ramount',
                receiptby = '$rdue',
                date = '$date'
            WHERE receipt_id = '$rid'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        // Update successful
        $result = [
            'message' => 'Receipt Updated successfully.',
            'status' => 200
        ];
        echo json_encode($result);
    } else {
        $result = [
            'message' => 'Receipt Failed to get Updated successfully.',
            'status' => 200
        ];
        echo json_encode($result);
    }
}
?>
