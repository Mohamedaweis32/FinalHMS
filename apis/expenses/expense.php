<?php

require_once "../../conn.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id = $_POST['expense_id'];
    $type = $_POST['expense_type'];
    $amount = $_POST['amount'];
    $date = date('Y-m-d'); // Use 'Y' instead of 'y' for 4-digit year
    $createdby = 1;
    #
    $description=$_POST['description'];

    // Check if "id" parameter is present in the request (for update)
    if (!empty($id)) {
        // Perform update query for existing expense
        $sql = "UPDATE expenses SET type='$type', amount='$amount',description='$description', date='$date', createdby='$createdby' WHERE expenseid='$id'";
        if (mysqli_query($conn, $sql)) {
            $result = [
                'message' => 'Expense updated successfully.',
                'status' => 200
            ];
            echo json_encode($result);
        } else {
            $result = [
                'message' => 'Failed to update the expense.',
                'status' => 404
            ];
            echo json_encode($result);
        }
    } else {
        // Perform insert query for new expense
        $sql = "INSERT INTO expenses (type, amount,description, date, createdby) 
                VALUES ('$type', '$amount',  '$description','$date' ,'$createdby')";
        if (mysqli_query($conn, $sql)) {
            // Insert into transactions table
            $lastInsertedID = mysqli_insert_id($conn); // Get the ID of the last inserted row
            $transactionSql = "INSERT INTO transactions (refID, tranType, credit, transactionDate, debit) 
                               VALUES ('$lastInsertedID', 'Expense', 0, '$date', '$amount')";
            $transactionQuery = mysqli_query($conn, $transactionSql);
            if ($transactionQuery) {
                $result = [
                    'message' => 'Expense created successfully.',
                    'status' => 200
                ];
                echo json_encode($result);
            } else {
                $result = [
                    'message' => 'Failed to create a transaction for the expense.',
                    'status' => 404
                ];
                echo json_encode($result);
            }
        } else {
            $result = [
                'message' => 'Failed to create the expense.',
                'status' => 404
            ];
            echo json_encode($result);
        }
    }
}
?>
