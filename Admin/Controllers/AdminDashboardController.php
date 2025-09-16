<?php
// In AdminDashboardController.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If the user is not logged in as admin, redirect to the login page
    header('Location: Adminlogin.php');
    exit();
}

require_once '../../../private/Config/database.php';



// Add Booking
if (isset($_POST['add_booking'])) {
    $user_id = $_POST['user_id'];
    $airport = $_POST['airport'];
    $car_park = $_POST['car_park'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    $query_add_booking = "INSERT INTO booking (user_id, airport, car_park, from_date, to_date) VALUES (:user_id, :airport, :car_park, :from_date, :to_date)";
    $stmt_add_booking = $conn->prepare($query_add_booking);
    $stmt_add_booking->bindParam(':user_id', $user_id);
    $stmt_add_booking->bindParam(':airport', $airport);
    $stmt_add_booking->bindParam(':car_park', $car_park);
    $stmt_add_booking->bindParam(':from_date', $from_date);
    $stmt_add_booking->bindParam(':to_date', $to_date);

    $stmt_add_booking->execute();
}

// Edit Booking
if (isset($_POST['edit_booking'])) {
    $booking_id = $_POST['booking_id'];
    $user_id = $_POST['user_id'];
    $airport = $_POST['airport'];
    $car_park = $_POST['car_park'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    $query_edit_booking = "UPDATE booking SET user_id = :user_id, airport = :airport, car_park = :car_park, from_date = :from_date, to_date = :to_date WHERE booking_id = :booking_id";
    $stmt_edit_booking = $conn->prepare($query_edit_booking);
    $stmt_edit_booking->bindParam(':booking_id', $booking_id);
    $stmt_edit_booking->bindParam(':user_id', $user_id);
    $stmt_edit_booking->bindParam(':airport', $airport);
    $stmt_edit_booking->bindParam(':car_park', $car_park);
    $stmt_edit_booking->bindParam(':from_date', $from_date);
    $stmt_edit_booking->bindParam(':to_date', $to_date);

    $stmt_edit_booking->execute();
}

// Delete Booking
if (isset($_GET['delete_booking'])) {
    $booking_id = $_GET['delete_booking'];

    $query_delete_booking = "DELETE FROM booking WHERE booking_id = :booking_id";
    $stmt_delete_booking = $conn->prepare($query_delete_booking);
    $stmt_delete_booking->bindParam(':booking_id', $booking_id);
    $stmt_delete_booking->execute();
}



// Fetch Dashboard data
$query_bookings = "SELECT COUNT(*) as total_bookings FROM booking";
$stmt_bookings = $conn->prepare($query_bookings);
$stmt_bookings->execute();
$total_bookings = $stmt_bookings->fetchColumn();

$query_parking = "SELECT COUNT(*) as total_parking FROM parking_space";
$stmt_parking = $conn->prepare($query_parking);
$stmt_parking->execute();
$total_parking = $stmt_parking->fetchColumn();

$query_vehicles = "SELECT COUNT(*) as total_vehicles FROM payment";  // Replace with the appropriate query
$stmt_vehicles = $conn->prepare($query_vehicles);
$stmt_vehicles->execute();
$total_vehicles = $stmt_vehicles->fetchColumn();

$query_locations = "SELECT COUNT(*) as total_location FROM location";  // Replace with the appropriate query for locations
$stmt_locations = $conn->prepare($query_locations);
$stmt_locations->execute();
$total_location = $stmt_locations->fetchColumn();

// Fetch customers
$query_customers = "SELECT * FROM users";
$stmt_customers = $conn->prepare($query_customers);
$stmt_customers->execute();
$customers = $stmt_customers->fetchAll(PDO::FETCH_ASSOC);

// Fetch parking spaces
$query_parking_spaces = "SELECT * FROM parking_space";
$stmt_parking_spaces = $conn->prepare($query_parking_spaces);
$stmt_parking_spaces->execute();
$parking_spaces = $stmt_parking_spaces->fetchAll(PDO::FETCH_ASSOC);

// Fetch bookings
$query_bookings = "SELECT * FROM booking";
$stmt_bookings = $conn->prepare($query_bookings);
$stmt_bookings->execute();
$bookings = $stmt_bookings->fetchAll(PDO::FETCH_ASSOC);


?>
