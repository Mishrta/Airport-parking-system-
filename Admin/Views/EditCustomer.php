<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    //  If not an admin, redirect to the admin login page
    header('Location: Adminlogin.php');
    exit();
}

require_once '../../../private/Config/database.php'; //database connection

// Check if the customer ID is passed via URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch the customer details from the database
    $query = "SELECT * FROM users WHERE User_ID = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update customer information if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Update customer in the database
    $update_query = "UPDATE users SET Name = :name, Email = :email WHERE User_ID = :user_id";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bindParam(':name', $name);
    $update_stmt->bindParam(':email', $email);
    $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    //  If update is successful, redirect to the listing page
    if ($update_stmt->execute()) {
        header('Location: Customers.php');
        exit();
    } else {
        echo "Error updating customer.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/Assets/css/update.css">
    <title>Update Booking</title>
</head>
<body>

<div class="container">
    <h1 class="page-title">Edit Customer</h1>

    <div class="update-container">
        <form action="EditCustomer.php?id=<?php echo $customer['User_ID']; ?>" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($customer['Name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customer['Email']); ?>" required>
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
</div>

