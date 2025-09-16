<?php
class Customer {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Fetch all users from the Users table
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM Users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //  Fetch a single user by their ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE User_ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Delete a user by ID
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Users WHERE User_ID = ?");
        return $stmt->execute([$id]);
    }

    //  Insert a new user into the Users table
    public function add($username, $password, $active) {
        $stmt = $this->db->prepare("INSERT INTO Users (User_name, Password, Active) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $password, $active]);
    }

    // Update an existing user's info
    public function update($id, $username, $password, $active) {
        $stmt = $this->db->prepare("UPDATE Users SET User_name = ?, Password = ?, Active = ? WHERE User_ID = ?");
        return $stmt->execute([$username, $password, $active, $id]);
    }
}
?>
