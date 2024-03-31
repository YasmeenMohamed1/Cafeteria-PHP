<?php
require("../DB_Connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $orderNotes = $_POST["orderNotes"];
    $total = $_POST["total"];
    $cartItems = $_POST["cartItems"];
} else {
    echo "Invalid request method.";
}
