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

    // Fetch current booking data to prefill the form
    $query = "SELECT * FROM booking WHERE booking_id = :booking_id AND user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();

    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking) {
        die("Error: Booking not found.");
    }
} else {
    die("Error: No booking ID provided.");
}

// ✅ Fetch airport options from the 'location' table
$airportQuery = "SELECT parking_name FROM location";
$airportStmt = $conn->prepare($airportQuery);
$airportStmt->execute();
$airports = $airportStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $airport = $_POST['airport'];
    $car_park = $_POST['car_park'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    // Update booking in the DB
    $update_query = "UPDATE booking SET airport = :airport, car_park = :car_park, from_date = :from_date, to_date = :to_date WHERE booking_id = :booking_id";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bindParam(':airport', $airport);
    $update_stmt->bindParam(':car_park', $car_park);
    $update_stmt->bindParam(':from_date', $from_date);
    $update_stmt->bindParam(':to_date', $to_date);
    $update_stmt->bindParam(':booking_id', $booking_id);

    if ($update_stmt->execute()) {
        $_SESSION['update_success'] = "Your booking has been updated successfully.";
        header("Location: ../Views/UserDashboard.php?updated=true");
        exit();
    } else {
        echo "Error updating booking.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/Assets/css/update.css">
    <title>Update Booking</title>
</head>
<body>

<div class="container">
    <h1 class="page-title">Update Booking</h1>

    <div class="update-container">
        <form action="UpdateBooking.php?booking_id=<?php echo $booking_id; ?>" method="POST">

            <!-- Airport dropdown from location table -->
            <label for="airport">Airport:</label>
            <select name="airport" required>
                <?php foreach ($airports as $airportOption): ?>
                    <option value="<?php echo $airportOption['parking_name']; ?>"
                        <?php if ($airportOption['parking_name'] === $booking['airport']) echo 'selected'; ?>>
                        <?php echo $airportOption['parking_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <!-- Static car park dropdown -->
            <label for="car_park">Car Park:</label>
            <select name="car_park" required>
                <option value="Car Park 1" <?php if ($booking['car_park'] === 'Car Park 1') echo 'selected'; ?>>Car Park 1</option>
                <option value="Car Park 2" <?php if ($booking['car_park'] === 'Car Park 2') echo 'selected'; ?>>Car Park 2</option>
                <option value="Car Park 3" <?php if ($booking['car_park'] === 'Car Park 3') echo 'selected'; ?>>Car Park 3</option>
            </select><br>

            <!-- Date pickers -->
            <label for="from_date">From Date:</label>
            <input type="date" name="from_date" value="<?php echo htmlspecialchars($booking['from_date']); ?>" required><br>

            <label for="to_date">To Date:</label>
            <input type="date" name="to_date" value="<?php echo htmlspecialchars($booking['to_date']); ?>" required><br>

            <button type="submit">Update Booking</button>
        </form>
    </div>
</div>

</body>
</html>
