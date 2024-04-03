  <?php 
  session_start()
  ?>


        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
            <div class="container">
                <a class="navbar-brand text-uppercase fw-bold d-lg" href="index.php">Friends cafeteria</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="user.index.php">Home</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="../orders/user.orders.php">My Orders</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="<?=$_SESSION['logout']?>">Logout</a></li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <h3 class="text-light me-3"><?= ucfirst($_SESSION['user_name']); ?></h3>
                        <img src="<?=$_SESSION['nav-image']?>" alt="img" class="rounded-circle"
                            style="width: 40px; height: 40px;">
                    </div>
                </div>
            </div>
        </nav>