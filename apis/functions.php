<?php

//require '../conn.php';
// Function to delete the item from the database
function allqueryHandler($conn, $sql)
{
    $query = mysqli_query($conn, $sql);
    if ($query) {
        return true;
    } else {
        return false;
    }
}

//check hall capacity
function getHallCapacity($conn, $hall_id)
{
    $sql = "select * from halls where hall_id='$hall_id'";
    $query = mysqli_query($conn, $sql);
    if ($result = mysqli_fetch_array($query)) {
        $capacity = $result['capacity'];
        return $capacity;
    }
    return 0;

}
function if_record_exists($conn, $sql)
{
    $query = mysqli_query($conn, $sql);
    if ($query && mysqli_num_rows($query)) {
        return true;
    }
    return false;

}

//calculate the debit 
function calculateDebit($rate, $attendee)
{
    if (empty($rate)) {
        return 0;
    } else if (empty($attendee)) {
        return 0;
    }
    $result = $rate * $attendee;
    return $result;
}
function calculateFacilityPrice($facilityIds, $conn)
{
    // Convert the array of facility IDs to a comma-separated string
    $facilityIdsString = implode(',', $facilityIds);

    // Query to get the sum of prices for the selected facilities
    $sql = "SELECT SUM(Price) AS total FROM facility WHERE facility_id IN ($facilityIdsString)";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $totalPrice = $row['total'];
        return $totalPrice;
    }

    return 0; // Return 0 if no facilities or prices found
}

function getHallPrice($conn, $hallId)
{
    $sql = "SELECT * FROM halls WHERE hall_id = '$hallId'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $result = mysqli_fetch_array($query);
        $hallPrice = $result['hallPrice'];
        if ($hallId <= 0) {
            return 0;

        } else {
            return $hallPrice;
        }
    } else {
        return 0;
    }

}

function getFoodprice($conn, $foodid)
{
    $sql = " SELECT * from food WHERE foodId = '$foodid'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $result = mysqli_fetch_array($query);
        $foodPrice = $result['foodPrice'];
        if ($foodPrice <= !0) {
            return $foodPrice;



        }
    } else {
        return 0;
    }

}




function calculateTimeDuration($startTime, $endTime)
{
    $start = strtotime($startTime);
    $end = strtotime($endTime);

    // Calculate the duration in seconds
    $duration = $end - $start;

    // Convert seconds to hours
    $durationInHours = $duration / 3600;

    return $durationInHours;
}

function getCustomerID($conn, $name)
{
    $sql = "SELECT * FROM customers WHERE firstname='$name'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $data = mysqli_fetch_array($query);
        $cid = $data['custid'];
        return $cid;
    } else {
        return 0;
    }
}
function getCustomerIdbasedonEmail($conn, $email)
{
    $sql = "SELECT * FROM customers WHERE email='$email'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $data = mysqli_fetch_assoc($query);
        $cid = $data['custid'];
        return $cid;
    } else {
        return 0;
    }
}
function isEmailValid($email)
{
    // Use PHP's filter_var function to check email validity
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isPasswordValid($password)
{
    // Define password criteria (e.g., at least 8 characters and at least one uppercase letter)
    $passwordCriteria = '/^(?=.*[A-Z]).{8,}$/';
    return preg_match($passwordCriteria, $password);
}

function isUserExists($username, $conn)
{
    // Assuming $conn is a MySQL database connection
    $username = mysqli_real_escape_string($conn, $username);
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

function isEmailRegistered($email, $conn)
{
    // Assuming $conn is a MySQL database connection
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}


// $starttime = "09:00";
// $endtime = "11:30";

// $duration = calculateTimeDuration($starttime, $endtime);
// echo "Duration: $duration hours";