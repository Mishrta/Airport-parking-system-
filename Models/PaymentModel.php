<?php
class PaymentModel {
    private $conn;

    // It automatically runs when you create an object from the class
    public function __construct($db) {
        $this->conn = $db;
    }

    public function processPayment($booking_id, $amount, $vehicle_number, $card_name, $card_number, $expiry_date, $cvv, $email) {
        // Placeholder for integrating a payment gateway (e.g., Stripe, PayPal)

        // Assume the payment is successful (this is just a placeholder)
        $query = "INSERT INTO payment (booking_id, amount, vehicle_number, status) 
                  VALUES (:booking_id, :amount, :vehicle_number, 'successful')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':vehicle_number', $vehicle_number);

        // Execute the statement and return success or failure
        return $stmt->execute();
    }

    //  fetch the payment details
    public function getPaymentDetails($booking_id) {
        $query = "SELECT * FROM payment WHERE booking_id = :booking_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
