<?php
ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);
// if(empty($_COOKIE['email'])){
//     header('Location:login.php');
// }
require("../DB_Connection.php");
$id=$_REQUEST['id'];
$result= $connection->delete_data("user","id='$id'");
header("Location:AllUsers.php");
?>