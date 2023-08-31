<?php
require '../conn.php';

// Validate input data
if (empty($_POST['htype']) || empty($_POST['hprice']) || empty($_POST['hlocation']) || empty($_POST['hcapacity'])) {
    $result = [
        'message' => 'Required fields are missing.',
        'status' => 400
    ];
    echo json_encode($result);
    exit;
}

// Get POST data
$hall_id = @$_POST['hall_id'];
$desc = @$_POST['hdesc'];
$type = @$_POST['htype'];
$hprice = @$_POST['hprice'];
$capacity = @$_POST['hcapacity'];
$location = @$_POST["hlocation"];
$photo = isset($_FILES['hphoto']['name']) ? $_FILES['hphoto']['name'] : '';
$path = isset($_FILES['hphoto']['tmp_name']) ? $_FILES['hphoto']['tmp_name'] : '';


$mdate = date('Y-m-d');
$folder = "../images/" . $photo;

// Check if hall_id is empty for insertion or update
if (empty($hall_id)) {
    // Insert new hall
    $sql = "INSERT INTO halls (hall_type, hallPrice, location, capacity, hall_photo, hall_desc, date)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $type, $hprice, $location, $capacity, $folder, $desc, $mdate);
    $query = mysqli_stmt_execute($stmt);

    if ($query) {
        if (!empty($photo)) {
            move_uploaded_file($path, $folder);
        }

        $result = [
            'message' => 'Successfully inserted a new hall.',
            'status' => 200
        ];
    } else {
        $result = [
            'message' => 'Could not create a new hall.',
            'status' => 500
        ];
    }

    mysqli_stmt_close($stmt);
} else {

    $photo = isset($_FILES['hphoto']['name']) ? $_FILES['hphoto']['name'] : '';
    $path = isset($_FILES['hphoto']['tmp_name']) ? $_FILES['hphoto']['tmp_name'] : '';
    $folder = "../images/" . $photo;

    $sql = "UPDATE halls SET hall_type = ?, location = ?, hallPrice = ?, capacity = ?, hall_desc = ?, date = ?, hall_photo = ?
            WHERE hall_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $type, $location, $hprice, $capacity, $desc, $mdate, $photo, $hall_id);
    $query = mysqli_stmt_execute($stmt);

    if ($query) {
        if (!empty($photo)) {
            // Only move the file if a new photo has been provided
            move_uploaded_file($path, $folder);
        }

        $result = [
            'message' => 'Successfully updated the hall.',
            'status' => 200
        ];
    } else {
        $result = [
            'message' => 'Could not update the hall.',
            'status' => 500
        ];
    }
}
mysqli_stmt_close($stmt);

echo json_encode($result);

?>