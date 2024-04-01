<?php
session_start();
(@include("../layouts/header.php")) or die(" file not exist");
(@include("../layouts/user.nav.php")) or die(" file not exist");

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-8 offset-4">
            <!-- search -->
            <h5 class="mb-3 lastproduct">last Products</h5>
            <div class="d-flex flex-wrap mb-5" id=lastpro>

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

    fetch_data();

    // Event delegation to handle click on dynamically loaded elements
    $(document).on("click", ".proItem", function() {
    var $this = $(this);
    var $lastPro = $("#lastpro");

    // Check if the clicked element is in lastpro
    var isInLastPro = $this.closest($lastPro).length > 0;

    // Check if the clicked element has class 'clicked'
    var isClicked = $this.hasClass('clicked');

    // If the clicked element is in lastpro and it doesn't have the class 'clicked', append it to lastpro
    if (!isClicked) {
        // Clone and append the element to lastpro
        var $clonedProduct = $this.clone().appendTo($lastPro);

        // Add class 'clicked' to the original element
        $this.addClass('clicked');
        
    }
    });



    $(document).on("click", ".page-item", function() {
        let page = $(this).attr("id");
        fetch_data(page);
    });
</script>

<?php
(@include("../layouts/footer.php")) or die(" file not exist");
?>