<?php

$host = 'localhost'; 
$dbname = 'cafe_project';
$username = 'root'; 
$password = ''; 

try {
    
    $database = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   
    die("Connection failed: " . $e->getMessage());
}


session_start();


if (isset($_POST['id'])) {
    $productId = $_POST['id'];

    
    $product = getProductDetails($productId);

    
    if ($product) {
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        array_push($_SESSION['cart'], $product);

        
        echo displayCartItems($_SESSION['cart']);
    } else {
        echo "Product not found";
    }
} else {
    echo "Product ID not specified";
}


function getProductDetails($productId)
{
    global $database;

    
    $stmt = $database->prepare("SELECT * FROM product WHERE id = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    return $product ? $product : false; 
}


function displayCartItems($cart)
{
    
    $output = '<table class="table">';
    $output .= '<thead><tr><th>Product</th><th>Price</th></tr></thead>';
    $output .= '<tbody>';
    foreach ($cart as $item) {
        $output .= '<tr>';
        $output .= '<td>' . $item['pro_name'] . '</td>';
        $output .= '<td>' . $item['price'] . '</td>';
        $output .= '</tr>';
    }
    $output .= '</tbody>';
    $output .= '</table>';
    return $output;
}