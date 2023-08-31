<?php
require '../../conn.php';
require '../functions.php';

$response = [
    'status' => 'error',
    'message' => 'Failed to delete the item.'
];

if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];

    // Get the image path of the hall to be deleted
    $imagePath = getImagePath($itemId, $conn);

    $success = deleteItemFromDatabase($itemId, $conn);
    if ($success) {
        // Delete the associated image file
        if (!empty($imagePath)) {
            unlink($imagePath);
        }

        $response = [
            'status' => 'success',
            'message' => 'Item deleted successfully.'
        ];
    }
}

// Output JSON response
echo json_encode($response);

// Function to get the image path of the hall
function getImagePath($itemId, $conn)
{
    $sql = "SELECT hall_photo FROM halls WHERE hall_id = '$itemId'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['hall_photo'];
    }
    return null;
}

// Function to delete the item from the database
function deleteItemFromDatabase($itemId, $conn)
{
    $sql = "DELETE FROM halls WHERE hall_id = '$itemId'";
    $query = mysqli_query($conn, $sql);
    return $query;
}
?>