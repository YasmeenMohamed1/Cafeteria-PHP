<?php
require("DB_connection.php");

if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    try {
        $stmt = $pdo->prepare("SELECT pro_name, price, image FROM product WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo json_encode($product);
        } else {
            echo json_encode(["error" => "Product not found"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Product ID not specified"]);
}