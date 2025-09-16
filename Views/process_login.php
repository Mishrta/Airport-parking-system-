<?php
session_start(); //session start
require_once(__DIR__ . '/../../private/Config/database.php'); //  Include the database connection
require_once(__DIR__ . '/../../private/Controllers/LoginController.php'); // Include the LoginController which contains the login logic

$loginController = new LoginController($conn); // Create an instance of the LoginController and pass the $conn (PDO DB connection)
$loginController->login(); // Call the login method — this will handle form input, check credentials, and redirect/log in the user
?>
