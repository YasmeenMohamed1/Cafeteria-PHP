<?php
session_start();
// session_destroy();
(@include("../layouts/header.php")) or die(" file not exist");
(@include("../layouts/user.nav.php")) or die(" file not exist");

?>

<div class="container mt-5">
    <div class="row">

        <div class="col-4" id="cartt">
            <h3 class="d-flex flex-wrap mb-2">Cart Items</h3>
            <div id="cart"></div> <br><br>
            <form id="orderForm">
                <div class="mb-3">
                    <label for="room" class="form-label">Select Room:</label>
                    <select class="form-select" id="room" name="room">
                        <option value="101">Room 101</option>
                        <option value="102">Room 102</option>
                        <option value="103">Room 103</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="orderNotes" class="form-label">Order Notes</label>
                    <textarea class="form-control" id="orderNotes" name="orderNotes" rows="2"></textarea>
                </div>
                <hr>
                <div class="text-end">
                    <div id="cartTotalPrice" class="text-end"></div>
                    <button type="submit" name="confirm" class="btn btn-primary text-end">Confirm</button>

                </div>
            </form>

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

                // calculateTotalPrice(); //////////////////
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
        alert("id" + id + ", name" + name + ", price" + price + ", quantity" + quantity)
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
                alert("you have putted new item")
            },
            success: function(response) {
                $("#cart").append(response);
                alert("You have added a new item to the cart.");

                calculateTotalPrice();

            }
        });
        var $this = $(this);
        var $latestOrder = $("#latestOrder");

        // Check if the clicked element is in latestOrder
        var isInlatestOrder = $this.closest($latestOrder).length > 0;

        // Check if the clicked element has class 'clicked'
        var isClicked = $this.hasClass('clicked');

        // If the clicked element is in lastpro and it doesn't have the class 'clicked', append it to lastpro
        if (!isClicked) {
            // Clone and append the element to lastpro
            var $clonedProduct = $this.clone().appendTo($latestOrder);

            // Add class 'clicked' to the original element
            $this.addClass('clicked');

        }
    });



    function calculateTotalPrice() {
        totalPrice = 0;
        $(".proItem").each(function() {
            var price = parseFloat($(this).find('.price').val());
            totalPrice = (totalPrice + price);
        });
        $("#cartTotalPrice").text("Total Price: $" + totalPrice.toFixed(2));
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

    $("#orderForm").submit(function(event) {
        event.preventDefault();

        var orderNotes = $("#orderNotes").val();
        var total = $("#cartTotalPrice").text();

        var cartItems = [];
        $(".proItem").each(function() {
            var id = $(this).find('.id').val();
            var name = $(this).find('.name').val();
            var price = $(this).find('.price').val();
            var quantity = $(this).find('.quantity').val();
            cartItems.push({
                id: id,
                name: name,
                price: price,
                quantity: quantity
            });
        });

        // Prepare order data
        var orderData = {
            orderNotes: orderNotes,
            total: total,
            cartItems: cartItems
        };

        // Send order data to server
        placeOrder(orderData);
    });

});
</script>

<?php
(@include("../layouts/footer.php")) or die(" file not exist");
?>


<style>
hr {
    border: 0;
    height: 6px;
    background: white;
    margin: 20px 0;
}
</style>