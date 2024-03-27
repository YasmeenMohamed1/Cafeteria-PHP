<?php
session_start();
(@include ("./layouts/header.php")) or die(" file not exist");
(@include ("./layouts/user.nav.php")) or die(" file not exist");


// database connection 
try{
require("DB_Connection.php");
//query to get data from database
$database=new db();
$result=$database->get_data("product");
$data=$result->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
var_dump($data);
echo "</pre>";
} catch (PDOException $e) {
    echo $e->getMessage();
 }
//close
$connection=null;
?>
<!-- <div class="container mt-5">
    <div class="row">
        <div class="col-8 offset-4">
                    <div class="d-flex mb-5">
                        <div class="col-md-3 col-6 cont">
                            <img class="w-50 rounded-circle mb-3 mb-sm-1" src="assets/img/product/menu-1.jpg" alt="">
                            <h5 class="menu-price text-sm">$5</h5>
                            <h4 class="text-sm">Black Coffee</h4>
                        </div>
                        <div class="col-md-3 col-6 cont">
                            <img class="w-50 rounded-circle mb-3 mb-sm-1" src="assets/img/product/menu-1.jpg" alt="">
                            <h5 class="menu-price text-sm">$5</h5>
                            <h4 class="text-sm">Black Coffee</h4>
                        </div>
                    </div>
                    
        </div>
    </div>
</div> -->
<div class="container mt-5">
    <div class="row">
        <div class="col-8 offset-4">
        <h5 class="mb-3 lastproduct">last Products</h5>
        <h5 class="mb-3 allproduct">All Products</h5>
        <div class="d-flex flex-wrap mb-5">
            <?php
            foreach($data as $product){
                ?>
               
                <div class="col-md-3 col-6 cont mb-5">
                    <div class="position-relative">
                        <img class="w-50 rounded-circle mb-3 mb-sm-1" src="assets/img/product/menu-1.jpg" alt="">
                        <h5 class="menu-price text-sm">$5</h5>
                        <h4 class="text-sm">Black Coffee</h4>
                    </div>
                </div>
           
            <?php 
            }
            ?>
            </div>
        </div>
    </div>
</div>

<?php
(@include ("./layouts/footer.php")) or die(" file not exist");
?>

    
       