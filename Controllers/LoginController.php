<?php
require_once(__DIR__ . '/../Config/database.php');
class LoginController {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function login() {
        //  Check if the request method is POST (form submission)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            //  Only continue if both email and password are provided
            if ($email && $password) {
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE Email = ? AND Active = 1");  //  Prepare a query to find the user by email and ensure their account is active
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                //  Verify the entered password against the hashed password in DB
                if ($user && password_verify($password, $user['Password'])) {
                    //  Store user data in session variables
                    $_SESSION['user_id'] = $user['User_ID'];
                    $_SESSION['email'] = $user['Email'];
                    $_SESSION['name'] = $user['Name'];
                    $_SESSION['role'] = 'user';
                    $_SESSION['success'] = 'Login successful! Welcome.';

                    //  Redirect to user dashboard on successful login
                    header("Location: ../../private/Views/UserDashboard.php");
                    exit();
                }
            }

            // Redirect if login fails, with an error message in the url
            header("Location: login.php?error=invalid_credentials");
            exit();
        }
    }
}
