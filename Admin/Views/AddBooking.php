<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: Adminlogin.php');
    exit();
}

require_once '../../../private/Config/database.php';

// Initialize form data variables
$customer_id = $slot_id = $from_date = $to_date = '';
$error_message = '';

if (isset($_POST['add_booking'])) {
    $customer_id = $_POST['customer_id'];
    $slot_id = $_POST['slot_id'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    if (empty($customer_id)) {
        $error_message = "Please select a customer.";
    } else {
        // Fetch car_park, parking_type_id, and parking_name (airport) from the selected slot
        $query_slot = "
            SELECT p.car_park, p.parking_type_id, l.parking_name
            FROM parking_space p
            JOIN location l ON p.location_id = l.location_id
            WHERE p.slot_id = :slot_id";

        $stmt_slot = $conn->prepare($query_slot);
        $stmt_slot->bindParam(':slot_id', $slot_id);
        $stmt_slot->execute();
        $slot_data = $stmt_slot->fetch(PDO::FETCH_ASSOC);

        if ($slot_data) {
            $car_park = $slot_data['car_park'];
            $parking_type_id = $slot_data['parking_type_id'];
            $airport = $slot_data['parking_name'];

            // Insert into booking table
            $query = "INSERT INTO booking (user_id, slot_id, from_date, to_date, type_id, car_park, airport) 
                      VALUES (:user_id, :slot_id, :from_date, :to_date, :type_id, :car_park, :airport)";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $customer_id);
            $stmt->bindParam(':slot_id', $slot_id);
            $stmt->bindParam(':from_date', $from_date);
            $stmt->bindParam(':to_date', $to_date);
            $stmt->bindParam(':type_id', $parking_type_id);
            $stmt->bindParam(':car_park', $car_park);
            $stmt->bindParam(':airport', $airport);

            if ($stmt->execute()) {
                // Update parking space status
                $query_update = "UPDATE parking_space SET status = 'booked' WHERE slot_id = :slot_id";
                $stmt_update = $conn->prepare($query_update);
                $stmt_update->bindParam(':slot_id', $slot_id);
                $stmt_update->execute();

                header('Location: ../../../private/Admin/Views/Booking.php');
                exit();
            } else {
                $error_message = "Error: Could not add the booking.";
            }
        } else {
            $error_message = "Slot not found.";
        }
    }
}

// Fetch parking slots with airport names
$query_parking = "
    SELECT p.slot_id, p.car_park, p.location_id, p.parking_type_id, l.parking_name
    FROM parking_space p
    JOIN location l ON p.location_id = l.location_id
    WHERE p.status = 'available'";
$stmt_parking = $conn->prepare($query_parking);
$stmt_parking->execute();
$parking_spaces = $stmt_parking->fetchAll(PDO::FETCH_ASSOC);

// Fetch customers
$query_customers = "SELECT * FROM users";
$stmt_customers = $conn->prepare($query_customers);
$stmt_customers->execute();
$customers = $stmt_customers->fetchAll(PDO::FETCH_ASSOC);
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
            <li><a href="../../Views/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="dashboard">
        <h2>Add New Booking</h2>

        <!-- Error Message -->
        <?php if (!empty($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>

        <!-- Add Booking Form -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="customer_id">Customer</label>
                <select name="customer_id" id="customer_id" required>
                    <option value="">Select Customer</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?php echo $customer['User_ID']; ?>" <?php echo ($customer_id == $customer['User_ID']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($customer['Name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="slot_id">Parking Slot</label>
                <select name="slot_id" id="slot_id" required>
                    <option value="">Select Parking Slot</option>
                    <?php foreach ($parking_spaces as $space): ?>
                        <option value="<?php echo $space['slot_id']; ?>" <?php echo ($slot_id == $space['slot_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars("{$space['parking_name']} - {$space['car_park']} (Type {$space['parking_type_id']})"); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="from_date">Start Date</label>
                <input type="date" name="from_date" id="from_date" required value="<?php echo htmlspecialchars($from_date ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="to_date">End Date</label>
                <input type="date" name="to_date" id="to_date" required value="<?php echo htmlspecialchars($to_date ?? ''); ?>">
            </div>

            <button type="submit" name="add_booking">Add Booking</button>
        </form>

        <script src="../../../public/Assets/js/toggleGuestFields.js"></script>
    </main>
</div>
