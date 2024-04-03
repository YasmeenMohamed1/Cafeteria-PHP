<?php

require("../../DB_Connection.php");
$database = new db();

$rooms=$database->get_data("room");
$rooms = $rooms->fetchAll(PDO::FETCH_ASSOC);
    
    // echo "<pre>";
    // var_dump($rooms);
    // echo "</pre>";
?>