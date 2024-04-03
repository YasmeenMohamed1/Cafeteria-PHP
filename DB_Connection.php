<?php
class db
{

    private $host = "localhost";
    private $dbname = "cafe_project";
    private $user = "root";
    private $pass = "";
    private $connection = "";


    function __construct()
    {
        try {
            $this->connection = new pdo("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    function get_connection()
    {
        return $this->connection;
    }

    function get_data($table, $cond = 1)
    {
        try {
            return $this->connection->query("select * from $table where $cond");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function select_column($col,$table,$cond=1){
        try {
        return $this->connection->query("select $col from $table where $cond");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function select_count($table,$cond=1){
        try {
        return $this->connection->query("select count(*) as count from $table where $cond");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function get_data_with_limit($table, $start = 0, $offset = 4)
    {
        try {
            return $this->connection->query("select * from $table limit $start,$offset ");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function delete_data($table, $cond = 1)
    {
         try{
            return $this->connection->query("delete from $table where $cond");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function insert_data($table, $cols, $values)
    {
        try{
            return $this->connection->query("insert into $table($cols) values ($values)");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function update_data($table, $set_values, $cond = 1)
    {
        try{
            return $this->connection->query("update $table set $set_values where $cond");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

$connection= new db;

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
