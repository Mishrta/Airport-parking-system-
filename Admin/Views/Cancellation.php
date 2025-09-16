<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: Adminlogin.php');
    exit();
}

require_once '../../../private/Config/database.php';

// Fetch all cancellations (with user and booking info)
$query = "SELECT c.id, c.cancelled_at, c.refund_status, 
                 b.booking_id, b.airport, b.car_park,
                 u.name, u.email
          FROM cancellation c
          JOIN booking b ON c.booking_id = b.booking_id
          JOIN users u ON c.user_id = u.user_id
          ORDER BY c.cancelled_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$cancellations = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <li><a href="Booking.php"><i class="fas fa-car"></i> Bookings</a></li>
            <li><a href="Contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
            <li class="active"><a href="Cancellation.php"><i class="fas fa-times-circle"></i> Cancellations</a></li>
            <li><a href="../../Views/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="dashboard">
        <h2>Cancellation Logs</h2>

        <div class="card">
            <h4>All Cancelled Bookings</h4>
            <table>
                <thead>
                <tr>
                    <th>Cancel ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Booking ID</th>
                    <th>Airport</th>
                    <th>Car Park</th>
                    <th>Refund Status</th>
                    <th>Cancelled At</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cancellations as $cancel): ?>
                    <tr>
                        <td><?php echo $cancel['id']; ?></td>
                        <td><?php echo $cancel['name']; ?></td>
                        <td><?php echo $cancel['email']; ?></td>
                        <td><?php echo $cancel['booking_id']; ?></td>
                        <td><?php echo $cancel['airport']; ?></td>
                        <td><?php echo $cancel['car_park']; ?></td>
                        <td>
                            <form method="POST" action="UpdateRefund.php">
                                <input type="hidden" name="cancel_id" value="<?php echo $cancel['id']; ?>">
                                <select name="refund_status">
                                    <option value="pending" <?php if ($cancel['refund_status'] === 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="approved" <?php if ($cancel['refund_status'] === 'approved') echo 'selected'; ?>>Approved</option>
                                    <option value="rejected" <?php if ($cancel['refund_status'] === 'rejected') echo 'selected'; ?>>Rejected</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                        <td><?php echo $cancel['cancelled_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
