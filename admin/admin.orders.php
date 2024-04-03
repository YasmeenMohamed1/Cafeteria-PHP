<?php
        session_start();

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
?>


<?php (@include ("../layouts/header.php")) or die(" file not exist"); ?>
<?php (@include ("../layouts/admin.nav.php")) or die(" file not exist"); ?>


    <style>
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
      
    </style>



    <div class="container">
    <h1 class="mb-5 pt-5 text-center fw-bolder text-primary text-lg">Orders</h1>
    

    

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Order Date</th>
                <th scope="col">Name</th>
                <th scope="col">Room</th>
                <th scope="col">Ext</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            

            require("../DB_Connection.php");
            $db=new db();

            
           
            $sql = "SELECT o.created_at AS Date, u.user_name AS Name, r.room_no AS Room, e.ext_no AS Ext, o.id AS OrderID 
            FROM `order` o 
            INNER JOIN user u ON o.user_id = u.id 
            INNER JOIN room r ON u.room_id = r.id 
            INNER JOIN ext e ON r.ext_id = e.id 
            where o.status = 'Processing';";

            

            $query = $db->get_connection()->query($sql);
            


            // $query = $db->select_column("id,created_at,status,price","`order`");
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($result);

            // Step 3: Output the data into the table
            if (count($result) > 0) {
                foreach ($result as $row) {
                    
                    echo "<tr class='order-date-row'>";
                    // echo "<td>" . $row["created_at"] . "</td>";
                    echo "<td > 
                    <div class='d-flex justify-content-between'>
                        <div>". $row["Date"] ."</div>
                        
                    </div> 
                    </td>";
                    echo "<td>" . $row["Name"] . "</td>";
                    echo "<td>" . $row["Room"] . "</td>";
                    echo "<td>" . $row["Ext"] . "</td>";
                    echo "<td><a href='admin.orders.controllers.php?id={$row['OrderID']}'>Deliver</a></td>";
                    echo "</tr>";

                    echo "<tr class='' >";
                    echo "<td colspan='5'>";
                    echo "<div class='d-flex justify-content-around' style='display: table-row;'>";
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
                        oi.order_id = '.$row["OrderID"].'
                    GROUP BY 
                    oi.order_id, oi.product_id
                ');

                    $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                    // var_dump($result2);
                    foreach ($result2 as $row) {
                    echo "<div class='order-item'>";
                    echo "<div class='image'><img width='50' height='50' src='../assets/img/products/" . $row['image'] . "' alt='" . $row['pro_name'] . "'></div>";

                    echo "<div class='product-name'> " . $row['pro_name'] . "</div>";
                    echo "<div class='quantity'>" . $row['quantity'] . "</div>";
                    // echo "<div class='image'><img width='50' height='50' src='assets/img/products/" . $row['image'] . "' alt='" . $row['pro_name'] . "'></div>";
                    echo "<div class='total-price '>$" . $row['total_price'] . "</div>";
                    // Assuming the price is available in the $row
                    // echo "<div class='price'>Price: $" . $row['price'] . "</div>";
                    echo "</div>";
                    }
                    echo "<div class='price align-self-end'>Total Price: $" . $row['price'] . "</div>";
                    
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No orders found</td></tr>";
            }
            
            // $totalPages = ceil(count($result) / $recordsPerPage);

            // // Add navigation links
            // echo "<div class='pagination'>";
            // if ($page > 1) {
            //     echo "<a href='?page=" . ($page - 1) . "' class='btn btn-primary'>Previous</a>";
            // }
            // for ($i = 1; $i <= $totalPages; $i++) {
            //     echo "<a href='?page=$i' class='btn btn-primary'>$i</a>";
            // }
            // if ($page < $totalPages) {
            //     echo "<a href='?page=" . ($page + 1) . "' class='btn btn-primary'>Next</a>";
            // }
            // echo "</div>";
            ?>
        </tbody>
    </table>
    
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

<?php (@include ("./layouts/footer.php")) or die(" file not exist"); ?>