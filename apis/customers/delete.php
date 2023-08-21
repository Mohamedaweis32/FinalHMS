<?php
require '../../conn.php';
require '../functions.php';

if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];


    // Check if the custid is connected to another table as a foreign key
    $sqlCheck = "SELECT COUNT(*) as count FROM bookings WHERE customer_id='$itemId'";
    $resultCheck = mysqli_query($conn, $sqlCheck);
    $row = mysqli_fetch_assoc($resultCheck);
    $count = $row['count'];

    if ($count > 0) {
        // If the custid is connected to another table, deny the deletion
        echo "Cannot delete the item. It is connected to another table.";
    } else {
        // If the custid is not connected to another table, proceed with deletion
        $sql = "DELETE FROM customers WHERE custid='$itemId'";
        $success = allqueryHandler($conn, $sql);
        if ($success) {
            echo "Success.";
        } else {
            echo "Failed to delete the item.";
        }
    }


}
?>