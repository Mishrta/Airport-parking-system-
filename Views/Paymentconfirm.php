<?php
session_start();
require_once '../../private/Config/database.php'; //connect to the database
require_once '../../private/Models/PaymentModel.php'; //  Import the PaymentModel class to handle payment-related DB logic
require_once __DIR__ . '/../../vendor/autoload.php';   // Load PHPMailer via Composer (handles sending emails)

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in.");
}

// Get the booking ID from the URL
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    //  Create a PaymentModel instance and fetch payment details for this booking
    $paymentModel = new PaymentModel($conn);

    // Fetch payment details using the new method
    $payment_details = $paymentModel->getPaymentDetails($booking_id);

    if ($payment_details) {
        //  Extract details from the payment record
        $amount = $payment_details['amount'];
        $vehicle_number = $payment_details['vehicle_number'];
        $Email = $_SESSION['email'];// Get user email

        // Fetch booking details for reference number and location (additional details)
        $query = "SELECT b.booking_id, b.airport, b.car_park FROM booking b WHERE b.booking_id = :booking_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        $booking_details = $stmt->fetch(PDO::FETCH_ASSOC);

        $reference_number = $booking_details['booking_id'];
        $airport = $booking_details['airport'];
        $car_park = $booking_details['car_park'];

        // Send email to the user (using PHPMailer)
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to use
            $mail->SMTPAuth = true;
            $mail->Username = 'mishrtan@gmail.com';  // SMTP email
            $mail->Password = 'iuprtrgjmcnijyoo';  // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // ️ Email sender and receiver
            $mail->setFrom('mishrtan@gmail.com', 'Airport Parking System');
            $mail->addAddress($Email);  // Send to the logged-in user's email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Payment Confirmation for Your Booking';
            $mail->Body    = "
    <div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
        <div style='background-color: #ffffff; padding: 30px; border-radius: 10px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);'>
            <h1 style='color: #1e1f3d; text-align: center; font-size: 28px;'>Payment Confirmation</h1>
            <p style='color: #1e1f3d; text-align: center; font-size: 16px; margin-bottom: 20px;'>Thank you for booking with us!</p>
            
            <table style='width: 100%; border-spacing: 0; margin-bottom: 20px;'>
                <tr>
                    <td style='padding: 10px 0; font-size: 16px; color: #1e1f3d;'><strong>Your booking reference number:</strong></td>
                    <td style='padding: 10px 0; font-size: 16px; color: #1e1f3d;'>$reference_number</td>
                </tr>
                <tr>
                    <td style='padding: 10px 0; font-size: 16px; color: #1e1f3d;'><strong>Your parking location:</strong></td>
                    <td style='padding: 10px 0; font-size: 16px; color: #1e1f3d;'>$airport, $car_park</td>
                </tr>
                <tr>
                    <td style='padding: 10px 0; font-size: 16px; color: #1e1f3d;'><strong>Amount:</strong></td>
                    <td style='padding: 10px 0; font-size: 16px; color: #1e1f3d;'>£$amount</td>
                </tr>
                <tr>
                    <td style='padding: 10px 0; font-size: 16px; color: #1e1f3d;'><strong>Vehicle Number:</strong></td>
                    <td style='padding: 10px 0; font-size: 16px; color: #1e1f3d;'>$vehicle_number</td>
                </tr>
            </table>
            
            <p style='color: #8c292a; text-align: center; font-size: 16px;'>Thank you for choosing our parking services!</p>
            
            <div style='text-align: center; font-size: 14px; color: #888888; margin-top: 30px;'>
                <p style='margin-bottom: 10px;'>If you have any questions or need assistance, feel free to contact us.</p>
                <p style='margin-top: 10px;'>Best regards, <br> The Airport Parking Team</p>
            </div>
        </div>
    </div>
";
            // Send email
            $mail->send();
            $_SESSION['flash_message'] = "Confirmation email has been sent.";
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        die("Error: Payment details not found.");
    }
} else {
    die("Error: No booking ID provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <link rel="stylesheet" href="../../public/Assets/css/payment1.css">
</head>
<body>

<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="flash-msg"><?php echo $_SESSION['flash_message']; ?></div>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>

<div class="payment-container success">
    <!-- Decorative elements -->
    <div class="decoration decoration-1"></div>
    <div class="decoration decoration-2"></div>
    <div class="decoration decoration-3"></div>
    <div class="decoration decoration-4"></div>
    <div class="plus-decoration plus-1">+</div>
    <div class="plus-decoration plus-2">+</div>

    <!-- Status indicator -->
    <div class="status-indicator">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Payment Confirmation</h1>
    <div class="payment-details">
        <p><strong>Amount:</strong> £<?php echo $amount; ?></p>
        <p><strong>Vehicle Number:</strong> <?php echo $vehicle_number; ?></p>
        <p><strong>Reference Number:</strong> <?php echo $reference_number; ?></p>
        <p><strong>Parking Location:</strong> <?php echo $airport . ", " . $car_park; ?></p>
    </div>

    <button onclick="window.location.href='UserDashboard.php'">Go to Dashboard</button>
</div>

</body>
</html>
