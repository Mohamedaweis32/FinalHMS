<?php
require_once "../../conn.php";
require_once "../functions.php";

// Get form data
$desid = $_POST['desid'];
$desbid = $_POST['descbid'];
$descname = $_POST['descname'];
$desamount = $_POST['desamount'];
$desdue = $_POST['desdue'];
$date = date('Y-m-d'); // Get the current date
$userid = 1;
$cid = getCustomerID($conn, $descname);
if (empty($desid)) {


    if (empty($cid)) {
        // Customer not found, do something
        $result = [
            'message' => 'Customer not found.',
            'status' => 404
        ];
        echo json_encode($result);
    } else {
        // Insert operation
        $sql = "INSERT INTO discount VALUES ( null , '$cid', '$desamount', '$userid', '$date') ";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            $totalDebit = 0;
            $transactionSql = "INSERT INTO transactions (refID,tranType, custid, credit, transactionDate, debit) 
            VALUES ('$desbid','discount', '$cid', '$desamount', '$date', '$totalDebit')";
            $transactionQuery = mysqli_query($conn, $transactionSql);

            if ($transactionQuery) {
                // Insert successful
                $result = [
                    'message' => 'Discount created successfully.',
                    'status' => 200
                ];
                echo json_encode($result);
            } else {
                // Transaction insert failed
                $result = [
                    'message' => 'Failed to create Discount.',
                    'status' => 404
                ];
                echo json_encode($result);
            }
        } else {
            // Insert failed
            $result = [
                'message' => 'Failed to create Discount.',
                'status' => 404
            ];
            echo json_encode($result);
        }
    }
} else {
    // Update operation
    $sql = "UPDATE discount
            SET customer = '$descname',
                discount_amount = '$desamount',
                amount_due = '$desdue'
            WHERE descid = '$descid'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        // Update successful
        $result = [
            'message' => 'Discount Updated successfully.',
            'status' => 200
        ];
        echo json_encode($result);
    } else {
        // Update failed
        $result = [
            'message' => 'Failed to update Discount.',
            'status' => 404
        ];
        echo json_encode($result);
    }
}
?>
