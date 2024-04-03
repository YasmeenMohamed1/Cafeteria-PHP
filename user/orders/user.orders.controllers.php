<?php
require("../../DB_Connection.php");
$db=new db();


$id=$_GET['id'];
var_dump($id);

$query1 = $db->get_data("`order`","id={$id}");
$result1 = $query1->fetch(PDO::FETCH_ASSOC);

var_dump($result1["status"]);

session_start();


if($result1["status"] == "Processing")
{
    
    $db->delete_data("`order_items`","order_id={$id}");
    $db->delete_data("`order`","id={$id}");

    $_SESSION['alert'] = array(
        'type' => 'success',
        'message' => 'The order cancelled succefully'
    );

    header('Location: user.orders.php');

}
else
{
    $_SESSION['alert'] = array(
        'type' => 'danger',
        'message' => ' You can not cancel the order if it is not in processing stage'
    );

    header('Location: user.orders.php');

}

// $sql = "SELECT 
//             *
//             FROM 
//                 `order`
//             WHERE status = Processing ";
?>