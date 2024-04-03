<?php

(@include ("../layouts/header.php")) or die(" file not exist");
(@include ("../layouts/admin.nav.php")) or die(" file not exist");
?>


    
<?php
require("../DB_Connection.php");

ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);

// Define the number of rows to display per page
$rowsPerPage = 5;

// Get the current page from the query string
if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

// Calculate the offset for the query
$offset = ($currentPage - 1) * $rowsPerPage;

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

$available = 0;

$result = $connection->get_data_with_limit('product',$offset, $rowsPerPage);

while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    foreach ($row as $key=>$value) {
        if ($key == "image") {
            if (!empty($value)) {
                echo "<td><img src='../assets/img/products/$value' height='70' width='70' ></td>";
            } else {
                echo "<td></td>";
            }
        } else if ($key == "quantity") {
            if ($value > 0) {
                $available = 1;
            } else {
                $available = 0;
            }
            echo "<td>$value</td>";
        } else if ($key == "category_id") {
            $result2 = $connection->get_data('category', "id=$value");
            $cat = $result2->fetch(PDO::FETCH_ASSOC);
            foreach($cat as $k=>$val) {
                if ($k == "cat_name") {
                    echo "<td>$val</td>";
                }
            }
        } else if ($key == "price") {
            echo "<td>$value EGP</td>";
        } else {
            echo "<td>$value</td>";
        }
    }
    echo "<td>";
    if ($available > 0) {
        echo "<a href='show.php?id={$row['id']}' class='btn btn-success'>Available</a>";
    } else {
        echo "<p class='btn btn-dark'>Out of stock</p>";
    }
    echo "
    <a href='edit.product.php?id={$row['id']}' class='btn btn-warning'>Edit</a> 
    <a href='deleteProduct.php?id={$row['id']}' class='btn btn-danger'>Delete</a> 
     </td>";
    echo "</tr>";
}

echo "</table>";

$totalRows = $connection->get_data('product')->rowCount();

$totalPages = ceil($totalRows / $rowsPerPage);

echo "<nav aria-label='Page navigation'>";
echo "<ul class='pagination'>";
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<li class='page-item' class='btn btn-secondary'><a class='page-link' href='?page=$i'>$i</a></li>";
}
echo "</ul>";
echo "</nav>";
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

<?php
(@include ("../layouts/footer.php")) or die(" file not exist");
?>
