<?php
require("../DB_Connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $orderNotes = $_POST["orderNotes"];
    $total = $_POST["total"];
    $cartItems = $_POST["cartItems"];

    
    $sql = "INSERT INTO orders (notes, price) VALUES ('$orderNotes', '$total')";
    if (mysqli_query($conn, $sql)) {
        $orderId = mysqli_insert_id($conn); 
        foreach ($cartItems as $item) {
            $productId = $item["id"];
            $productName = $item["name"];
            $price = $item["price"];
            $quantity = $item["quantity"];
            
            echo $productId;
            $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('$orderId', '$productId', '$quantity')";
            mysqli_query($conn, $sql);
        }
        echo "Order placed successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Invalid request method.";
}