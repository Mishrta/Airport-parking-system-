<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If the user is not logged in as admin, redirect to login
    header('Location: Adminlogin.php');
    exit();
}

require_once '../../../private/Config/database.php';

// Fetch all parking spaces from the database
$query = "SELECT * FROM parking_space";
$stmt = $conn->prepare($query);
$stmt->execute();
$parking_spaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            <li class="active"><a href="ParkingSpace.php"><i class="fas fa-parking"></i> Parking Space</a></li>
            <li><a href="Booking.php"><i class="fas fa-car"></i> Bookings</a></li>
            <li><a href="Contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
            <li><a href="Cancellation.php"><i class="fas fa-times-circle"></i> Cancellations</a></li>
            <li><a href="../../Views/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="dashboard">
        <h2>Parking Space</h2>

        <div class="card">
            <h4>All Parking Spaces</h4>
            <table>
                <thead>
                <tr>
                    <th>Slot ID</th>
                    <th>Location</th>
                    <th>Car Park</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($parking_spaces as $parking): ?>
                    <tr>
                        <td><?php echo $parking['slot_id']; ?></td>
                        <td><?php echo $parking['location_id']; ?></td>
                        <td><?php echo $parking['car_park']; ?></td>
                        <td><?php echo $parking['status']; ?></td>
                        <td>
                            <a href="EditParkingSpace.php?id=<?php echo $parking['slot_id']; ?>">Edit</a> |
                            <a href="DeleteParkingSpace.php?id=<?php echo $parking['slot_id']; ?>" onclick="return confirm('Are you sure you want to delete this parking space?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
