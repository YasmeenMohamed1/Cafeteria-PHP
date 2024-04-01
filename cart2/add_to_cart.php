<?php
session_start();
// session_destroy();
if(isset($_SESSION['cart'])){
    $product_ids = array_column($_SESSION['cart'], 'id');
    if(!in_array($_POST['id'],$product_ids)){
      
        $product_arr=array(
            "id"=>$_POST['id'],
            "pro_name"=>$_POST['name'],
            "price"=>$_POST['price'],
            "quantity"=>$_POST['quantity']
           );
       
           $_SESSION['cart'][] = $product_arr;
        }
}else{

    $product_arr=array(
     "id"=>$_POST['id'],
     "pro_name"=>$_POST['name'],
     "price"=>$_POST['price'],
     "quantity"=>$_POST['quantity']
    );

    $_SESSION['cart'][] = $product_arr;
}

?>