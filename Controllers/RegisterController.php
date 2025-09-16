<?php
session_start();
require_once '../../private/Config/database.php'; // Makes $conn available

class RegisterController {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // check if password matches or not
    public function register($name, $email, $password, $confirm_password) {
        if ($password !== $confirm_password) {
            return "Passwords do not match!";
        }

        $name = htmlspecialchars(trim($name));
        $email = htmlspecialchars(trim($email));
        $password = trim($password);

        // Check if email already exists
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Email already in use!";
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user with name
        $insert_query = "INSERT INTO users (email, name, password, active) VALUES (:email, :name, :password, 1)";
        $insert_stmt = $this->conn->prepare($insert_query);
        $insert_stmt->bindParam(':email', $email);
        $insert_stmt->bindParam(':name', $name);
        $insert_stmt->bindParam(':password', $hashed_password);

        if ($insert_stmt->execute()) {
            // ✅ Redirect to login with success message
            header("Location: ../../private/Views/login.php?message=" . urlencode("Registration successful! Please log in."));
            exit();
        } else {
            return "Error occurred during registration. Please try again.";
        }
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $registerController = new RegisterController($conn);
    $message = $registerController->register($name, $email, $password, $confirm_password);

    if ($message !== "Registration successful!") {
        header("Location: ../../private/Views/register.php?message=" . urlencode($message));
        exit();
    }
}
?>
