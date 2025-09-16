<?php
session_start();
require_once '../../private/Config/database.php';
require_once '../../private/Models/PaymentModel.php';


//  Debug: Check if it's a logged-in user
if (isset($_SESSION['user_id'])) {
    echo "User ID is set: " . $_SESSION['user_id'];
} else {
    echo "No session data";
}

//  Check if the "Pay Now" button was clicked (form submitted)
if (isset($_POST['pay_now'])) {
    // Retrieve the payment details from the form
    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $vehicle_number = $_POST['vehicle_number'];
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $email = $_POST['email'];

    // Call the PaymentModel to process the payment (Use a payment gateway API)
    $paymentModel = new PaymentModel($conn);
    $payment_status = $paymentModel->processPayment($booking_id, $amount, $vehicle_number, $card_name, $card_number, $expiry_date, $cvv , $email);

    if ($payment_status) {
        // If payment is successful, update the booking status to "confirmed"
        $query_update_booking = "UPDATE booking SET status = 'confirmed' WHERE booking_id = :booking_id";
        $stmt_update_booking = $conn->prepare($query_update_booking);
        $stmt_update_booking->bindParam(':booking_id', $booking_id);
        $stmt_update_booking->execute();

        // Redirect to confirmation page
        header("Location: ../../private/Views/Paymentconfirm.php?booking_id=" . $booking_id);
        exit();
    } else {
        // Handle failed payment scenario
        echo "Error: Payment failed.";
    }
}
?>
