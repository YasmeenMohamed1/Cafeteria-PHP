<?php
session_start();

if(empty($_SESSION['user_name'])){
    header("location:../../login.php");
}


$_SESSION['css_path']= "../../assets/css/temp_styles.css";
$_SESSION['nav-image']= "../../assets/img/users/{$_SESSION['image']}";
$_SESSION['logout']= "../../logout.php";


// session_destroy();
(@include("../../layouts/header.php")) or die(" file not exist");
(@include("../../layouts/user.nav.php")) or die(" file not exist");

(@include("rooms.php"))
?>


<div class="container mt-5">
    <div class="row">

        <div class="col-4">
            <h3 class="d-flex flex-wrap mb-2">Cart Items</h3>
            <div class="cart_con custom-bg text-color_dark_cafe rounded border border-primary">
                <form class="w-75 m-auto py-3" id="make_order" action="make_order.php" method="post">
                    <div class="product_item form-row" id="cart">

                    </div>
                    <div class="mb-3">
                        <label for="room" class="form-label">Select Room:</label>
                        <select class="form-select text-color_dark_cafe" id="room" name="room">
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
                        <div id="cartTotalPrice" class="text-center mb-3 text-end" ></div>
                        <input type="hidden" name="totalprice" >
                        <button type="submit" name="confirm" class=" btn btn-primary  text-color_dark_cafe text-center " >Confirm</button>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    $(document).ready(function() {

        var totalPrice = 0;
        fetch_data();

        function fetch_data(page) {
            $.ajax({
                url: "get_all_product_with_pagination.php",
                method: "POST",
                data: {
                    page: page
                },
                success: function(data) {
                    $("#proData").html(data)
                }
            });
        }
        //pagination
        $(document).on("click", ".page-item", function() {
            let page = $(this).attr("id");
            fetch_data(page);
        });

       //set data to cart
        $(document).on("click", ".proItem", function() {
            var id = $(this).find('.id').val();
            var name = $(this).find('.name').val();
            var price = $(this).find('.price').val();
            var quantity = $(this).find('.quantity').val();
        //    alert("id" + id + ", name" + name + ", price" + price + ", quantity" + quantity)
            $.ajax({
                method: "POST",
                url: "add_product_to_cart.php",
                data: {
                    id: id,
                    name: name,
                    price: price,
                    quantity: quantity
                },
                success: function(response) {
                    var itemId = $(response).find('input[name^="products["][name$="][id]"]').val();
                    var existingItem = $('#cart input[type="hidden"][name="products[' + itemId + '][id]"][value="' + itemId + '"]').length;

                    if (existingItem == 0) {
                        $("#cart").append(response);
                        // alert("You have added a new item to the cart.");
                        calculateTotalPrice();

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

        $('#cart').on('click', '.btn-primay', function() {
             
                var $cartItem = $(this).closest('.cart-item');
                $cartItem.remove();
                calculateTotalPrice();
        });

        $('#cart').on('change', 'input[type="number"]', function() {
            calculateTotalPrice();
        });

        function calculateTotalPrice() {
            var totalPrice = 0;

          
            $('#cart .cart-item').each(function() {
                var quantity = parseInt($(this).find('.quantity').val());
                var price = parseFloat($(this).find('input[name^="products["][name$="][price]"]').val());
                var subtotal = quantity * price;
                totalPrice += subtotal;
                $('input[name="totalprice"]').val(totalPrice.toFixed(2));

            });

            $('#cartTotalPrice').text("Total price: "+totalPrice.toFixed(2)); // Assuming you have an element with id="total-price" to display the total price
        }
        
        $('#make_order').on('submit', function(event) {
        // Check if the cart is empty
        if ($('#products .cart-item').length === 0) {
            event.preventDefault();
            alert("Your cart is empty. Please add products before submitting the form.");
        }

    });

    });
</script>

<?php
(@include("../../layouts/footer.php")) or die(" file not exist");
?>