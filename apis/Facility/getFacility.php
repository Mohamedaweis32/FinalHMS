<?php
require_once "../../conn.php";
require_once "../functions.php";


if (isset($_POST['facility_id'])) {
    $id = $_POST['facility_id'];
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM facility WHERE facility_id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $FaciData = [
            'fid' => $row['facility_id'],
            'type' => $row['facility_name'],
            'price' => $row['Price'],
        ];
        echo json_encode($FaciData);
    } else {
        echo json_encode(['error' => 'Food not found']);
    }
}


// gooooooood joop

