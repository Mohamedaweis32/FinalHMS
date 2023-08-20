<?php
include_once("../../../conn.php");


    // Check if the view_status parameter is set in the request
    if (isset($_POST["view_status"])) {
        // Get the value of view_status (in this case, it's "1")
        $viewStatus = $_POST["view_status"];

        // Perform any necessary validation or sanitization on the $viewStatus here if needed

        // Update the view_status for bookings in the database
        $sql = "UPDATE bookings SET view_status = $viewStatus";
        $query=mysqli_query($conn,$sql);

        if ($query) {
            // Update successful
            http_response_code(200); // HTTP status code 200 indicates success
        } else {
            // Update failed
            http_response_code(404); // HTTP status code 500 indicates server error
        }
    } else {
        // view_status parameter not set in the request
        http_response_code(404); // HTTP status code 400 indicates bad request
    }