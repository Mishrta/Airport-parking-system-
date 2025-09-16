<?php
session_start();
require_once '../../private/Config/database.php'; // database connection

// Get the selected parking slot
$slot_id = $_POST['slot_id'];  // Selected parking slot
$airport = $_POST['airport'];  // Selected airport
$car_park = $_POST['car_park'];  // Selected car park
$parking_type = $_POST['parking_type'];  // Selected parking type
$from_date = $_POST['from_date'];  // Parking from date
$to_date = $_POST['to_date'];  // Parking to date

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // If no user is logged in, we can handle the error or redirect
    die("Error: User is not logged in.");
}

// Fetch the type_id based on parking_type
$sql_parking_type = "SELECT type_id FROM parking_type WHERE type_name = :parking_type";
$stmt_parking_type = $conn->prepare($sql_parking_type);
$stmt_parking_type->bindParam(':parking_type', $parking_type, PDO::PARAM_STR);
$stmt_parking_type->execute();
$type_id = $stmt_parking_type->fetchColumn();

if (!$type_id) {
    die("Error: Invalid parking type selected.");
}

// Insert booking into the database
$sql = "INSERT INTO booking (user_id, airport, car_park, type_id, slot_id, from_date, to_date, status) 
        VALUES (:user_id, :airport, :car_park, :type_id, :slot_id, :from_date, :to_date, 'pending')";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':airport', $airport);
$stmt->bindParam(':car_park', $car_park);
$stmt->bindParam(':type_id', $type_id);  // Bind the fetched type_id
$stmt->bindParam(':slot_id', $slot_id);
$stmt->bindParam(':from_date', $from_date);
$stmt->bindParam(':to_date', $to_date);

// Execute the query and check if it was successful
if ($stmt->execute()) {
    // Get the last inserted booking_id
    $booking_id = $conn->lastInsertId();

    //  Update the selected parking slot to 'booked'
    $updateSlot = "UPDATE parking_space SET status = 'booked' WHERE slot_id = :slot_id";
    $updateStmt = $conn->prepare($updateSlot);
    $updateStmt->bindParam(':slot_id', $slot_id);
    $updateStmt->execute();


    // After successful booking, redirect to the payment page or confirmation page
    header('Location: ../../private/Views/Payment.php?booking_id=' . $booking_id); // Redirect to payment page with booking_id
    exit();
} else {
    echo "Error saving booking. Please try again.";
}

?>
