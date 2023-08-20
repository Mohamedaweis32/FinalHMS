<?php


require '../../conn.php';
require '../functions.php';


if (isset($_POST['custid'])) {
    $id = $_POST['custid'];
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM customers WHERE custid= '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $hallData = [
            'cid' => $row['custid'],
            'cname' => $row['firstname'],
            'caddress' => $row['address'],
            'cphone' => $row['phone'],
            'cemail' => $row['email'],
            
        ];
        echo json_encode($hallData);
    } else {
        echo json_encode(['error' => 'Customer Not found']);
    }
}