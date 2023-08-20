<?php
require_once "../../conn.php";
require_once "../functions.php";

$fid = @$_POST['fid'];
$fprice = @$_POST['fprice'];
$ftype = @$_POST['ftype'];
$date = date('y-m-d');

if (empty($fid)) {
    if (empty($ftype) || empty($fprice)) {
        $result = [
            'message' => 'Food type and price are required.',
            'status' => 404
        ];
        echo json_encode($result);
        return;
    }

    $sql = "SELECT * FROM food WHERE foodType = '$ftype'";
    $check = if_record_exists($conn, $sql);
    if ($check) {
        $result = [
            'message' => 'Record already exists.',
            'status' => 404
        ];
        echo json_encode($result);
        return;
    }

    $sql = "INSERT INTO food (foodType, foodPrice, date) VALUES ('$ftype', '$fprice', '$date')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $result = [
            'message' => 'Food created successfully.',
            'status' => 200
        ];
        echo json_encode($result);
    } else {
        $result = [
            'message' => 'Failed to create food.',
            'status' => 404
        ];
        echo json_encode($result);
    }
} else {
    $sql = "UPDATE food SET foodType = '$ftype', foodPrice = '$fprice' WHERE foodId = '$fid'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $result = [
            'message' => 'Food updated successfully.',
            'status' => 200
        ];
        echo json_encode($result);
    } else {
        $result = [
            'message' => 'Failed to update food.',
            'status' => 404
        ];
        echo json_encode($result);
    }
}

?>
