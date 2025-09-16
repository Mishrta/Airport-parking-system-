<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If the user is not logged in as admin, redirect to login
    header('Location: Adminlogin.php');
    exit();
}

require_once '../../../private/Config/database.php';

// Check if the user ID is passed
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare the DELETE query
    $query = "DELETE FROM users WHERE User_ID = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Execute the DELETE query
    if ($stmt->execute()) {
        // Redirect to the Customers page after successful deletion
        header('Location: Customers.php');
        exit();
    } else {
        // If something went wrong, display an error
        echo "Error: Could not delete the user.";
    }
} else {
    // If no user ID is found, redirect back to Customers page
    header('Location: Customers.php');
    exit();
}
?>
