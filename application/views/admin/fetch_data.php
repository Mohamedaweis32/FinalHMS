<?php
// Include your database connection file
include '../../../conn.php';

// Get the table name and column name from the request
$tableName = $_GET['table'];
$columnName = $_GET['column'];

// Prepare the SQL query based on the table name and column name
$sql = "SELECT SUM(COALESCE(debit, 0) - COALESCE(credit, 0)) as total FROM transactions ;";

// Perform the database query
$result = $conn->query($sql);

// Check if the query was successful
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $value = $row['total'];
} else {
    $value = 0;
}

// Close the database connection
$conn->close();

// Return the value as JSON response
echo json_encode(['total' => $value]);
?>
