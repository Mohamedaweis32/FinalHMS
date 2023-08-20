<?php

require_once "../../conn.php";
$payid=$_POST['payid'];
$expensesId=$_POST['expensesId'];
$amount=$_POST['payamount'];
$type=$_POST['paytype'];
$Receeiptby=1;
$date=date('y-m-d');


    
    
    if($payid==null || empty($payid)){
        if(empty($type)){
            $result = [
                'message' => 'Type is Required.',
                'status' => 404
            ];
            echo json_encode($result);
        }
        
        else if (empty($amount)){
            $result = [
                'message' => 'Amount is required',
                'status' => 404
            ];
            echo json_encode($result);
            
        }

        else{

$sql="insert into receipt(receipttype,amount,receiptby,date)
 values('$type','$amount','$Receeiptby','$date')";
 if(mysqli_query($conn,$sql)){
    $lastInsertedID = mysqli_insert_id($conn); // Get the ID of the last inserted row
    $transactionSql = "INSERT INTO transactions (refID, tranType, credit, transactionDate, debit) 
                       VALUES ('$expensesId', 'ExpensePayment', '$amount', '$date', 0)";
    $transactionQuery = mysqli_query($conn, $transactionSql);
    $result = [
        'message' => 'Payment created successfully.',
        'status' => 200
    ];
    echo json_encode($result);
 }

 else{
    $result = [
        'message' => 'Payment Failed .',
        'status' => 404
        ];
    echo json_encode($result);
 } 
 }

}