<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="../../../public/Assets/css/login.css">
    <link rel="stylesheet" href="../../../public/Assets/css/footer.css">
</head>
<body>



<div class="container">

    <!-- Back to Home Icon -->
    <div class="back">
        <a href="../../../private/Views/login.php" title="Back">
            <i class="fas fa-backward"></i> <!-- Font Awesome Home Icon -->
        </a>
    </div>

    <!-- Display Error Message if Credentials are Invalid -->
    <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials'): ?>
        <div class="error-message">
            <p>Invalid credentials, please try again.</p>
        </div>
    <?php endif; ?>

    <form class="login-form" method="post" action="ProcessAdminlogin.php">
        <h2>Admin Login</h2>
        <div class="input-container">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Enter your email" required>
        </div>
        <div class="input-container">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit">Login</button>
</div>


</body>
</html>
