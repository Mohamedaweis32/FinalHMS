<?php
if (!empty($_POST['bid'])) {
    require '../../../conn.php'; // Include your database connection

    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $id = $_POST['bid'];

    if (empty($id)) {
        $result = [
            'message' => 'ID is empty.',
            'status' => 404, // Bad Request
        ];
        echo json_encode($result);
    } else {
        // Validate start and end dates
        $currentDate = date('Y-m-d');
        if ($start_date < $currentDate || $end_date < $currentDate) {
            $result = [
                'message' => 'Dates cannot be before the current date.',
                'status' => 404, // Unprocessable Entity
            ];
            echo json_encode($result);
        } else {
            // Check if a conflicting booking already exists
            $sqlCheckConflict = "SELECT COUNT(*) FROM bookings WHERE booking_id != ? AND (start_date BETWEEN ? AND ? OR end_date BETWEEN ? AND ?)";
            $stmtCheckConflict = $conn->prepare($sqlCheckConflict);
            $stmtCheckConflict->bind_param("issss", $id, $start_date, $end_date, $start_date, $end_date);
            $stmtCheckConflict->execute();
            $stmtCheckConflict->bind_result($conflictCount);
            $stmtCheckConflict->fetch();
            $stmtCheckConflict->close();

            if ($conflictCount > 0) {
                $result = [
                    'message' => 'Conflict with existing booking dates.',
                    'status' => 404, // Conflict
                ];
                echo json_encode($result);
            } else {
                // Use prepared statements for security
                $sql = "UPDATE bookings SET start_date = ?, end_date = ?, starttime = ?, endtime = ? WHERE booking_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $start_date, $end_date, $startTime, $endTime, $id);

                if ($stmt->execute()) {
                    $result = [
                        'message' => 'Adjustment done successfully.',
                        'status' => 200, // OK
                    ];
                    echo json_encode($result);
                } else {
                    $result = [
                        'message' => 'Adjustment failed.',
                        'status' => 404, // Internal Server Error
                    ];
                    echo json_encode($result);
                }

                $stmt->close();
            }
        }
    }

    // Close your database connection
    $conn->close();
}
?>