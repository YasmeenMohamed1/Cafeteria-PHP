<?php
session_start() 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Business Casual - Start Bootstrap Theme</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet" />
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?= $_SESSION['css_path']?>" rel="stylesheet" />

    <style>
        /* Custom background color */
        .custom-bg {
            background-color: #faebd7;
            /* background-color: #F9E0BB; */
        }

        .text-color_dark_cafe {
            color: #884A39;
        }


        /********************************user style*************************************/
        .col-8 {
            color: white;
        }

        .cont {
            position: relative;
        }

        .menu-price {
            position: absolute;
            margin: 0;
            top: -8px;
            right: 90px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #33211d;
            background: #da9f5b;
        }

        .text-sm {
            font-size: 1rem;
        }

        .lastproduct,
        .allproduct {
            color: #fff;
            font-size: 25px;
            margin-bottom: 30px !important;
        }

        .allproduct {
            padding-top: 15px;
            border-top: solid white 3px;
        }

        hr {
            border: 0;
            height: 6px;
            background: white;
            margin: 20px 0;
        }

        .quantity {
            width: 50px !important;
        }
      /**********************************order style*****************************/
      .order-details {
            display: none;
        }
        .order-date {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
       
        .table {
            border: 1px solid #2f170fe6;
            background-color:#f1e7d8;
            color:#2f170fe6;
        }
        .table th, .table td {
            border: 1px solid #2f170fe6;
        }
        .order-items {
            display: flex;
        }
        /*******************************login**************************/
        .card {
        margin-top: 95px;
        margin-bottom: 225px;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        background-color: #f1e7d8;
        }
        .form-group {
            margin-bottom: 20px;
        }
        /* .btn-primary {
            width: 100%;
        } */
        legend,label{
        color: #2f170fe6;
    }
    </style>

</head>

<body>