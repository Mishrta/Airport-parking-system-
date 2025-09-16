<?php
$slot_id = $_GET['slot']; // The selected slot ID

// Assume you already have user info like user_id from the session or login
$user_id = $_SESSION['user_id'];

// Insert a new booking into the bookings table
// This links the user to a parking slot and an airport (location)
$sql = "INSERT INTO bookings (user_id, slot_id, location_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $slot_id, $airport_id);
$stmt->execute();

// Update available space in location table
$new_available_spaces = $available_spaces - 1;
//  Update the location's availability count after booking
$sql_update = "UPDATE location SET space_availabilities = ? WHERE location_id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("ii", $new_available_spaces, $airport_id);
$stmt_update->execute();

//  Confirmation message to the user
echo "Your booking is confirmed!";
?>
