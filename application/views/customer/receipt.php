<?php
session_start();
require_once "../../../conn.php";
require_once "../../../apis/functions.php";


$email= $_SESSION['email'];
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
            'message' => 'No Valid booking found.',
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

?>
