<?php
require_once '../../private/Config/database.php'; // Include your database connection
require_once '../../private/Controllers/BookingController.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Airport Parking System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../public/Assets/css/homepage.css">
    <link rel="stylesheet" href="../../public/Assets/css/slider.css">
    <link rel="stylesheet" href="../../public/Assets/css/header.css">
    <link rel="stylesheet" href="../../public/Assets/css/footer.css">
</head>
<body>

<?php include('../../private/Framework/header.php'); ?>

<section class="hero">
    <div class="hero-content split-hero">
        <!-- Left Side Text -->
        <div class="hero-left">
            <h1>Secure & Convenient Airport Parking</h1>
            <p>Reserve your spot today for a stress-free travel experience.</p>
        </div>

        <!-- Right Side Booking Box -->
        <div class="booking-box">
            <h2>Let’s find you the best<br>car parking deal</h2>

            <form action="parkingSelection.php" method="GET"> <!-- Changed to GET for parameter passing -->
                <!-- Select Airport -->
                <label>Select an airport</label>
                <div class="input-group">
                    <i class="fas fa-plane-departure"></i>
                    <select name="airport" id="airport" required>
                        <option>--Choose an Airport--</option>
                        <?php foreach ($airports as $airport): ?>
                            <option value="<?php echo $airport['parking_name']; ?>"><?php echo $airport['parking_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Select Car Park -->
                <label>Select a car park</label>
                <div class="input-group">
                    <i class="fas fa-building"></i>
                    <select name="car_park" required>
                        <option>--Choose a Car Park--</option>
                        <?php if (!empty($car_parks)): ?>
                            <?php foreach ($car_parks as $car_park): ?>
                                <option value="<?php echo $car_park['car_park']; ?>">
                                    <?php echo $car_park['car_park']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option>No car parks available for this airport.</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Select Parking Option -->
                <label>Select parking option</label>
                <div class="input-group">
                    <i class="fas fa-parking"></i>
                    <select name="parking_type" required>
                        <option value="">--Choose Parking Type--</option> <!-- Empty value here -->
                        <?php foreach ($parking_types as $type): ?>
                            <option value="<?php echo $type['type_name']; ?>">
                                <?php echo $type['type_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Parking From -->
                <label>Parking from</label>
                <div class="date-time-group">
                    <input type="date" name="from_date" required>
                    <input type="time" name="from_time" required>
                </div>

                <!-- Returning On -->
                <label>Returning on</label>
                <div class="date-time-group">
                    <input type="date" name="to_date" required>
                    <input type="time" name="to_time" required>
                </div>

                <button type="submit" class="search-btn">Search Availability</button>

                <div class="payment-icons">
                    <i class="fas fa-lock"></i>
                    <span>SAFE & SECURE PAYMENTS</span>
                    <div class="icons">
                        <img src="../../public/Assets/images/visa.jpg" alt="Visa">
                        <img src="../../public/Assets/images/paypal.png" alt="PayPal">
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<?php require_once '../../private/Framework/footer.php'; ?>

<script src="../../public/Assets/js/booking.js"></script>
</body>
</html>
