<?php
session_start();  // Start session

require_once '../../private/Config/database.php'; //Include the database config file to connect to the database

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$updateSuccess = $_SESSION['update_success'] ?? ''; // Get the update success message
unset($_SESSION['update_success']); // Remove it after it's been displayed

$cancelSuccess = $_SESSION['cancel_success'] ?? ''; // Get the cancellation success message
unset($_SESSION['cancel_success']); // Remove it after it's been displayed

// Flash success message (if just logged in)
$successMessage = '';
if (isset($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    unset($_SESSION['success']); // clear it after showing
}

// Get user info
$userDisplayName = $_SESSION['name'];
$user_id = $_SESSION['user_id'];

$query = "
SELECT booking_id, airport, car_park, from_date, to_date, status 
FROM booking
WHERE user_id = :user_id

";

//  Prepare and execute the SQL query safely using PDO
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../public/Assets/css/header.css">
    <link rel="stylesheet" href="../../public/Assets/css/footer.css">
    <link rel="stylesheet" href="../../public/Assets/css/UserDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<!-- Keep the existing header -->
<?php include('../../private/Framework/header.php'); ?>

<!-- Header with Welcome, Dashboard, and Logout on the top-right -->
<div class="user-info">
    <span>Welcome, <?= htmlspecialchars($userDisplayName) ?></span> |
    <a href="UserDashboard.php" class="dashboard-link">Dashboard</a> |
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<?php if (!empty($updateSuccess)): ?>
    <div class="success-message" id="flash-message">
    <?= htmlspecialchars($updateSuccess) ?></div>
<?php endif; ?>

<?php if (!empty($cancelSuccess)): ?>
<div class="success-message" id="flash-message">
    <?= htmlspecialchars($cancelSuccess) ?></div>
<?php endif; ?>

<?php if (!empty($successMessage)): ?>
    <div class="success-message" id="flash-message">
        <?= htmlspecialchars($successMessage) ?>
    </div>
<?php endif; ?>

<section class="dashboard">
    <div class="container">
        <h1>Welcome, <?= htmlspecialchars($userDisplayName) ?> </h1>
        <p>You’re logged into your dashboard. From here you can:</p>
        <ul>
            <li><a href="booking.php" class="btn">Make a new booking</a></li>
        </ul>

        <h2>Your Bookings</h2>


        <?php if (!empty($bookings)): ?>
            <table>
                <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Airport</th>
                    <th>Car Park</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= htmlspecialchars($booking['booking_id']) ?></td>
                        <td><?= htmlspecialchars($booking['airport'] ?? '') ?></td>
                        <td><?= htmlspecialchars($booking['car_park'] ?? '') ?></td>
                        <td><?= htmlspecialchars($booking['from_date']) ?></td>
                        <td><?= htmlspecialchars($booking['to_date']) ?></td>
                        <td><?= htmlspecialchars($booking['status']) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="UpdateBooking.php?booking_id=<?= $booking['booking_id'] ?>" class="btn update-btn">Update</a> <!-- ️ Link to update the booking -->
                                <a href="CancelBooking.php?booking_id=<?= $booking['booking_id'] ?>" class="btn cancel-btn">Cancel</a> <!-- Link to cancel the booking -->
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No bookings found.</p>
        <?php endif; ?>
    </div>
</section>

<script src="../../public/Assets/js/flashmessage.js"></script>

</body>
</html>
