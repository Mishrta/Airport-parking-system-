<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    //  Not an admin? Redirect to admin login page
    header('Location: Adminlogin.php');
    exit();
}

require_once '../../../private/Config/database.php'; //database connection

if (isset($_GET['id'])) {
    $slot_id = $_GET['id']; // Get the slot ID to delete

    // Prepare the DELETE query
    $query = "DELETE FROM parking_space WHERE slot_id = :slot_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':slot_id', $slot_id, PDO::PARAM_INT);

    // Execute the DELETE query
    if ($stmt->execute()) {
        // Successfully deleted — redirect to list
        header('Location: ParkingSpace.php');
        exit();
    } else {
        echo "Error: Could not delete the parking space.";
    }
} else {
    //  If no ID in the URL, redirect back to parking space
    header('Location: ParkingSpace.php');
    exit();
}
?>
