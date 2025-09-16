<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If the user is not logged in as admin, redirect to login
    header('Location: Adminlogin.php');
    exit();
}

require_once '../../../private/Admin/Controllers/AdminDashboardController.php';

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
            <li class="active"><a href="Dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="Customers.php"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="ParkingSpace.php"><i class="fas fa-parking"></i> Parking Space</a></li>
            <li><a href="Booking.php"><i class="fas fa-car"></i> Bookings</a></li>
            <li><a href="Contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
            <li><a href="Cancellation.php"><i class="fas fa-times-circle"></i> Cancellations</a></li>
            <li><a href="../../Views/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="dashboard">
        <div class="top-section">
            <div class="card">
                <h4>Total Bookings</h4>
                <h2><?php echo $total_bookings; ?></h2>
            </div>
            <div class="card">
                <h4>Total Parking Slots</h4>
                <h2><?php echo $total_parking; ?></h2>
            </div>
            <div class="card">
                <h4>Total Locations</h4>
                <h2><?php echo $total_location; ?></h2>
            </div>
        </div>

        <div class="mid-section">
            <div class="card">
                <h4>Recent Bookings</h4>
                <table>
                    <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User ID</th>
                        <th>Airport</th>
                        <th>Car Park</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking['booking_id']; ?></td>
                            <td><?php echo $booking['user_id']; ?></td>
                            <td><?php echo $booking['airport']; ?></td>
                            <td><?php echo $booking['car_park']; ?></td>
                            <td><?php echo $booking['from_date']; ?></td>
                            <td><?php echo $booking['to_date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>