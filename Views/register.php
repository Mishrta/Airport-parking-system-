<?php
session_start();  //  Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Airport Parking System</title>
    <link rel="stylesheet" href="../../public/Assets/css/register.css">
    <link rel="stylesheet" href="../../public/Assets/css/header.css">
</head>
<body>

<?php include('../../private/Framework/header.php'); ?>

<section class="register">
    <h2>Create an Account</h2>

    <?php if (isset($_GET['message'])): ?>
        <p class="message"><?= htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <form action="../Controllers/RegisterController.php" method="POST">
        <label>Full Name:</label>
        <input type="text" name="name" required placeholder="Your full name">

        <label>Email:</label>
        <input type="email" name="email" required placeholder="Enter your email">

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" name="register">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</section>

</body>
</html>
