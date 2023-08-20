<?php
require '../../conn.php';
require '../functions.php';

if (isset($_POST['bid'])) {
    $id = $_POST['bid'];
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT f.foodType as ftype,f.foodId as fid, b.bookingType AS btype, b.starttime AS tfrom,
            b.endtime AS tto, b.booking_id AS id, DATE(b.created_at) AS bdate, c.firstname AS cname, 
            b.booking_status AS STATUS, h.hall_type AS htype, b.hall_id as hid,
            b.start_date AS sdate, b.end_date AS edate, b.attendee AS attend, b.customer_id as cid,
            GROUP_CONCAT(bf.facility_id) AS facilities
        FROM hbs.bookings b 
        LEFT JOIN hbs.transactions tr ON b.booking_id = tr.refID
        LEFT JOIN hbs.customers c ON c.custid = tr.custid
        LEFT JOIN hbs.halls h ON h.hall_id = b.hall_id
        LEFT JOIN hbs.food f ON f.foodId = b.foodId
        LEFT JOIN hbs.booking_facility bf ON bf.booking_id = b.booking_id
        WHERE b.booking_id = '$id'
        GROUP BY b.booking_id";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $bdata = [
            'cname' => $row['cid'],
            'id' => $row['id'],
            'status' => $row['STATUS'],
            'hall_id' => $row['hid'],
            'sdate' => $row['sdate'],
            'edate' => $row['edate'],
            'starttime' => $row['tfrom'],
            'endtime' => $row['tto'],
            'attend' => $row['attend'],
            'date' => $row['bdate'],
            'food' => $row['fid'],
            'facilities' => []  // Initialize an array to store facilities
        ];

        // Extract facility IDs from the concatenated string and store them in the 'facilities' array
        if (!empty($row['facilities'])) {
            $facilityIds = explode(',', $row['facilities']);
            $bdata['facilities'] = $facilityIds;
        }

        echo json_encode($bdata);
    } else {
        echo json_encode(['error' => 'Booking Not found']);
    }
}
?>
