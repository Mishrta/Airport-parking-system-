<?php
session_start();

//  Restrict access: only allow users with 'admin' role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    //  If not an admin, redirect to the admin login page
    header('Location: Adminlogin.php');
    exit();
}

require_once '../../../private/Config/database.php'; //database connection

// If there's a slot ID in the URL, fetch its current details to pre-fill the form
if (isset($_GET['id'])) {
    $slot_id = $_GET['id'];

    // Fetch current parking space details
    $query = "SELECT * FROM parking_space WHERE slot_id = :slot_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':slot_id', $slot_id, PDO::PARAM_INT);
    $stmt->execute();
    $parking = $stmt->fetch(PDO::FETCH_ASSOC); // Used to populate the form
}

//  If the admin submitted the form with POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location_id = $_POST['location_id'];
    $car_park = $_POST['car_park'];
    $status = $_POST['status'];

    // Update parking space in the database
    $update_query = "UPDATE parking_space SET location_id = :location_id, car_park = :car_park, status = :status WHERE slot_id = :slot_id";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bindParam(':location_id', $location_id);
    $update_stmt->bindParam(':car_park', $car_park);
    $update_stmt->bindParam(':status', $status);
    $update_stmt->bindParam(':slot_id', $slot_id, PDO::PARAM_INT);

    //  If update is successful, redirect to the listing page
    if ($update_stmt->execute()) {
        header('Location: ParkingSpace.php');
        exit();
    } else {
        echo "Error updating parking space."; // Show error if update fails
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/Assets/css/update.css">
    <title>Update Booking</title>
</head>
<body>

<div class="container">
    <h1 class="page-title">Edit Parking Space</h1>

<form action="EditParkingSpace.php?id=<?php echo $parking['slot_id']; ?>" method="POST">
    <label for="location_id">Location ID</label>
    <input type="text" id="location_id" name="location_id" value="<?php echo $parking['location_id']; ?>" required>

    <label for="car_park">Car Park</label>
    <input type="text" id="car_park" name="car_park" value="<?php echo $parking['car_park']; ?>" required>

    <label for="status">Status</label>
    <select id="status" name="status" required>
        <option value="available" <?php echo $parking['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
        <option value="booked" <?php echo $parking['status'] == 'booked' ? 'selected' : ''; ?>>Booked</option>
        <option value="reserved" <?php echo $parking['status'] == 'reserved' ? 'selected' : ''; ?>>Reserved</option>
    </select>

    <button type="submit">Update Parking Space</button>
</form>
