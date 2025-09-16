<?php
session_start();

if (isset($_SESSION['register_success'])) {
    echo '<p class="message success">' . htmlspecialchars($_SESSION['register_success']) . '</p>';
    unset($_SESSION['register_success']); // Clear it after showing
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="../../public/Assets/css/login.css">
    <link rel="stylesheet" href="../../public/Assets/css/header.css">
    <link rel="stylesheet" href="../../public/Assets/css/footer.css">
</head>
<body>

<?php include('../../private/Framework/header.php'); ?>

<div class="container">
    <!-- Admin Login Icon Positioned at the Top-Left -->
    <div class="admin-login-icon">
        <a href="../Admin/Views/Adminlogin.php" title="Admin Login">
            <i class="fas fa-user-shield"></i> <!-- Only Icon, No Text -->
        </a>
    </div>

    <!-- Display Error Message if Credentials are Invalid -->
    <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials'): ?>
        <div class="error-message">
            <p>Invalid credentials, please try again.</p>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['message'])): ?>
        <div id="flash-message" style="padding: 12px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 15px;">
            <?= htmlspecialchars($_GET['message']) ?>
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('flash-message');
                if (msg) msg.style.display = 'none';
            }, 3000);
        </script>
    <?php endif; ?>

    <form class="login-form" method="post" action="process_login.php">
        <h2>Login</h2>
        <div class="input-container">
            <i class="fas fa-user"></i>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="input-container">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit">Login</button>
    </form>

    <p class="register-link">Don't have an account? <a href="register.php"> Register here</a></p>
</div>
</body>
</html>
