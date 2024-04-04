<?php
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
// add to order to database
?>
<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: ../../login.php");
    exit(); 
}

$user_id = $_SESSION['id'];

$orderData = $_POST;

include_once("../../db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $products = $_POST['products'];
    $orderNotes = $_POST['orderNotes'];
    $totalPrice = $_POST['totalprice'];
   $orderDateTime = $_POST['orderDateTime'];
    $user_id = $_SESSION['id'];


    $allProductsAvailable = true;

    
    $orderSql = "INSERT INTO `order` (notes, price, user_id, created_at) VALUES (?, ?, ?, ?)";
    $orderStmt = $pdo->prepare($orderSql);
    $orderStmt->execute([$orderNotes, $totalPrice, $user_id, $orderDateTime]);


    $orderId = $pdo->lastInsertId();

    $orderItemsSql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
    $orderItemsStmt = $pdo->prepare($orderItemsSql);



    foreach ($products as $productId => $product) {
        $productId = $product['id'];
        $quantity = $product['quantity'];

        $productQuery = $pdo->prepare("SELECT quantity FROM product WHERE id = ?");
        $productQuery->execute([$productId]);
        $productData = $productQuery->fetch(PDO::FETCH_ASSOC);
        $currentStock = $productData['quantity'];

        if ($quantity > $currentStock) {
            $allProductsAvailable = false;
            continue;
        }

        $newStock = $currentStock - $quantity;
        $updateStockQuery = $pdo->prepare("UPDATE product SET quantity = ? WHERE id = ?");
        $updateStockQuery->execute([$newStock, $productId]);

        $orderItemsStmt->execute([$orderId, $productId, $quantity]);
    }

    if ($allProductsAvailable) {
        if ($orderStmt->rowCount() > 0 && $orderItemsStmt->rowCount() > 0) {
                    
            $_SESSION["success_msg"]= "Order successfully placed!";
            header("Location:../orders/user.orders.php");
        } else {
            $_SESSION["error_msg"]= "Failed to place the order. Please try again.";
            header("Location:user.index.php");
        }
    
    }
    else {
        $_SESSION["error_msg"]="One or more products are out of stock. Please check your order and try again.";
        header("Location:user.index.php");
    }


}
?>