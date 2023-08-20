
<?php


require '../../conn.php';
require '../functions.php';

if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];
    $success = deleteItemFromDatabase($itemId, $conn);
    if ($success) {
        echo "success.";
        exit(); 
    } else {
        echo "Failed to delete the item.";
    }
}

// Function to delete the item from the database
function deleteItemFromDatabase($itemId, $conn) {

    $sql = "delete from halls where hall_id = '$itemId' ";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        return true;
    } else {
        return false;
    }
}