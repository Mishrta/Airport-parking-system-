<?php
session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/Assets/css/contact.css" />
    <link rel="stylesheet" href="../../public/Assets/css/header.css" />
    <link rel="stylesheet" href="../../public/Assets/css/footer.css" />
</head>
<body>
<?php include('../../private/Framework/header.php'); ?>

<div class="page-banner">
    <div class="container">
        <div class="breadcrumb">
        </div>
        <h1 class="page-title">Contact Us</h1>
    </div>
    <div class="wave-divider"></div>
</div>

<?php if (isset($_GET['message'])): ?>
    <div id="flash-message" style="padding: 12px 20px; background-color: #d4edda; color: #155724;border: 1px solid #c3e6cb; border-radius: 6px;font-weight: bold; text-align: center; width: fit-content; max-width: 90%;  margin: 30px auto 20px auto; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
        <?= htmlspecialchars($_GET['message']) ?>
    </div>
    <script>
        setTimeout(() => {
            const msg = document.getElementById('flash-message');
            if (msg) msg.style.display = 'none';
        }, 3000);
    </script>
<?php endif; ?>

<section class="contact-info">
    <div class="container">
        <div class="contact-wrapper">
            <div class="contact-text">
                <h2>Get in Touch.</h2>
                <p>Don't hesitate to contact us for more information or free consultation.</p>

                <div class="locations">
                    <div class="location">
                        <h3>Main Location</h3>
                        <div class="location-detail">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <p class="label">Location</p>
                                <p>123 Gateway House,<br>UK - Leicester</p>
                            </div>
                        </div>
                        <div class="location-detail">
                            <i class="fas fa-phone"></i>
                            <div>
                                <p class="label">Phone</p>
                                <p>0116-0404002</p>
                            </div>
                        </div>
                    </div>

                    <div class="location">
                        <h3>Second Location</h3>
                        <div class="location-detail">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <p class="label">Location</p>
                                <p>456 De Montfort,<br>UK - Leicester</p>
                            </div>
                        </div>
                        <div class="location-detail">
                            <i class="fas fa-phone"></i>
                            <div>
                                <p class="label">Phone</p>
                                <p>0116-11012004</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="business-inquiry">
                    <h3>Questions or Business Inquiry.</h3>
                    <p>Email support@airportparking.com or call a location. Please follow our official social media to get updates.</p>
                    <div class="social-icons">
                        <a href="https://facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://linkedin.com/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>

            <div class="map-container">
                <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2421.6682048341318!2d-1.1424313234914938!3d52.62983977208999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4879ddcfc377f7cd%3A0xd91c9efcc41fdd79!2sDe%20Montfort%20University!5e0!3m2!1sen!2suk!4v1746821179537!5m2!1sen!2suk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <div class="map-controls">
                    <button class="map-control zoom-in"><i class="fas fa-plus"></i></button>
                    <button class="map-control zoom-out"><i class="fas fa-minus"></i></button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-form-section">
    <div class="container">
        <div class="form-wrapper">
            <h3>Send Us Message</h3>
            <h2>Say Hi,</h2>
            <form method="post" action="../../private/Controllers/ContactController.php">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel"  name="phone_number" placeholder="Phone Number" maxlength="11" inputmode="numeric">
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Subject">
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Message" rows="5" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
</section>

<?php include('../../private/Framework/footer.php'); ?>

</body>
</html>

