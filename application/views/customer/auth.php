<?php
// auth.php

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header('Location: ../../../login.php');
    exit();
}

// Check user type
$userType = $_SESSION['type'];

// If user type is not 'admin', redirect to unauthorized page
if ($userType !== 'customer') {
    header('Location: unauthorized.php');
    exit();
}
?>
