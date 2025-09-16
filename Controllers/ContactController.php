<?php
session_start();

require_once '../../private/Config/database.php';

// Collect and sanitize form data
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
$phone = htmlspecialchars(trim($_POST['phone_number'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

$errors = [];

// Validate fields
if (empty($name) || empty($email) || empty($message)) {
    $errors[] = "Name, Email, and Message are required.";
}

if (empty($phone) || !preg_match('/^\d{11}$/', $phone)) {
    $errors[] = "Phone number must be exactly 11 digits.";
}

if (empty($subject)) {
    $errors[] = "Subject is required.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email.";
}

// If there are no validation errors, proceed with saving the message
if (count($errors) === 0) {
    try {
        $stmt = $conn->prepare("INSERT INTO contact (Name, Email, Subject, Phone_number, Message)
                                VALUES (:name, :email, :subject, :phone_number, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':phone_number', $phone);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            header("Location: ../Views/contact.php?message=" . urlencode("Your message has been sent successfully!"));
        } else {
            header("Location: ../Views/contact.php?message=" . urlencode("There was an error with your submission."));
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        header("Location: ../Views/contact.php?message=" . urlencode("Database error: " . $e->getMessage()));
    }
} else {
    $errorString = implode("<br>", $errors);
    header("Location: ../Views/contact.php?message=" . urlencode($errorString));
}

exit();
