<?php

(@include ("./layouts/header.php")) or die(" file not exist");
(@include ("./layouts/admin.nav.php")) or die(" file not exist");
?>

<?php
(@include ("./layouts/footer.php")) or die(" file not exist");
?>

  
<?php
require("connect.php");

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
<th>Name</th>
<th>E-mail</th>
<th>Image</th>
<th>Role</th>
<th>Room</th>
<th>Extension</th>
<th colspan='2'>Controllers</th>
</tr>";

$result = $connection->get_data_with_limit('user',$offset, $rowsPerPage);

while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    foreach ($row as $key=>$value) {
        if ($key == "image") {
            if (!empty($value)) {
                echo "<td><img src='./assets/img/users/$value' height='70' width='70'></td>";
            } else {
                echo "<td></td>";
            }
        } else if ($key == "password") {
            continue;
        } else if ($key == "room_id") {
            $result2 = $connection->get_data('room', "id=$value");
            $room = $result2->fetch(PDO::FETCH_ASSOC);
            foreach($room as $k=>$val) {
                if ($k == "room_no") {
                    echo "<td>$val</td>";
                }
                if ($k == "ext_id") {
                    echo "<td>$val</td>";
                }
            }
        } else {
            echo "<td>$value</td>";
        }
    }
    echo "<td>";
    echo "
    <a href='edit.user.php?id={$row['id']}' class='btn btn-warning'>Edit</a> 
    <a href='deleteUser.php?id={$row['id']}' class='btn btn-danger'>Delete</a> 
     </td>";
    echo "</tr>";
}

echo "</table>";

$totalRows = $connection->get_data('user')->rowCount();
$totalPages = ceil($totalRows / $rowsPerPage);

// Display pagination links
echo "<nav aria-label='Page navigation'>";
echo "<ul class='pagination'>";
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<li class='page-item' class='btn btn-secondary'><a class='page-link' href='?page=$i'>$i</a></li>";
}
echo "</ul>";
echo "</nav>";
?>
<style >
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