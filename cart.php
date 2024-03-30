<?php

(@include("./layouts/header.php")) or die(" file not exist");
(@include("./layouts/user.nav.php")) or die(" file not exist");
?>



<?php

session_start();
require('DB_Connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {

    $notes = $_POST['notes'];
    $totalPrice = $_POST['total'];
    $sql = "INSERT INTO `order` (price, notes) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$totalPrice, $notes]);

    if ($stmt->rowCount() > 0) {
        echo "order saved";
    } else {
        echo "error saving";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4" style="background-color: beige; margin-top: 10px;">
                <h5 class="text-center">Cart Items</h5>
                <?php
                $Total = 0;
                if (isset($_SESSION['cart'])) { ?>
                <table class="table table-bordered">
                    <thead>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <?php
                            $index = 0;
                            foreach ($_SESSION['cart'] as $key => $val) {
                                $totalPrice = $val['quantity'] * $val['price'];
                                $Total += $totalPrice;
                            ?>
                        <tr>
                            <td><?= $val['pro_name'] ?></td>
                            <td><?= $val['quantity'] ?></td>
                            <td><?= $totalPrice ?></td>
                            <td><a href="actionCart.php?action_type=remove_item&index=<?= $key ?>">Delete </a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>

                <!-- Form -->
                <form action="" method="post">

                    <label for="notes"> Notes:</label><br>
                    <textarea id="notes" name="notes" rows="4" cols="50"></textarea><br><br>

                    <label for="room">Room:</label>
                    <select id="room" name="category">
                        <option value="101">101</option>
                        <option value="102">102</option>
                        <option value="103">103</option>
                        <option value="104">104</option>
                    </select><br><br>

                    <input type="hidden" name="total" value="<?= $Total ?>">

                    <div class="text-end m-3">
                        <b>Total: <?= $Total ?></b><br><br>
                        <button type="submit" name="confirm" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
                <!-- Product display -->
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>

<?php
(@include("./layouts/footer.php")) or die(" file not exist");
?>