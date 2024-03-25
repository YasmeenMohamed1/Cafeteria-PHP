<?php
class db{

private $host="localhost";
private $dbname="php_test";
private $user="root";
private $pass="";
private $connection="";


function __construct(){
    $this ->connection = new pdo("mysql:host=$this->host;dbname=$this->dbname",$this->user,$this->pass);
}



function get_connection(){
    return $this->connection;
}

function get_data($table,$cond=1){
    return $this->connection->query("select * from $table where $cond");
}

function delete_data($table,$cond=1){
    return $this->connection->query("delete from $table where $cond");
}

function insert_data($table,$cols,$values){
    return $this->connection->query("insert into $table($cols) values ($values)");
}

function update_data($table, $set_values, $cond=1) {
    return $this->connection->query("update $table set $set_values where $cond");
}


}


//How to use this class?
//To connect database in another pages write the following
// require("db.php");
// $db=new db(); these two lines must be writen in the page
//then you can use the functions in thid class
// EX:
// 1- $db->delete_data("employees","id='$id'");
// 2- $result = $db->get_data("employees","id='$id'");
// 3- $result = $db->get_data("employees","username='{$_POST['username']}' and pass='{$_POST['password']}'");
// 4- $db->insert_data("employees","firstName,lastName,address,gendre,pass,username,country,img",
    // "'$firstName','$lastName','$address','$gender','$password','$username','$country','$img'");
// 5- $db->update_data("employees","firstName='{$_POST['firstName']}', lastName='{$_POST['lastName']}',
// address='{$_POST['address']}', gendre='{$_POST['gender']}',pass='{$_POST['password']}', 
// username='{$_POST['username']}',country='{$_POST['country']}',img='$img'",
// "id='$id'");
?>
