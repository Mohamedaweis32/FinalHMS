<?php
include 'conn.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['companyId'])) {
    $companyId = $_POST['companyId'];
    $companyId = mysqli_real_escape_string($conn, $companyId);

    $sql = "SELECT `CompanyName`, `Address`, `Phone`, `Email`, `Description`, `Logo` FROM `company` WHERE `CompanyID` = '$companyId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        $companyData = [
            'CompanyName' => $row['CompanyName'],
            'Address' => $row['Address'],
            'Phone' => $row['Phone'],
            'Email' => $row['Email'],
            'Description' => $row['Description'],
            'Logo' => $row['Logo']
        ];
        echo json_encode($companyData);
    } else {
        echo json_encode(['error' => 'Company not found']);
    }

    mysqli_close($conn);
}
?>
