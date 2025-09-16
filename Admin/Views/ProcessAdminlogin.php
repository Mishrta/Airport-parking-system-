<?php
session_start();

// Include the database connection
require_once('../../../private/Config/database.php');
require_once('../../../private/Admin/Controllers/AdminloginController.php');

// Instantiate AdminController with the database connection
$adminController = new AdminController($conn);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    // Attempt login
    if ($adminController->login($username, $password)) {
        // Redirect to the admin dashboard if login is successful
        header('Location: ../../../private/Admin/Views/Dashboard.php');
        exit();
    } else {
        // Redirect back to login with error message
        header("Location: Adminlogin.php?error=invalid_credentials");
        exit();
    }
}
