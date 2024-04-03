<?php
ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);

require("connect.php");
 $room_id=$_REQUEST["room"];
 $room= $connection->get_data("room","room_no = $room_id");
 $result = $room->fetch(PDO::FETCH_ASSOC);
 var_dump( $result );
$room_no = $result['room_no'];
$id=$_REQUEST['id'];
var_dump($_REQUEST);
$result=$connection->update_Data("user","`user_name`='{$_REQUEST['username']}',`role`='{$_REQUEST['role']}'","id=$id");
// header("Location:AllUsers.php");

?>