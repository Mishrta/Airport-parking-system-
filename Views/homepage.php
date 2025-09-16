<?php
require_once '../../private/Config/database.php';  //  database connection
require_once '../../private/Controllers/BookingController.php'; //  Include the BookingController class which handles all booking-related logic (e.g., saving, validating, fetching)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Airport Parking System</title>
    <link rel="stylesheet" href="../../public/Assets/css/homepage.css">
    <link rel="stylesheet" href="../../public/Assets/css/slider.css">
    <link rel="stylesheet" href="../../public/Assets/css/header.css">
    <link rel="stylesheet" href="../../public/Assets/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

            <form action="parkingSelection.php" method="POST">
                <!-- Select Airport -->
                <label>Select an airport</label>
                <div class="input-group">
                    <i class="fas fa-plane-departure"></i>
                    <select name="airport" required onchange="this.form.submit()">
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
                        <option>--Choose Parking Type--</option> <!-- Use an empty value for the placeholder -->
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

<!-- Features Section -->
<section class="features">
    <div class="feature-box">
        <div class="icon-wrapper">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h3>Safe & Secure</h3>
        <p>24/7 monitored parking with CCTV and security guards.</p>
    </div>
    <div class="feature-box">
        <div class="icon-wrapper">
            <i class="fas fa-calendar-check"></i>
        </div>
        <h3>Easy Booking</h3>
        <p>Reserve your parking spot online in just a few clicks.</p>
    </div>
    <div class="feature-box">
        <div class="icon-wrapper">
            <i class="fas fa-undo-alt"></i>
        </div>
        <h3>Free Cancellation</h3>
        <p>Get your money back after cancelling.</p>
    </div>
    <div class="feature-box">
        <div class="icon-wrapper">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <h3>Close to the Terminal</h3>
        <p>Parking options within a short walk.</p>
    </div>
</section>


<div class="parking-options-grid">
    <!-- First card: Image only -->
    <div class="parking-card image-only">
        <img src="../../public/Assets/images/park.png" alt="Visual Highlight">
    </div>

    <!-- Real content card -->
    <div class="parking-card">
        <img src="../../public/Assets/images/longstay.png" alt="Long Stay">
        <div class="card-content">
            <h3>Long Stay</h3>
            <p>If you're going away for a week or more, book <a href="#">Long Stay</a> parking.</p>
        </div>
    </div>

    <div class="parking-card">
        <img src="../../public/Assets/images/vip.png" alt="VIP Stay">
        <div class="card-content">
            <h3>VIP Stay</h3>
            <p><a href="#">VIP Stay</a> parking is just a few mins from the terminal, allowing quick check-in.</p>
        </div>
    </div>

    <div class="parking-card">
        <img src="../../public/Assets/images/short.png" alt="Short Stay">
        <div class="card-content">
            <h3>Short Stay</h3>
            <p><a href="#">Short Stay</a> parking is ideal for business trips and mini breaks.</p>
        </div>
    </div>

    <!-- Last card: Image only -->
    <div class="parking-card image-only">
        <img src="../../public/Assets/images/park2.png" alt="Visual Highlight">
    </div>
</div>


<!-- Full Wrapper for Split Layout -->
<section class="cta-row">
    <div class="cta-box">
        <h2>Why Choose Us?</h2>
        <p>Fast, affordable, and secure airport parking tailored to your needs.</p>
        <a href="about.php" class="btn-primary">Learn More</a>
    </div>
    <div class="car-visual">
        <img src="../../public/Assets/images/car.png" alt="Car" />
    </div>
</section>
<script src="../../public/Assets/js/slider.js"></script>

<!-- Login required message -->
<div id="login-msg" class="login-popup">You must be logged in to access this page</div>

<script src="../../public/Assets/js/messageslogin.js"></script>
<?php require_once '../../private/Framework/footer.php'; ?>
</body>
</html>
