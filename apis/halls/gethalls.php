<?php


require '../../conn.php';
require '../functions.php';

if (isset($_POST['hallid'])) {
    $id = $_POST['hallid'];
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM halls WHERE hall_id= '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $hallData = [
            'hid' => $row['hall_id'],
            'htype' => $row['hall_type'],
            'hlocation' => $row['location'],
            'hprice' => $row['hallPrice'],
            'hcapacity' => $row['capacity'],
            'hdesc' => $row['hall_desc'],
            'hphoto' => $row['hall_photo']
        ];
        echo json_encode($hallData);
    } else {
        echo json_encode(['error' => 'hall not found']);
    }
}
