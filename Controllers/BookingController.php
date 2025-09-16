<?php
require_once '../../private/Config/database.php';
require_once '../../private/Models/BookingModel.php';//  Include the BookingModel file where data-fetching functions are likely defined

$airports = getAirports($conn); //  Fetch all available airports from the database for the "Airport" dropdown
$car_parks = getCarParks($conn); //  Fetch car park options for the selected location
$parking_types = getParkingTypes($conn); //  Fetch parking type options
?>
