<?php

// if(isset($_SESSION['cart'])){
//     echo "<pre>";
//     var_dump($_SESSION['cart']);
//     echo "</pre>";
// }

?>

        <div style="background-color: beige; margin-top: 10px; color:#2f170fe6;" class=" py-5">
                <!-- Form -->
                <form action="" method="post">

                    <label for="notes"> Notes:</label><br>
                    <textarea id="notes" name="notes" class="form-control"></textarea><br><br>

                    <label for="room">Room:</label>
                    <select id="room" name="category" class="form-control">
                        <option value="101">101</option>
                        <option value="102">102</option>
                        <option value="103">103</option>
                        <option value="104">104</option>
                    </select><br><br>

                    <input type="hidden" name="total" value="<?= $Total ?>">

                    <div class="text-end m-3">
                        <b>Total:</b><br><br>
                        <button type="submit" name="confirm" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>