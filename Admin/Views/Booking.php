<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If the user is not logged in as admin, redirect to login
    header('Location: Adminlogin.php');
    exit();
}

require_once '../../../private/Config/database.php';

// Fetch all bookings from the database
$query = "SELECT * FROM booking";
$stmt = $conn->prepare($query);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="../../../public/Assets/css/dashboard.css">
<link rel="stylesheet" href="../../../public/Assets/css/header.css">
<link rel="stylesheet" href="../../../public/Assets/css/footer.css">

<div class="admin-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="../../../public/Assets/images/admin.webp" alt="Admin Avatar" class="avatar">
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></p>
        </div>

        <ul>
            <li><a href="Dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="Customers.php"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="ParkingSpace.php"><i class="fas fa-parking"></i> Parking Space</a></li>
            <li class="active"><a href="Booking.php"><i class="fas fa-car"></i> Bookings</a></li>
            <li><a href="Contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
            <li><a href="Cancellation.php"><i class="fas fa-times-circle"></i> Cancellations</a></li>
            <li><a href="../../Views/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="dashboard">
        <h2>Bookings</h2>

        <div class="card">
            <h4>All Bookings</h4>
            <table>
                <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User ID</th>
                    <th>Type ID</th>
                    <th>Slot ID</th>
                    <th>Car Park</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['booking_id']; ?></td>
                        <td><?php echo $booking['user_id']; ?></td>
                        <td><?php echo $booking['type_id']; ?></td>
                        <td><?php echo $booking['slot_id']; ?></td>
                        <td><?php echo $booking['car_park']; ?></td>
                        <td><?php echo $booking['status']; ?></td>
                        <td><?php echo $booking['from_date']; ?></td>
                        <td><?php echo $booking['to_date']; ?></td>
                        <td>
                            <a href="EditBooking.php?id=<?php echo $booking['booking_id']; ?>">Edit</a> |
                            <a href="DeleteBooking.php?id=<?php echo $booking['booking_id']; ?>" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <a href="AddBooking.php" class="btn btn-primary">Add New Booking</a>
        </div>
    </main>
</div>
</body>
</html>
