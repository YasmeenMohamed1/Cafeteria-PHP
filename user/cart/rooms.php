<?php
session_start();
require($_SESSION['rooms']);
$database = new db();

$rooms=$database->get_data("room");
$rooms = $rooms->fetchAll(PDO::FETCH_ASSOC);
    
    // echo "<pre>";
    // var_dump($rooms);
    // echo "</pre>";
?>