<?php
session_start();
require_once '../../private/Config/database.php'; //database connection

// Check if user is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest_email'])) {
    die("Error: User is not logged in.");
}

// Get the booking ID from the URL
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Fetch the booking and parking space details from the database
    $query = "SELECT b.booking_id, b.slot_id, ps.amount
              FROM booking b
              JOIN parking_space ps ON b.slot_id = ps.slot_id
              WHERE b.booking_id = :booking_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the booking data
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the booking exists and retrieve amount from parking_space
    if ($booking) {
        $amount = $booking['amount']; // Retrieve the amount from parking_space
    } else {
        die("Error: Booking not found.");
    }
} else {
    die("Error: No booking ID provided.");
}


// Fetch the user's name if logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query_user = "SELECT name FROM users WHERE user_id = :user_id";
    $stmt_user = $conn->prepare($query_user);
    $stmt_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $name = $user['name']; // Store the user's name
    } else {
        $name = ''; // If the user name isn't found, set it as an empty string
    }
} else {
    $name = ''; // If user isn't logged in, set name to empty string
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../public/Assets/css/payment.css">
    <!-- Add a Google font similar to the design -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="payment-container">
    <div class="payment-header">
        <div class="brand-logo">
            <!-- Replace with your logo or keep it simple -->
            <h2>AirportParking</h2>
        </div>

    <form action="../Controllers/PaymentController.php" method="POST" class="payment-form">
        <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">

        <!-- Payment tabs -->
        <div class="payment-tabs">
            <div class="payment-tab active">Credit Card</div>
            <div class="payment-tab ">PayPal</div>
        </div>

        <!-- Card icons -->
        <div class="card-icons">
            <img src="../../public/Assets/images/visa.png" alt="Visa" />
            <img src="../../public/Assets/images/Mastercard.png" alt="Mastercard" />
            <img src="../../public/Assets/images/paypal.png" alt="Discover" />
        </div>

        <!-- Card details -->
        <div class="input-group">
            <label for="card_name">Name</label>
            <input type="text" name="card_name" value="<?php echo $name; ?>" required>
        </div>

        <div class="input-group">
            <label for="card_number">Card Number</label>
            <input type="text" name="card_number" required placeholder="1234 5678 9101 1121" maxlength="16">
        </div>

        <div class="expiry-cvv-row">
            <div class="input-group">
                <label for="expiry_date">Exp Date</label>
                <input type="text" name="expiry_date" required placeholder="MM/YY" maxlength="5">
            </div>

            <div class="input-group">
                <label for="cvv">CVV</label>
                <input type="text" name="cvv" required placeholder="123" maxlength="3">
            </div>
        </div>

        <div class="input-group">
            <label for="vehicle_number">Vehicle Number</label>
            <input type="text" name="vehicle_number" required>
        </div>

        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : $_SESSION['guest_email']; ?>" readonly required>
        </div>

        <!-- Payment amount hidden from form, but displayed in order summary -->
        <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>" required>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3>Order Summary</h3>
            <div class="summary-item">
                <span>Subtotal</span>
                <span>£<?php echo $amount; ?></span>
            </div>
            <div class="summary-item">
                <span>Tax</span>
                <span>£0.00</span>
            </div>
            <div class="summary-total">
                <span>Total</span>
                <span>£<?php echo $amount; ?></span>
            </div>
        </div>

        <div class="buttons-row">
            <button type="button" class="back-button" onclick="history.back()">
                <i class="fas fa-arrow-left"></i> Back
            <button type="submit" name="pay_now" class="pay-button">
                <i class="fas fa-lock"></i> Continue
            </button>
        </div>
    </form>
</div>

<script src="../../public/Assets/js/paymentvalidation.js"></script>

</body>
</html>

