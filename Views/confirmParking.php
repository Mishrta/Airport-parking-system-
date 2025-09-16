<?php
session_start();
require_once '../../private/Config/database.php'; // database connection

// Get selected slot ID from the previous page
if (!isset($_POST['slot_id'])) {
    echo "No parking slot selected!";
    exit();
}

$slot_id = $_POST['slot_id'];

// Fetch details for the selected parking slot
$sql = "SELECT ps.slot_id, ps.price_per_hour, ps.car_park, l.parking_name FROM parking_space ps
        JOIN location l ON ps.location_id = l.location_id
        WHERE ps.slot_id = :slot_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':slot_id', $slot_id, PDO::PARAM_INT);
$stmt->execute();
$slot = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission for user details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user details from the form
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Redirect to the payment page
    header('Location: Payment.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Parking</title>
</head>
<body>
<h2>Confirm Your Parking Selection</h2>
<p>You have selected the following slot:</p>
<p>Car Park: <?php echo $slot['car_park']; ?>, Airport: <?php echo $slot['parking_name']; ?></p>
<p>Price: £<?php echo $slot['price_per_hour']; ?>/hour</p>

<h3>Please enter your details:</h3>
<form method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" required><br><br>
    <label for="email">Email:</label>
    <input type="email" name="email" required><br><br>

    <button type="submit">Proceed to Payment</button>
</form>
</body>
</html>
