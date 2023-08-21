<?php

require_once "../../../conn.php";

if (isset($_GET['id'])) {
    $hallId = $_GET['id'];
    
    // Fetch data from the database based on the hall ID
    $sql = "SELECT hallPrice FROM halls WHERE hall_id = '$hallId'";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $price = $row['hallPrice'];
        
        // Create a JSON object to send back
        $jsonData = [
            'hallPrice' => $price
        ];
        
        // Send JSON data back to the frontend
        header('Content-Type: application/json');
        echo json_encode($jsonData);
    } else {
        $jsonData = [
            'message' => 'Hall Price Not Found.',
            'status' => 404
        ];
        
        // Send JSON data back to the frontend
        header('Content-Type: application/json');
        echo json_encode($jsonData);
    }
} else {
    $jsonData = [
        'message' => 'Hall ID Not Provided.',
        'status' => 400
    ];
    
    // Send JSON data back to the frontend
    header('Content-Type: application/json');
    echo json_encode($jsonData);
}

mysqli_close($conn);

?>
