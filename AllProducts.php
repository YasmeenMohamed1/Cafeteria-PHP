<?php

(@include ("./layouts/header.php")) or die(" file not exist");
(@include ("./layouts/admin.nav.php")) or die(" file not exist");
?>

<?php
(@include ("./layouts/footer.php")) or die(" file not exist");
?>

    
<?php
require("DB_Connection.php");

ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);
echo "<table class='table' border=2>
<tr class='table-secondary'>
<th>ID</th>
<th>Product Name</th>
<th>Quantity</th>
<th>Price</th>
<th>Image</th>
<th>Category</th>
<th colspan='3'>Controllers</th>



</tr>";
$available=0;
$connection= new db;
$result=$connection->get_data('product');
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr >";
    foreach ($row as $key=>$value) {
        if ($key=="image") {
            if(!empty($value)){
                echo "<td><img src='./assets/img/products/$value' height='70' width='70' ></td>";

            }
           
            
            else{
                echo "<td></td>";
            }
        }
        else  if ($key=="quantity") {
            if($value>0){
                $available=1;
            }
            else{
                $available=0;

            }
            echo "<td>$value</td> ";

            
        }
        else if($key=="category_id"){
            $result2=$connection->get_data('category', "id=$value");
            $cat = $result2->fetch(PDO::FETCH_ASSOC);
                
                foreach($cat as $k=>$val){
                    if ($k=="cat_name") {
                           echo "<td>$val</td>";

                    }
                }}

        else if($key=="price"){
            echo "<td>$value EGP</td> ";
                }
        else{
        echo "<td>$value</td>";
        }
    }
    echo "<td>";
    
    if($available>0){
    echo "<a href='show.php?id={$row['id']}' class='btn btn-success'>Available</a>";
    }
    else{
        echo "<p class='btn btn-dark'>Out of stock</p>";

    }
    echo "
    <a href='edite.php?id={$row['id']}' class='btn btn-warning'>Edit</a> 
    <a href='deleteProduct.php?id={$row['id']}' class='btn btn-danger'>Delete</a> 
     </td>";
    echo "</tr>";
    //edit button is pending 
}

?>  
<style>
    td{
        color:white;
    }
    
    img{
        border-radius: 20px;
    }
    .table{
        width:70%;
        margin: auto;
        border-radius: 10px;
    }
    
</style>