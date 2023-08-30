<?php
session_start();
require_once "../../../conn.php";
require_once "../../../apis/functions.php";

// Get data from POST
$hallId = trim($_POST['hid']);
$bookId = trim($_POST['bid']);
$startDate = trim($_POST['startDate']);
$endDate = trim($_POST['endDate']);
$starttime = trim($_POST['starttime']);
$endtime = trim($_POST['endtime']);
$attendee = trim($_POST['attend']);
$upfront = trim($_POST['upfront']);
$rate = 0; // Initialize rate (this seems to be a placeholder, you might need to set the actual rate value)
$bookStatus = 0; // Corrected variable name (was missing the $ sign)
$bookingType = 0; // Initialize booking type (this seems to be a placeholder)
$selectedFacilities = isset($_POST['facility_id']) ? $_POST['facility_id'] : [];
$food = $_POST['food'];
$credit = $upfront;

$date = date("y-m-d");
// Check if the customer ID is set in the session
if (!isset($_SESSION['email'])) {
    $result = [
        'message' => 'Email Not Found.',
        'status' => 404
    ];
    echo json_encode($result);
    exit;
}

$email = $_SESSION['email'];
$CustomerEmailQuery = "SELECT * FROM customers WHERE email='$email'";
$getCustomer = mysqli_query($conn, $CustomerEmailQuery);

if (!$getCustomer || mysqli_num_rows($getCustomer) === 0) {
    $result = [
        'message' => 'Customer ID Not Found.',
        'status' => 404
    ];
    echo json_encode($result);
    exit;
}

$data = mysqli_fetch_assoc($getCustomer);
$customerId = $data['custid'];

// Now check if a record exists based on datetime and customerId
$checkOverlapQuery = "SELECT * FROM bookings 
WHERE hall_id = '$hallId' 
AND start_date = '$startDate' 
AND end_date = '$endDate' 
AND starttime = '$starttime' 
AND endtime = '$endtime'";
$checkRecord = mysqli_query($conn, $checkOverlapQuery);

if (!$checkRecord) {
    $result = [
        'message' => 'Database error: ' . mysqli_error($conn),
        'status' => 404
    ];
    echo json_encode($result);
    exit;
} else if (mysqli_num_rows($checkRecord) > 0) {
    $result = [
        'message' => 'Overlapping booking found.',
        'status' => 404
    ];
    echo json_encode($result);
    exit;
}

// Function to handle facilities checkboxes
function handleFacilities(&$selectedFacilities) {
    if (isset($_POST['facility_id'])) {
        $selectedCheckboxes = $_POST['facility_id'];
        // Process the selected checkboxes as needed
        foreach ($selectedCheckboxes as $checkboxValue) {
            // Perform further processing or database operations
            array_push($selectedFacilities, $checkboxValue);
        }
    } else {
        echo "No checkboxes selected.";
    }
}

// Start transaction
mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

try {
    // Ensure required fields are not empty
    if (empty($bookId)) {
        // Insert into bookings table
        $sql = "INSERT INTO bookings (hall_id, customer_id, start_date, end_date, starttime, endtime, booking_status, bookingType, attendee, rate, created_at, foodid)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssssssss", $hallId, $customerId, $startDate, $endDate, $starttime, $endtime, $bookStatus, $bookingType, $attendee, $rate, $date, $food);
        mysqli_stmt_execute($stmt);
        $lastInsertedID = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);

        // Insert selected facilities into booking_facility table
        foreach ($selectedFacilities as $facility_id) {
            $sql = "INSERT INTO booking_facility (booking_id, facility_id, date) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $lastInsertedID, $facility_id, $date);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        handleFacilities($selectedFacilities);

        // Calculate debit amount
        if ($food == null && empty($food)) {
            $duration = calculateTimeDuration($starttime, $endtime);
            $newRate = getHallPrice($conn, $hallId);
            $totalFacilityPrice = calculateFacilityPrice($selectedFacilities, $conn);
            $debit = calculateDebit($newRate, $duration);
            $totalDebit = $debit + $totalFacilityPrice;
            $sql = "UPDATE bookings SET Rate = ?, bookingType = '1' WHERE booking_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $newRate, $lastInsertedID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            $rate = getFoodprice($conn, $food);
            $debit = calculateDebit($rate, $attendee);
            $totalFacilityPrice = calculateFacilityPrice($selectedFacilities, $conn);
            $totalDebit = $debit + $totalFacilityPrice;
            $sql = "UPDATE bookings SET Rate = ?, bookingType = '0' WHERE booking_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $rate, $lastInsertedID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        $booking = 'CustBooking';
        // Insert into transactions table
        $transactionSql = "INSERT INTO transactions (refID, tranType, custid, credit, transactionDate, debit) 
                           VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $transactionSql);
        mysqli_stmt_bind_param($stmt, "ssssss", $lastInsertedID, $booking, $customerId, $credit, $date, $totalDebit);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Commit the transaction
        mysqli_commit($conn);

        $result = [
            'message' => 'Booking created successfully.',
            'status' => 200,
            'id' => $customerId 
        ];
        echo json_encode($result);
    } else {
        // Update bookings table
        $sql = "UPDATE bookings
                SET hall_id = ?, customer_id = ?, start_date = ?, end_date = ?, starttime = ?, endtime = ?, booking_status = ?, 
                bookingType = ?, attendee = ?, Rate = ?, created_at = ?, foodid = ?
                WHERE booking_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssssssss", $hallId, $customerId, $startDate, $endDate, $starttime, $endtime, $bookStatus, $bookingType, $attendee, $rate, $date, $food, $bookId);
        $query = mysqli_stmt_execute($stmt);

        if ($query) {
            // Delete existing facilities associated with the booking
            $deleteFacilitiesSql = "DELETE FROM booking_facility WHERE booking_id = ?";
            $stmt = mysqli_prepare($conn, $deleteFacilitiesSql);
            mysqli_stmt_bind_param($stmt, "s", $bookId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Insert selected facilities into booking_facility table
            foreach ($selectedFacilities as $facility_id) {
                $sql = "INSERT INTO booking_facility (booking_id, facility_id, date) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sss", $bookId, $facility_id, $date);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }

            handleFacilities($selectedFacilities);

            // Calculate debit amount and update Rate
            if ($food == null && empty($food)) {
                $duration = calculateTimeDuration($starttime, $endtime);
                $newRate = getHallPrice($conn, $hallId);
                $totalFacilityPrice = calculateFacilityPrice($selectedFacilities, $conn);
                $debit = calculateDebit($newRate, $duration);
                $totalDebit = $debit + $totalFacilityPrice;
                $sql = "UPDATE bookings SET Rate = ?, bookingType = '1' WHERE booking_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $newRate, $bookId);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else {
                $rate = getFoodprice($conn, $food);
                $debit = calculateDebit($rate, $attendee);
                $totalFacilityPrice = calculateFacilityPrice($selectedFacilities, $conn);
                $totalDebit = $debit + $totalFacilityPrice;
                $sql = "UPDATE bookings SET Rate = ?, bookingType = '0' WHERE booking_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $rate, $bookId);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }

            // Insert into transactions table
            $transactionSql = "INSERT INTO transactions (refID, tranType, custid, credit, transactionDate, debit) 
                               VALUES (?, ?, ?, ?, ?, ?)";
                               
            $stmt = mysqli_prepare($conn, $transactionSql);
            mysqli_stmt_bind_param($stmt, "ssssss", $bookId, $booking, $customerId, $credit, $date, $totalDebit);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Commit the transaction
            mysqli_commit($conn);

            $result = [
                'message' => 'Booking updated successfully.',
                'status' => 200
            ];
            echo json_encode($result);
        } else {
            throw new Exception("Failed to update booking.");
        }
    }
} catch (Exception $e) {
    // Rollback the transaction in case of any error
    mysqli_rollback($conn);
    $result = [
        'message' => $e->getMessage(),
        'status' => 404
    ];
    echo json_encode($result);
}
?>