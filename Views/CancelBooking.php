<?php
session_start();
require_once '../../private/Config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the booking ID from the URL
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Set the status to 'canceled'
    $status = 'canceled';

    // Update the booking status to "canceled"
    $query = "UPDATE booking SET status = :status WHERE booking_id = :booking_id AND user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);  // Binding status as a string
    $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        // 👉 Insert cancellation into the cancellation table with default refund_status as 'pending'
        $insertCancel = "INSERT INTO cancellation (booking_id, user_id, refund_status) 
                         VALUES (:booking_id, :user_id, :refund_status)";
        $cancelStmt = $conn->prepare($insertCancel);
        $cancelStmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $cancelStmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $refund_status = 'pending';
        $cancelStmt->bindParam(':refund_status', $refund_status, PDO::PARAM_STR);
        $cancelStmt->execute();

        // Set a session message for success
        $_SESSION['cancel_success'] = "Your booking has been cancelled successfully.";
        // Redirect to the dashboard after cancellation
        header("Location: UserDashboard.php");
        exit();
    } else {
        echo "Error canceling booking.";
    }
} else {
    die("Error: No booking ID provided.");
}
?>
