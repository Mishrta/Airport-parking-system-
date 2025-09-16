<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If the user is not logged in as admin, redirect to login
    header('Location: Adminlogin.php');
    exit();
}

require_once '../../../private/Config/database.php';

// Fetch all contact messages
$query = "SELECT * FROM contact ";  // Assume 'contact_messages' table holds user-submitted messages
$stmt = $conn->prepare($query);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <li class="active"><a href="Contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
            <li><a href="Cancellation.php"><i class="fas fa-times-circle"></i> Cancellations</a></li>
            <li><a href="../../Views/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="dashboard">
        <h2>Contact Messages</h2>

        <div class="card">
            <h4>All Contact Messages</h4>
            <table>
                <thead>
                <tr>
                    <th>Contact ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Phone number</th>
                    <th>Message</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo $message['Contact_id']; ?></td>
                        <td><?php echo $message['Name']; ?></td>
                        <td><?php echo $message['Email']; ?></td>
                        <td><?php echo $message['Subject']; ?></td>
                        <td><?php echo $message['Phone_number']; ?></td>
                        <td><?php echo substr($message['Message'], 0, 250); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
