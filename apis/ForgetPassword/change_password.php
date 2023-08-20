<?php
require '../../conn.php'; // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the new password from the POST data
    $email = $_POST['email'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    if ($newPassword != $confirmPassword) {
        echo 'Passwords do not match.';
        exit;
    }
    
    // Hash the new password before storing it (you should use a strong hashing mechanism)
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the user's password in the database
    try {
        // Assuming your conn.php provides a $conn object for database connection
        // $userId = $_SESSION['user_id']; // Replace with the actual user's ID
        
        $call = $conn->prepare('CALL chaneUserPassword(?, ?)');
        
        // Check if the prepare statement succeeded
        if (!$call) {
            throw new Exception($conn->error);
        }

        $call->bind_param('ss', $newPassword, $email);
        $call->execute();
        echo "Password updated successfully";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method";
}
?>