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
$ext_id=1;
$result=$connection->get_data('user');
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr  >";
    foreach ($row as $key=>$value) {
        if ($key=="image") {
            if(!empty($value)){
                echo "<td><img src='./assets/img/users/$value' height='70' width='70' ></td>";

            }
           
            
            else{
                echo "<td></td>";
            }
        }
        else  if ($key=="password") {
      
        }
        else  if ($key=="room_id") {
            $result2=$connection->get_data('room',"id=$value");
            $room = $result2->fetch(PDO::FETCH_ASSOC);
                
                foreach($room as $k=>$val){
                    if ($k=="room_no") {
                           echo "<td>$val</td>";

                    }
                    if ($k=="ext_id") {
                        echo "<td>$val</td>";


                 }
                }}

        else{
        echo "<td>$value</td>";
        }
    }
    echo "<td>";
    echo "
    <a href='edite.php?id={$row['id']}' class='btn btn-warning'>Edit</a> 
    <a href='deleteUser.php?id={$row['id']}' class='btn btn-danger'>Delete</a> 
     </td>";
    echo "</tr>";
    //edit button is pending 
}

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