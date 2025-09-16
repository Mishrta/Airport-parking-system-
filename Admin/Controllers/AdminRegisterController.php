<?php
session_start();

// Include the database connection
require_once('../../../private/Config/database.php'); // Adjust the path according to your directory structure

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;
    $password = $_POST['password'] ?? null;
    $confirm_password = $_POST['confirm_password'] ?? null;

    // Check if all fields are provided
    if (empty($name) || empty($email) || empty($phone_number) || empty($password) || empty($confirm_password)) {
        $_SESSION['message'] = 'All fields are required!';
        header('Location: ../../../private/Admin/Views/AdminRegister.php');
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['message'] = 'Passwords do not match!';
        header('Location: ../../../private/Admin/Views/AdminRegister.php');
        exit();
    }

    // Check if email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM Admin WHERE Email = ?");
    $stmt->execute([$email]);
    $existingAdmin = $stmt->fetch();

    if ($existingAdmin) {
        $_SESSION['message'] = 'Email is already registered!';
        header('Location: ../../../private/Admin/Views/AdminRegister.php');
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Insert new admin into the database
        $stmt = $conn->prepare("INSERT INTO Admin (Name, Email, Phone_Number, Password, Active) 
                                VALUES (:name, :email, :phone_number, :password, 1)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':password', $hashedPassword);

        $stmt->execute();

        // Get the ID of the newly created admin
        $admin_id = $conn->lastInsertId();

        // Start a session for the logged-in admin
        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_name'] = $name;
        $_SESSION['admin_email'] = $email;
        $_SESSION['role'] = 'admin'; // Set the role to admin

        // Redirect to the admin dashboard
        header('Location: ../../../private/Admin/Views/Dashboard.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error occurred: ' . $e->getMessage();
        header('Location: ../../../private/Admin/Views/AdminRegister.php');
        exit();
    }
}
