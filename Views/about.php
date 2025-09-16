<?php
session_start();  // Start the session to access session variables
require_once '../../private/Config/database.php';  // Include the database connection

// Fetch FAQs from the database
try {
    $stmt = $conn->prepare("SELECT * FROM faqs");
    $stmt->execute();
    $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ensure that $faqs is an array before using it in a foreach loop
    if (!$faqs) {
        $faqs = [];  // Set to an empty array if no FAQs are returned
    }
} catch (PDOException $e) {
    die("Error fetching FAQs: " . $e->getMessage());
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us - Airport Parking System</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="../../public/Assets/css/about.css" />
    <link rel="stylesheet" href="../../public/Assets/css/header.css" />
    <link rel="stylesheet" href="../../public/Assets/css/footer.css" />
</head>
<body>

<?php include('../../private/Framework/header.php'); ?>

<section class="about-hero">
    <div class="overlay">
        <h1>About Us</h1>
    </div>
</section>

<section class="about" id="about">
    <div class="about-container">
        <div class="about-text">
            <h2>We are your airport parking partner</h2>
            <p>
                Welcome to Airport Parking System, your reliable partner for secure, convenient, and affordable airport parking. Our mission is to simplify your travel experience by offering seamless online booking and hassle-free parking services.
            </p>
            <p>
                Whether you're traveling for business or leisure, we provide safe, convenient, and cost-effective parking solutions tailored to meet your needs. Our dedicated team ensures your vehicle is secure, giving you peace of mind while you travel.
            </p>
            <a href="homepage.php" class="btn">Book Now</a>
        </div>
        <div class="about-image">
            <img src="../../public/Assets/images/p6.jpg" alt="Parking Lot" />
        </div>
    </div>
</section>

<section class="about-slider">
    <h2 class="slider-title"></h2>
    <div class="slider-container">
        <div class="slider-track">
            <div class="slide"><img src="../../public/Assets/images/p5.jpg" alt="Parking Image 1"></div>
            <div class="slide"><img src="../../public/Assets/images/p12.jpg" alt="Parking Image 2"></div>
            <div class="slide"><img src="../../public/Assets/images/p1.jpg" alt="Parking Image 3"></div>
            <div class="slide"><img src="../../public/Assets/images/p4.jpg" alt="Parking Image 4"></div>
        </div>
    </div>
</section>

<!-- FAQs Section -->
<section class="faqs" id="faqs">
    <div class="container">
        <h1 class="heading">Frequently Asked Questions</h1>

        <!-- Check if FAQs are available -->
        <?php if (count($faqs) > 0): ?>
            <?php foreach ($faqs as $faq): ?>
                <details>
                    <summary><?= htmlspecialchars($faq['Question']) ?></summary>
                    <div><?= htmlspecialchars($faq['Answer']) ?></div>
                </details>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No FAQs available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials" id="testimonials">
    <div class="section-title">
        <h2>What Our Travelers Say</h2>
    </div>
    <div class="testimonials-grid">
        <div class="testimonial-card">
            <div class="testimonial-text">
                "Booking a spot was insanely quick — and everything was smooth when I showed up!"
            </div>
            <div class="testimonial-author">
                <strong>Sarah K.</strong> — Business Traveler
            </div>
        </div>
        <div class="testimonial-card">
            <div class="testimonial-text">
                "I was worried about leaving my car, but their security gave me total peace of mind."
            </div>
            <div class="testimonial-author">
                <strong>Jay M.</strong> — Frequent Flyer
            </div>
        </div>
        <div class="testimonial-card">
            <div class="testimonial-text">
                "Affordable rates, close to the terminal, and I didn’t waste time circling for a spot. Perfect."
            </div>
            <div class="testimonial-author">
                <strong>Aisha T.</strong> — Tech Enthusiast
            </div>
        </div>
    </div>
</section>



<?php include('../../private/Framework/footer.php'); ?>

</body>
</html>
