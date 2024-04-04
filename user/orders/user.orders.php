<?php
session_start();

if(empty($_SESSION['user_name'])){
    header("location:../../login.php");
}

        // Check if an alert is set in the session
        if (isset($_SESSION['alert'])) {
            // Output alert message with appropriate styling based on the alert type
            $alert = $_SESSION['alert'];
            $alertType = $alert['type'];
            $alertMessage = $alert['message'];

            echo "<div class='alert alert-$alertType'>$alertMessage</div>";
            // $color = ($alertType === 'success') ? 'green' : 'red';
            // echo "<script style='color:{$color}'>alert('$alertMessage');</script>";

            // Clear the alert from the session to avoid showing it again
            unset($_SESSION['alert']);
        }
$_SESSION['home_path']="../cart/user.index.php";
$_SESSION['orders_path']="user.orders.php";        

$_SESSION['css_path']= "../../assets/css/temp_styles.css";
$_SESSION['nav-image']= "../../assets/img/users/{$_SESSION['image']}";

 (@include ("../../layouts/header.php")) or die(" file not exist"); 
(@include ("../../layouts/user.nav.php")) or die(" file not exist"); 
?>

<div class="container">
    <h1 class="mb-5 pt-5 text-center fw-bolder text-primary text-lg">My Orders</h1>
    <div class="row mb-5">
   
        <form  method="post"  class="row justify-content-center">
            <div class="col-md-6 text-center">
                    <label for="dateFrom">Date From:</label>
                    
                    <input type="date" id="dateFrom" name="dateFrom"  >
            </div>

            <div class="col-md-6 text-center">
                    <label for="dateTo">Date To:</label>
                    <input type="date" id="dateTo" name="dateTo" >
                
            </div>

            <div class="col-md-6 text-center">
                <input type="submit" value="Filter" name="sort" class="btn btn-primary ">
            </div>
        </form>
    </div>

    

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Order Date</th>
                <th scope="col">Status</th>
                <th scope="col">Amount</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            $dateFrom = $_POST['dateFrom'] ?? null;
            $dateTo = $_POST['dateTo'] ?? null;
            // echo($dateFrom);
            // echo($dateTo);

            require("../../DB_Connection.php");
            $db=new db();

            $page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page number
            $recordsPerPage = 3; // Number of records per page
            // Calculate the offset
            $offset = ($page - 1) * $recordsPerPage;
           
            $sql = 'SELECT 
            id, created_at, status, price
            FROM 
                `order`
            WHERE user_id =  '.$_SESSION["id"].' ';

            $allOrders='SELECT 
            id, created_at, status, price
            FROM 
                `order`
            WHERE user_id =  '.$_SESSION["id"].' ';

            // Add date conditions if provided
            if ($dateFrom != null) {
              
                $sql .= " AND Date(created_at) >= '$dateFrom'";
                $allOrders .= " AND Date(created_at) >= '$dateFrom'";
               
            }
            if ($dateTo != null) {
                
                $sql .= " AND Date(created_at) <= '$dateTo'";
                $allOrders .= " AND Date(created_at) <= '$dateTo'";
               
            }

            $sql .= " LIMIT $recordsPerPage OFFSET $offset";

           
            $query = $db->get_connection()->query($sql);
            $allOrders = $db->get_connection()->query($allOrders);

            // $query = $db->select_column("id,created_at,status,price","`order`");
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $allOrders = $allOrders->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($allOrders);
            // Step 3: Output the data into the table
            if (count($result) > 0) {
                foreach ($result as $row) {
                    echo "<tr class='order-date-row'>";
                    // echo "<td>" . $row["created_at"] . "</td>";
                    echo "<td > 
                    <div class='d-flex justify-content-between'>
                        <div>". $row["created_at"] ."</div>
                        <div class='toggle-btn btn btn-primary'>+</div>
                    </div> 
                    </td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td><a href='user.orders.controllers.php?id={$row['id']}'>Cancel</a></td>";
                    echo "</tr>";

                    echo "<tr class='order-details' style='display: none;'>";
                    echo "<td colspan='4'>";
                    echo "<div class='d-flex justify-content-around'>";
                    $query2 = $db->get_connection()->query('SELECT 
                    oi.product_id,
                    oi.quantity,
                    p.pro_name,
                    p.image,
                    o.price,
                    p.price * oi.quantity AS total_price
                    FROM 
                        order_items oi
                    JOIN 
                        product p ON oi.product_id = p.id
                    JOIN 
                        `order` o ON oi.order_id = o.id
                    WHERE 
                        oi.order_id = '.$row["id"].'
                    GROUP BY 
                    oi.order_id, oi.product_id
                ');

                    $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                    // var_dump($result2);
                    foreach ($result2 as $row) {
                    echo "<div class='order-item'>";
                    echo "<div class='image'><img width='50' height='50' src='assets/img/products/" . $row['image'] . "' alt='" . $row['pro_name'] . "'></div>";

                    echo "<div class='product-name'> " . $row['pro_name'] . "</div>";
                    echo "<div class='quantity'>" . $row['quantity'] . "</div>";
                    // echo "<div class='image'><img width='50' height='50' src='assets/img/products/" . $row['image'] . "' alt='" . $row['pro_name'] . "'></div>";
                    echo "<div class='total-price menu-price'>$" . $row['total_price'] . "</div>";
                    // Assuming the price is available in the $row
                    // echo "<div class='price'>Price: $" . $row['price'] . "</div>";
                    echo "</div>";
                    }
                    echo "<div class='price align-self-end' >Total Price: $" . $row['price'] . "</div>";
                    
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No orders found</td></tr>";
            }
            
            
            ?>
        </tbody>
    </table>

    <?php
    $totalPages = ceil(count($allOrders) / $recordsPerPage);
     
    echo "<div class='d-flex justify-content-center'>";
    echo "<div class='pagination mt-4 mb-5 '>";
    if ($page > 1) {
        echo "<a href='?page=" . ($page - 1) . "' class='btn btn-primary'>Previous</a>";
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a href='?page=$i' class='btn btn-primary'>$i</a>";
    }
    if ($page < $totalPages) {
        echo "<a href='?page=" . ($page + 1) . "' class='btn btn-primary'>Next</a>";
    }
    echo "</div>";
    echo "</div>";

    ?>
    
</div>

    <script>
        
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const row = btn.closest('.order-date-row').nextElementSibling;
                row.style.display = (row.style.display === 'none' || row.style.display === '') ? 'table-row' : 'none';
                btn.textContent = (btn.textContent === '+') ? '-' : '+';
            });
        });
    </script>

 

<?php (@include ("../../layouts/footer.php")) or die(" file not exist"); ?>
