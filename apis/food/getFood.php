<?php
require_once "../../conn.php";
require_once "../functions.php";


if (isset($_POST['foodid'])) {
    $id = $_POST['foodid'];
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM food WHERE foodId = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $foodData = [
            'fid' => $row['foodId'],
            'type' => $row['foodType'],
            'price' => $row['foodPrice'],
        ];
        echo json_encode($foodData);
    } else {
        echo json_encode(['error' => 'Food not found']);
    }
}



