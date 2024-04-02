<?php
// session_start();
// if (!isset($_SESSION['user_id'])) {
//     // Redirect the user to the login page or handle the case where user is not logged in
//     header("Location: login.php");
//     exit(); // Stop further execution
// }

// $user_id = $_SESSION['user_id'];

$orderData = $_POST;

include_once("../db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $products = $_POST['products'];
    $orderNotes = $_POST['orderNotes'];
    $totalPrice = $_POST['totalPrice'];
    $orderDateTime = $_POST['orderDateTime'];

    $user_id = 2;
    $orderSql = "INSERT INTO `order` (notes, price, user_id, created_at) VALUES (?, ?, ?, ?)";
    $orderStmt = $pdo->prepare($orderSql);
    $orderStmt->execute([$orderNotes, $totalPrice, $user_id, $orderDateTime]);


    $orderId = $pdo->lastInsertId();

    $orderItemsSql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
    $orderItemsStmt = $pdo->prepare($orderItemsSql);


    foreach ($products as $productId => $product) {
        $productId = $product['id'];
        $quantity = $product['quantity'];


        $orderItemsStmt->execute([$orderId, $productId, $quantity]);
    }

    if ($orderStmt->rowCount() > 0 && $orderItemsStmt->rowCount() > 0) {
        echo "Order successfully placed!";
    } else {
        echo "Failed to place the order. Please try again.";
    }
}