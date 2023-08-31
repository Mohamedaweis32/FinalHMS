<?php

require_once '../../conn.php';
require_once '../functions.php';


if (isset($_POST["itemId"])) {
    $id = $_POST['itemId'];
    $sql = "delete from users where user_id ='$id'";
    $sucess = allqueryHandler($conn, $sql);
    if ($sucess) {
        $result = [
            'message' => 'User Deleted Successfully.',
            'status' => 200
        ];
        echo json_encode($result);
        return;
    } else {
        $result = [
            'message' => 'Failed to Delete user or this item is being used other places .',
            'status' => 404
        ];

    }

    echo json_encode($result);
    return;

}