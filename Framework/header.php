
<header class="header">
    <!-- Logo (Left) -->
    <div class="logo">
        <a href="../Views/homepage.php">
            <img src="../../public/Assets/images/logo.png" alt="Airport Parking Logo">
        </a>
    </div>

    <!-- Nav Links (Center) -->
    <nav class="navbar">
        <a href="../Views/homepage.php">Home</a>
        <a href="../Views/homepage.php#booking">Booking</a>
        <a href="../../private/Views/about.php">About</a>
        <a href="../../private/Views/contact.php">Contact</a>
    </nav>

    <!-- Conditional User Info (Right Side) -->
    <?php if (isset($_SESSION['name'])) : ?>
        <!-- Display user info when logged in -->
        <div class="user-info">
            <span>Welcome, <?php echo $_SESSION['name']; ?></span> |
            <a href="../../private/Views/UserDashboard.php">Dashboard</a> |
            <a href="../../private/Views/logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> <!-- Logout icon -->
            </a>
        </div>
    <?php else : ?>
        <!-- Display login button when not logged in -->
        <a href="../../private/Views/login.php" class="login-btn">
            <i class="fas fa-user"></i> <!-- login icon -->
        </a>
    <?php endif; ?>
</header>


