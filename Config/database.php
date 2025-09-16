<?php
// Database connection settings
$host = 'localhost';  //
$dbname = 'airportparking'; // database name
$username = 'parking_admin'; //  database username
$password = 'airport'; //  database password

try {
    // Create the PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>

