<?php
require_once '../conn.php';

function validateInput($data)
{
    return !empty($data);
}

function isHallTypeUnique($conn, $type)
{
    $sql = "SELECT COUNT(*) FROM halls WHERE hall_type = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $type);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $count === 0;
}

function uploadFile($file)
{
    if ($file['error'] === UPLOAD_ERR_OK) {
        $tempPath = $file['tmp_name'];
        $fileName = basename($file['name']);
        $uploadPath = "../images/$fileName";
        if (move_uploaded_file($tempPath, $uploadPath)) {
            return $uploadPath;
        }
    }
    return null;
}

$result = [
    'message' => '',
    'status' => 200
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hall_id = isset($_POST['hall_id']) ? $_POST['hall_id'] : null;
    $desc = $_POST['hdesc'];
    $type = $_POST['htype'];
    $hprice = $_POST['hprice'];
    $capacity = $_POST['hcapacity'];
    $location = $_POST['hlocation'];
    $photo = isset($_FILES['hphoto']) ? $_FILES['hphoto'] : null;
    $mdate = date('Y-m-d');

    // Validate required fields
    if (!validateInput($type) || !validateInput($hprice) || !validateInput($capacity) || !validateInput($location)) {
        $result['message'] = 'Required fields are missing.';
        $result['status'] = 404;
    } else {
        $uploadPath = null; // Initialize to null

        if ($photo) {
            $uploadPath = uploadFile($photo);
            if (!$uploadPath) {
                $result['message'] = 'Failed to upload the photo.';
                $result['status'] = 404;
            }
        }

        // Check if hall type is unique
        if (isHallTypeUnique($conn, $type) || $hall_id) {
            if (!$hall_id) {
                // Insert new hall
                $sql = "INSERT INTO halls (hall_type, hallPrice, location, capacity, hall_photo, hall_desc, date)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssssss", $type, $hprice, $location, $capacity, $uploadPath, $desc, $mdate);
            } else {
                // Update existing hall
                $sql = "UPDATE halls SET hall_type = ?, location = ?, hallPrice = ?, capacity = ?, hall_desc = ?, date = ?, hall_photo = ?
                        WHERE hall_id = ?";

                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssssssi", $type, $location, $hprice, $capacity, $desc, $mdate, $uploadPath, $hall_id);
            }

            $query = mysqli_stmt_execute($stmt);

            if ($query) {
                $result['message'] = 'Successfully ' . ($hall_id ? 'updated' : 'inserted') . ' the hall.';
                if (!$hall_id) {
                    $result['hall_id'] = mysqli_insert_id($conn);
                }
            } else {
                $result['message'] = 'Could not ' . ($hall_id ? 'update' : 'insert') . ' the hall.';
                $result['status'] = 404;
            }

            mysqli_stmt_close($stmt);
        } else {
            $result['message'] = 'A hall with the same type already exists.';
            $result['status'] = 404;
        }
    }
} else {
    $result['message'] = 'Invalid request method.';
    $result['status'] = 404;
}

echo json_encode($result);
?>