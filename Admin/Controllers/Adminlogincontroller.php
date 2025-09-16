<?php
class AdminController {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Admin login method
    public function login($username, $password) {
        if (empty($username) || empty($password)) {
            return false;
        }

        try {
            // Fetch admin by email (assuming username is email)
            $stmt = $this->conn->prepare("SELECT * FROM Admin WHERE Email = ? AND Active = 1");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['Password'])) {
                // Successful login, start session and store info
                session_start();
                $_SESSION['admin_id'] = $admin['Admin_id'];
                $_SESSION['admin_name'] = $admin['Name'];
                $_SESSION['admin_email'] = $admin['Email'];
                $_SESSION['role'] = 'admin'; // Store the role as 'admin'

                // Redirect to admin dashboard
                header('Location: ../../../private/Admin/Views/Dashboard.php');
                exit();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Log error
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
}
