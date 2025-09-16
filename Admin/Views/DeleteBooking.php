<?php
// Start session and check if the user is an admin
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If the user is not logged in as admin, redirect to login
    header('Location: Adminlogin.php');
    exit();
}

// database connection
require_once '../../../private/Config/database.php';

// Check if the booking ID is passed
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Prepare the DELETE query
    $query = "DELETE FROM booking WHERE booking_id = :booking_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);

    // Execute the DELETE query
    if ($stmt->execute()) {
        // Redirect to the dashboard after successful deletion
        header('Location: Dashboard.php');
        exit();
    } else {
        // If something went wrong, display an error
        echo "Error: Could not delete the booking.";
    }
} else {
    // If no booking ID is passed, show an error message
    echo "Error: No booking ID provided.";
}
?>
