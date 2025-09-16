<?php
session_start();
require_once '../../../private/Config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cancel_id'], $_POST['refund_status'])) {
        $cancel_id = $_POST['cancel_id'];
        $refund_status = $_POST['refund_status'];

        $query = "UPDATE cancellation SET refund_status = :refund_status WHERE id = :cancel_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':refund_status', $refund_status);
        $stmt->bindParam(':cancel_id', $cancel_id);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "Refund status updated successfully.";
        } else {
            $_SESSION['msg'] = "Error updating refund status.";
        }
    }
    header('Location: Cancellation.php');
    exit();
}
?>
