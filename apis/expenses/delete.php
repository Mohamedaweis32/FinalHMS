<?php
require '../../conn.php';
require '../functions.php';

if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];
    $sql="delete from expenses where expenseid='$itemId'";
    $success = allqueryHandler($conn, $sql);
    $sql="delete from transactions where refID='$itemId'";
    if ($success) {
        $sql="delete from transactions where refID='$itemId' and tranType ='Expense'";
        $success = allqueryHandler($conn, $sql);
       
        if($success) 
      {  echo "success.";
        exit();

        }
        
    } else {
        echo "Failed to delete the item.";
    }
}