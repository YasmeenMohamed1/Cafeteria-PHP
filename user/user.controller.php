<?php

//connect to database
require("../DB_Connection.php");
$database = new db();

$limit=3;
$page=0;
$display="";

if(isset($_POST['page'])){
    $page=$_POST['page'];
}else{
    $page=1;
}

$start = ( $page - 1 ) * $limit;

$result = $database->get_data_with_limit("product",$start,$limit);
$products = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // echo "<pre>";
    // var_dump($data);
    // echo "</pre>";

$records=$database->get_data("product");
$num_of_rows=$records->rowCount();
  
$pages=ceil($num_of_rows/$limit);


 if($num_of_rows > 0){
   $display.='<div class="d-flex flex-wrap mb-5">';
    foreach ($products as $product) {
     $display .='
        <div class="col-md-4 col-lg-3 col-6 cont mb-5 proItem">
            <div class="position-relative">
                <img class="w-50 rounded-circle mb-3 mb-sm-1 " style="height:80px;" src="../assets/img/products/'.$product["image"].'" alt="">
                <h5 class="menu-price text-sm"> $'.$product["price"].'</h5>
                <h4 class="text-sm w-50 text-center">'.$product["pro_name"].'</h4>
                <input type="hidden" class="id" value="'.$product["id"].'">
                <input type="hidden" class="name" value="'.$product["pro_name"].'">
                <input type="hidden" class="price" value="'.$product["price"].'">
                <input type="hidden" class="quantity" value="'.$product["quantity"].'">
            </div>
        </div>
              ';

    }
   $display .='</div>';
    }else{
        $display .='
        <div class="col-6 cont mb-5">
            <div class="alert alert-warning">
              Oooops There isn\'t any Product Yet 
            </div>
        </div>
              ';
    }

  $display .='<div>
                   <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">';

if ($page > 1) {
    $previous = $page - 1;
    $display .= '<li class="page-item" id="1"><span class="page-link">First</span></li>';
}        

for ($i = 1; $i <= $pages; $i++) {
    $active_class = "";
    if ($i == $page) {
        $active_class = "active";
    }
    $display .= '<li class="page-item ' . $active_class . '" id="' . $i . '"><span class="page-link">' . $i . '</span></li>';
}

if ($page < $pages) {
    $next = $page + 1;
    $display .= '<li class="page-item" id="'.$pages.'"><span class="page-link">Last</span></li>';           
}

  $display .= '</ul></nav></div>';

  echo $display;
//close
$connection = null;
?>