<?php
session_start();
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_user = $_POST['user_select'];

    if (!empty($selected_user)) {
        include_once("../db.php");

        $products = $_POST['products'];
        $orderNotes = $_POST['orderNotes'];
        $totalPrice = $_POST['totalprice'];
        $orderDateTime = $_POST['orderDateTime'];

        $orderSql = "INSERT INTO `order` (notes, price, user_id, created_at) VALUES (?, ?, ?, ?)";
        $orderStmt = $pdo->prepare($orderSql);
        $orderStmt->execute([$orderNotes, $totalPrice, $selected_user, $orderDateTime]);

        $orderId = $pdo->lastInsertId();

        $orderItemsSql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
        $orderItemsStmt = $pdo->prepare($orderItemsSql);

        foreach ($products as $productId => $product) {
            $productId = $product['id'];
            $quantity = $product['quantity'];

            $orderItemsStmt->execute([$orderId, $productId, $quantity]);

            $updateProductSql = "UPDATE `product` SET `quantity` = `quantity` - ? WHERE `id` = ?";
            $updateProductStmt = $pdo->prepare($updateProductSql);
            $updateProductStmt->execute([$quantity, $productId]);
        }

        if ($orderStmt->rowCount() > 0 && $orderItemsStmt->rowCount() > 0) {
           
            $_SESSION["success_msg"]= "Order successfully placed!";
            header("Location:admin.index.php");
        } else {
            $_SESSION["error_msg"]= "Failed to place the order. Please try again.";
            header("Location:admin.index.php");
        }
    } else {
        $_SESSION["error_msg"]="Error: No user selected";
    }
}
?>
