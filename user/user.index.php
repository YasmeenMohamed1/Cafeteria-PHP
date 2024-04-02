<?php
session_start();
// session_destroy();
(@include("../layouts/header.php")) or die(" file not exist");
(@include("../layouts/user.nav.php")) or die(" file not exist");
(@include("../cart/rooms.php"))
?>


<div class="container mt-5">
    <div class="row">

        <div class="col-4">
            <h3 class="d-flex flex-wrap mb-2">Cart Items</h3>
            <div class="cart_con">
                <form class="w-75" action="../cart/make_order.php" method="post">
                    <div class="product_item form-row" id="cart">

                    </div>
                    <div class="mb-3">
                        <label for="room" class="form-label">Select Room:</label>
                        <select class="form-select" id="room" name="room">
                            <?php
                            foreach ($rooms as $room) {
                            ?><option value="<?= $room["room_no"] ?>">Room <?= $room["room_no"] ?></option><?php
                                                                                                        }
                                                                                                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="orderNotes" class="form-label">Order Notes</label>
                        <textarea class="form-control" id="orderNotes" name="orderNotes" rows="2"></textarea>
                    </div>
                    <hr>
                    <div class="text-end">
                        <div id="cartTotalPrice" class="text-end"></div>
                        <input type="hidden" id="totalPrice" name="totalPrice">
                        <input type="hidden" id="orderDateTime" name="orderDateTime"
                            value="<?php echo date('Y-m-d H:i:s'); ?>">
                        <button type="submit" name="confirm" class="btn btn-primary text-end">Confirm</button>

                    </div>
                </form>
            </div>

        </div>
        <div class="col-8">
            <!-- search -->
            <h5 class="mb-3 lastproduct">Latest Order</h5>
            <div class="d-flex flex-wrap mb-2" id=latestOrder>

            </div>
            <div id="lastpro-pagination"></div>
            <h5 class="mb-3 allproduct">All Products</h5>
            <div id="proData">

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

    var totalPrice = 0;
    calculateTotalPrice();


    fetch_data();

    function fetch_data(page) {
        $.ajax({
            url: "user.controller.php",
            method: "POST",
            data: {
                page: page
            },
            success: function(data) {
                $("#proData").html(data)

            }
        });
    }

    $(document).on("click", ".page-item", function() {
        let page = $(this).attr("id");
        fetch_data(page);
    });


    $(document).on("click", ".proItem", function() {
        var id = $(this).find('.id').val();
        var name = $(this).find('.name').val();
        var price = $(this).find('.price').val();
        var quantity = $(this).find('.quantity').val();
        //  alert("id" + id + ", name" + name + ", price" + price + ", quantity" + quantity)
        $.ajax({
            method: "POST",
            url: "../cart/add_to_cart.php",
            data: {
                id: id,
                name: name,
                price: price,
                quantity: quantity
            },
            success: function(response) {
                var itemId = $(response).find('input[name^="products["][name$="][id]"]')
                    .val();
                var existingItem = $('#cart input[type="hidden"][name="products[' + itemId +
                    '][id]"][value="' + itemId + '"]').length;

                if (existingItem == 0) {
                    $("#cart").append(response);
                    alert("You have added a new item to the cart.");

                }

            }
        });

        var $this = $(this);
        var $latestOrder = $("#latestOrder");

        var isClicked = $this.hasClass('clicked');

        if (!isClicked) {
            var $clonedProduct = $this.clone().appendTo($latestOrder);
            $this.addClass('clicked');

        }
    });

    $('#cart').on('change', 'input[type="number"]', function() {
        calculateTotalPrice();
    });

    function calculateTotalPrice() {
        var totalPrice = 0;

        $('#cart .cart-item').each(function() {
            var quantity = parseInt($(this).find('.quantity').val());
            var price = parseFloat($(this).find('input[name^="products["][name$="][price]"]').val());
            console.log(quantity, price);
            var subtotal = quantity * price;


            totalPrice += subtotal;
        });


        $('#cartTotalPrice').text(totalPrice.toFixed(
            2));

        $('#totalPrice').val(totalPrice.toFixed(2));

    }


    function placeOrder(orderData) {
        $.ajax({
            url: "process_order.php",
            method: "POST",
            data: orderData,
            success: function(response) {
                console.log("Order successfully placed:", response);

            },
            error: function(xhr, status, error) {
                console.error("Error placing order:", error);
            }
        });
    }

    var now = new Date();
    var formattedDateTime = now.toISOString().slice(0, 19).replace("T", " ");
    document.getElementById("orderDateTime").value = formattedDateTime;

    $(document).ready(function() {
        $(document).on("click", ".remove-item", function() {
            $(this).closest('.cart-item').remove();
        });
    });


});
</script>

<?php
(@include("../layouts/footer.php")) or die(" file not exist");
?>