<?php
session_start();
(@include("../layouts/header.php")) or die(" file not exist");
(@include("../layouts/user.nav.php")) or die(" file not exist");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3" class="cart-item">

            //المفروض المنتجات تظهر هنا
            <div>
                <form action="place_order.php" method="post">
                    <label for="notes">Notes:</label><br>
                    <textarea id="notes" name="notes" rows="4" cols="20"></textarea><br><br>

                    <label for="room">Room:</label>
                    <select id="room" name="room">
                        <option value="101"> 101</option>
                        <option value="102"> 102</option>
                        <option value="103"> 103</option>
                    </select><br><br>

                    <input type="hidden" id="total-cost" name="total" value="0">
                    <div class="text-end m-3">
                        <button type="submit" name="confirm" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-8 offset-4">
            <!-- search -->
            <h5 class="mb-3 lastproduct">Last Products</h5>
            <h5 class="mb-3 allproduct">All Products</h5>
            <div id="proData">
                <!-- Products will be displayed here -->
            </div>
        </div>
    </div>
</div>

<!-- Jquery Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function() {
    function calculateTotalCost() {
        var totalCost = 0;
        $(".cart-item").each(function() {
            var quantity = $(this).find(".quantity-input").val();
            var price = $(this).data("price");
            totalCost += quantity * price;
        });
        $("#total-cost").val(totalCost.toFixed(2));
    }


    $(document).on("click", ".increase-quantity", function() {
        var input = $(this).siblings(".quantity-input");
        var quantity = parseInt(input.val()) + 1;
        input.val(quantity);
        calculateTotalCost();
    });

    $(document).on("click", ".decrease-quantity", function() {
        var input = $(this).siblings(".quantity-input");
        var quantity = parseInt(input.val()) - 1;
        if (quantity < 1) {
            quantity = 1;
        }
        input.val(quantity);
        calculateTotalCost();
    });

    $(document).on("click", ".remove-item", function() {
        $(this).closest(".cart-item").remove();
        calculateTotalCost();
    });

    function fetch_data(page) {
        $.ajax({
            url: "user.controller.php",
            method: "POST",
            data: {
                page: page
            },
            success: function(data) {
                $("#proData").html(data);
            }
        });
    }

    fetch_data();

    $(document).on("click", ".page-item", function() {
        let page = $(this).attr("id");
        fetch_data(page);
    });

    calculateTotalCost();
});
</script>

<?php
(@include("../layouts/footer.php")) or die(" file not exist");
?>