<?php
require("../DB_Connection.php");
$db=new db();


$id=$_GET['id'];
var_dump($id);

$query1 = $db->get_data("`order`","id={$id}");
$result1 = $query1->fetch(PDO::FETCH_ASSOC);

var_dump($result1["status"]);

session_start();


    $db->update_data("`order`","status = 'Out for delivery'","id={$id}");
    // $db->delete_data("`order_items`","order_id={$id}");
    // $db->delete_data("`order`","id={$id}");

    $_SESSION['alert'] = array(
        'type' => 'success',
        'message' => 'The order delivered succefully'
    );

    header('Location: admin.orders.php');

?>

