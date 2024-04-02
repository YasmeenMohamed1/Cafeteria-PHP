<?php
include("../DB_Connection.php");


session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['notes']) && isset($_POST['price'])) {
        
        $notes = $_POST['notes'];
        $price = $_POST['price'];

        try {
            $stmt = $database->prepare("INSERT INTO orders (price, notes) VALUES (:price, :notes)");
            $stmt->bindParam(':total', $price);
            $stmt->bindParam(':notes', $notes);
            $stmt->execute();

            
            // header("Location: Admin_order.php");
            
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Missing form fields";
    }
} else {
    echo "Invalid request method";
}