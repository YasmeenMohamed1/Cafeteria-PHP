<?php
(@include ("../layouts/header.php")) or die(" file not exist");
(@include ("../layouts/admin.nav.php")) or die(" file not exist");
?>

<style>
    .inner-table {
        width: 100%;
    }
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


    <h1 class="mt-4">Checks</h1>

    
    <table class="table">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            ini_set("display_errors",1);
            ini_set("display_startup_errors",1);
            error_reporting(E_ALL);
            if(empty($_SESSION['user_name'])){
                header("location:../login.php");
            }
            require ('../DB_Connection.php');
            $connection=new db;
            $result = $connection->get_data('user');
            while ($user_row = $result->fetch(PDO::FETCH_ASSOC)) { 
                $total_amount = 0;
                $result_order = $connection->get_data('`order`', "user_id = {$user_row['id']}");
                while ($order_row = $result_order->fetch(PDO::FETCH_ASSOC)) {
                    $total_amount += 100; // replace with your logic to calculate total amount
                }
                ?>
                <tr class="order-row">
                    <td class="order-name">
                        <div class="d-flex align-items-center">
                            <span class="toggle-btn btn btn-primary">+</span>
                            <span><?php echo $user_row['user_name']; ?></span>
                        </div>
                    </td>
                    <td><?php echo '$' . $total_amount; ?></td>
                </tr>
                <tr class="order-details" style="display: none;">
                    <td colspan="2">
                        <table class="inner-table">
                            <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>Account</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result_order = $connection->get_data('`order`', "user_id = {$user_row['id']}");
                                while ($order_row = $result_order->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr class="order-date-row">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="toggle-btn toggle-date-btn btn btn-primary">+</span>
                                                <span><?php echo $order_row['created_at']; ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo $order_row['price']; ?></td>
                                    </tr>
                                    <tr class="order-details" style="display: none;">
                                        <td colspan="2">
                                            <div class="order-items">
                                                <?php
                                                $order_id = $order_row['id'];
                    
   

                                                $result_order_items = $connection->get_data('`order`', "id= $order_id");

                                                while ($item_row = $result_order_items->fetch(PDO::FETCH_ASSOC)) {


                                                ?>
                                                <table>
                                                    <tr>
                                                        <th>
                                                            Price
                                                        </th>
                                                        <th>
                                                            Status
                                                        </th>
                                                        <th>
                                                            Notes
                                                        </th>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        <div><?php echo $item_row['price']; ?></div>

                                                        </td>
                                                        <td>
                                                        <div><?php echo $item_row['status']; ?></div>
                                                        </td>
                                                        <td>
                                                        <div><?php echo $item_row['notes']; ?></div>
                                                        </td>
                                                    </tr>
                                                    <?php

                                                    
                                                    ?>
                                                </table>
                                                    
                                                <?php
                                                }
                                                
                                                ?>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const detailsRow = btn.closest('.order-row').nextElementSibling;
            detailsRow.style.display = (detailsRow.style.display === 'none' || detailsRow.style.display === '') ? 'table-row' : 'none';
            btn.textContent = (btn.textContent === '+') ? '-' : '+';
        });
    });

    document.querySelectorAll('.toggle-date-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const itemsRow = btn.closest('.order-date-row').nextElementSibling;
            itemsRow.style.display = (itemsRow.style.display === 'none' || itemsRow.style.display === '') ? 'table-row' : 'none';
            btn.textContent = (btn.textContent === '+') ? '-' : '+';
        });
    });
</script>
<?php (@include ("./layouts/footer.php")) or die(" file not exist"); ?>