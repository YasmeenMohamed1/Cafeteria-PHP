        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
            <div class="container">
                <a class="navbar-brand text-uppercase fw-bold d-lg-none" href="index.html">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="index.html">Home</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="about.html">About</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="AllUsers.php">Users</a>
                        </li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase"
                                href="AllProducts.php">Products</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="store.html">Store</a></li>
                    </ul>
                </div>

                <div class="d-flex align-items-center">
                    <h2 class="text-light me-3">hi, <?php echo $_SESSION['user_name']; ?></h2>
                    <img src="<?php echo $_SESSION['image']; ?>" alt="img" class="rounded-circle"
                        style="width: 40px; height: 40px;">

                    <!-- <img src="img.jpg" class="rounded-circle" style="width: 50px; height: 50px;"> -->

                </div>
            </div>
        </nav>