<?php
session_start();
require_once '../../private/Config/database.php'; // database connection

// Check if the required GET parameters are set
if (!isset($_GET['airport'], $_GET['car_park'], $_GET['parking_type'])) {
    die("Error: Missing required parameters.");
}

// Get user selections from the URL
$airport = $_GET['airport'];
$car_park = $_GET['car_park'];
$parking_type = $_GET['parking_type'];

// Fetch the location_id based on the selected airport
$sql_location = "SELECT location_id FROM location WHERE parking_name = :airport";
$stmt_location = $conn->prepare($sql_location);
$stmt_location->bindParam(':airport', $airport, PDO::PARAM_STR);
$stmt_location->execute();
$location = $stmt_location->fetch(PDO::FETCH_ASSOC);

if (!$location) {
    die("Error: Airport not found.");
}

$location_id = $location['location_id'];  // Get the location_id from the airport

// Fetch the parking_type_id based on the selected parking type
$sql_parking_type = "SELECT type_id FROM parking_type WHERE type_name = :parking_type";
$stmt_parking_type = $conn->prepare($sql_parking_type);
$stmt_parking_type->bindParam(':parking_type', $parking_type, PDO::PARAM_STR);
$stmt_parking_type->execute();
$parking_type_id = $stmt_parking_type->fetchColumn();

if (!$parking_type_id) {
    die("Error: Invalid parking type selected.");
}

// Fetch available parking spaces for the selected airport, car park, and parking type
$sql = "SELECT ps.slot_id, ps.car_park, ps.status, ps.amount, ps.parking_type_id
        FROM parking_space ps
        WHERE ps.status = 'available'
        AND ps.location_id = :location_id
        AND ps.car_park = :car_park
        AND ps.parking_type_id = :parking_type_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':location_id', $location_id, PDO::PARAM_INT);
$stmt->bindParam(':car_park', $car_park, PDO::PARAM_STR);
$stmt->bindParam(':parking_type_id', $parking_type_id, PDO::PARAM_INT);
$stmt->execute();
$parking_space = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch airport name and address for display
$sql_airport = "SELECT * FROM location WHERE location_id = :location_id";
$stmt_airport = $conn->prepare($sql_airport);
$stmt_airport->bindParam(':location_id', $location_id, PDO::PARAM_INT);
$stmt_airport->execute();
$airport_info = $stmt_airport->fetch(PDO::FETCH_ASSOC);

// Handle case where no slots are available
if (!$parking_space) {
    die("No available parking spaces for the selected options.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Parking Slot</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../public/Assets/css/parkingSelection.css"> <!-- Link your style sheet -->
</head>
<body>

<!-- Back Button -->
<div class="back-btn-container">
    <a href="booking.php" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<!-- Title Section -->
<div class="title-section">
    <h2>Select Your Parking Slot at <?php echo $airport_info['parking_name']; ?> (<?php echo $airport_info['address']; ?>)</h2>
</div

        <!-- Form Section -->
<form action="SaveParkingSlot.php" method="POST">
    <div class="parking-slots">
        <?php foreach ($parking_space as $slot): ?>
            <div class="parking-slot">
                <input type="radio" id="slot-<?php echo $slot['slot_id']; ?>" name="slot_id" value="<?php echo $slot['slot_id']; ?>" required>
                <label for="slot-<?php echo $slot['slot_id']; ?>"
                       data-slot-id="<?php echo $slot['slot_id']; ?>"
                       data-price="<?php echo $slot['amount']; ?>"
                       data-car-park="<?php echo $slot['car_park']; ?>">

                    <div class="slot-number">Slot #<?php echo $slot['slot_id']; ?></div>
                    <div class="price">£<?php echo $slot['amount']; ?>/hr</div>
                    <div class="parking-info">Available in: <?php echo $slot['car_park']; ?></div>
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Right Panel with JS-updated details -->
    <div class="right-panel">
        <h3 style="text-align:center;">Parking Details</h3>
        <div class="clock-icon">
            <svg fill="black" viewBox="0 0 512 512"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111..."/></svg>
        </div>
        <div class="select-text">Select a parking slot to view details</div>

        <div class="details-row"><span class="details-label">Slot:</span><span id="detail-slot" class="details-value">-</span></div>
        <div class="details-row"><span class="details-label">Price/hour:</span><span id="detail-price" class="details-value">-</span></div>
        <div class="details-row"><span class="details-label">Total:</span><span id="detail-total" class="details-value">-</span></div>

        <button type="submit"> Confirm Parking</button>
    </div>

    <!-- Hidden inputs -->
    <input type="hidden" name="airport" value="<?php echo $airport; ?>">
    <input type="hidden" name="car_park" value="<?php echo $car_park; ?>">
    <input type="hidden" name="parking_type" value="<?php echo $parking_type; ?>">
    <input type="hidden" name="from_date" value="<?php echo $_GET['from_date']; ?>">
    <input type="hidden" name="to_date" value="<?php echo $_GET['to_date']; ?>">

</form>


<script src="../../public/Assets/js/parkingslot.js"></script>

</body>
</html>
