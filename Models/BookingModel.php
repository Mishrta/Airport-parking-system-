<?php
session_start();
require_once '../../private/Config/database.php'; // database connection


function getAirports($conn)
{
    $stmt = $conn->prepare("SELECT parking_name FROM location"); // Select parking names from location table
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCarParks($conn)
{
    $stmt = $conn->prepare("SELECT DISTINCT car_park FROM parking_space"); // Get unique car park names
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getParkingTypes($conn)
{
    $stmt = $conn->prepare("SELECT type_name FROM parking_type"); // Select parking type names
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

