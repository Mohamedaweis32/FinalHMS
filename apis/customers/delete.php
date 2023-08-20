<?php
require '../../conn.php';
require '../functions.php';

if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];
    $sql="delete from customers where custid='$itemId'";
    $success = allqueryHandler($conn, $sql);
    if ($success) {
        echo "success.";
        exit(); 
    } else {
        echo "Failed to delete the item.";
    }
}