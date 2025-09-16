<?php
// editBooking.php
require_once '../../../private/Config/database.php'; //database connection

//  Check if a booking ID is provided in the URL via GET
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
//  Prepare SQL to fetch the booking
    $query = "SELECT * FROM booking WHERE booking_id = :booking_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':booking_id', $booking_id);
    $stmt->execute();
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/Assets/css/update.css">
    <title>Update Booking</title>
</head>
<body>
<div class="container">
    <h1 class="page-title">Edit Booking</h1>

    <div class="update-container">
        <form method="POST" action="Dashboard.php">
            <div class="form-group">
                <label for="user_id">User ID</label>
                <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($booking['user_id']); ?>" required>
            </div>

            <div class="form-group">
                <label for="airport">Airport</label>
                <input type="text" id="airport" name="airport" value="<?php echo htmlspecialchars($booking['airport']); ?>" required>
            </div>

            <div class="form-group">
                <label for="car_park">Car Park</label>
                <input type="text" id="car_park" name="car_park" value="<?php echo htmlspecialchars($booking['car_park']); ?>" required>
            </div>

            <div class="form-group">
                <label for="from_date">From Date</label>
                <input type="date" id="from_date" name="from_date" value="<?php echo htmlspecialchars($booking['from_date']); ?>" required>
            </div>

            <div class="form-group">
                <label for="to_date">To Date</label>
                <input type="date" id="to_date" name="to_date" value="<?php echo htmlspecialchars($booking['to_date']); ?>" required>
            </div>

            <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">

            <button type="submit" name="edit_booking">Update Booking</button>
        </form>
    </div>
</div>

