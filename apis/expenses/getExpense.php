<?php
require_once "../../conn.php";
require_once "../functions.php";


if (isset($_POST['expense_id'])) {
    $id = $_POST['expense_id'];
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM expenses WHERE expenseid = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $foodData = [
            'expid' => $row['expenseid'],
            'type' => $row['type'],
            'desc' => $row['description'],
            'amount' => $row['amount'],
        ];
        echo json_encode($foodData);
    } else {
        echo json_encode(['error' => 'Food not found']);
    }
}



