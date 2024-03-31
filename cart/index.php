<?php
session_start();
(@include("../layouts/header.php")) or die(" file not exist");
(@include("../layouts/user.nav.php")) or die(" file not exist");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <!-- Cart div to display products -->
            <div class="cart" id="cart">
                <!-- Cart items will be displayed here -->
            </div>
            <!-- Form for notes and room selection -->
            <div>
                <form action="place_order.php" method="post">
                    <label for="notes">Notes:</label><br>
                    <textarea id="notes" name="notes" rows="4" cols="20"></textarea><br><br>

                    <label for="room">Room:</label>
                    <select id="room" name="room">
                        <option value="101">101</option>
                        <option value="102">102</option>
                        <option value="103">103</option>
                    </select><br><br>

                    <input type="hidden" id="total-cost" name="total" value="0">

                    <!-- Display total price -->

                    <div class="text-end m-3">
                        <div id="total-price">Total Price: $0.00</div> <br>
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

<!-- Include jQuery library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize total price
    var totalPrice = 0;

    // Function to fetch data
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

    // Initial fetch of data
    fetch_data();

    // Pagination click event handler
    $(document).on("click", ".page-item", function() {
        var page = $(this).attr("id");
        fetch_data(page);
    });

    // Click event handler for product images
    $(document).on("click", ".image", function() {
        var productId = $(this).data("id");
        $.ajax({
            url: "fetch_product_details.php",
            method: "POST",
            data: {
                product_id: productId
            },
            success: function(response) {
                var product = JSON.parse(response);
                var productName = product.pro_name;
                var productPrice = parseFloat(product.price).toFixed(2);
                var productImage = product.image;
                var productInfo = "<div class='product-info'><img src='" + productImage +
                    "' alt='" +
                    productName + "'><br>" + productName + " - $" + productPrice + "</div>";
                $("#cart").append(productInfo);
                console.log(productName);

                // Update total price
                totalPrice += parseFloat(product.price);
                $("#total-price").text("Total Price: $" + totalPrice.toFixed(2));
            },
            error: function(xhr, status, error) {
                console.error("Error fetching product details:", error);
            }
        });
    });
});
</script>

<?php
(@include("../layouts/footer.php")) or die(" file not exist");
?>