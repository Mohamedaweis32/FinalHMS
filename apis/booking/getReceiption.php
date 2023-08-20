<?php
require '../../conn.php';
require '../functions.php';


if (isset($_POST['rid'])) {
    $id = $_POST['rid'];
    $id = mysqli_real_escape_string($conn, $id);

$sql="SELECT c.firstname as name , SUM(tr.debit - tr.credit) AS balance,b.booking_id as id FROM hbs.bookings b 
LEFT JOIN hbs.transactions tr ON b.booking_id = tr.refID 
LEFT JOIN hbs.customers c ON c.custid = tr.custid WHERE b.booking_id ='$id' ";
 
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $bdata = [
           'cname'  =>$row['name'],
            'balance'  => $row['balance'],
            'bid'  => $row['id'],
            
        ];
        echo json_encode($bdata);
    } else {
        echo json_encode(['error' => 'Booking Not found']);
    }
}