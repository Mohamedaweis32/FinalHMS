<?php
require_once "../../conn.php";
require_once "../functions.php";

if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];
    $sql="delete from food where foodId='$itemId'";
    $success = allqueryHandler($conn, $sql);
    if ($success) {
        $result = [
            'message' => 'Deleted sucessfully.',
            'status' => 200
        ];
        echo json_encode($result);
        return;
     
    } else {
        $result = [
            'message' => 'Failed to delete.',
            'status' => 400
        ];
        echo json_encode($result);
        return;
    }
}