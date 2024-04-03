<?php
ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);

require("connect.php");
$category=$_REQUEST["category"];
$query= $connection->select_column("id","category","cat_name = '{$category}'");
$result = $query->fetch(PDO::FETCH_ASSOC);
$catID = $result['id'];
$id=$_REQUEST['id'];
var_dump($_REQUEST);
$result=$connection->update_Data("product","`quantity`='{$_REQUEST['quantity']}',`price`='{$_REQUEST['price']}',`category_id`='{$catID}'","id=$id");
header("Location:AllProducts.php");

?>