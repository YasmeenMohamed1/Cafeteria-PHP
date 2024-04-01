<?php

// require("DB_Connection.php");
// $db=new db(); 
// $result = $db->get_data("category");
// $data = $result->fetchAll(PDO::FETCH_ASSOC);
// var_dump($data);

$errors = [];

if(isset($_GET['errors']))
{
    $errors=json_decode($_GET['errors'],true);

    // foreach($errors as $error)
    // {
    //     echo $error;
    // }

}

?>

<?php

(@include ("./layouts/header.php")) or die(" file not exist");
(@include ("./layouts/user.nav.php")) or die(" file not exist");
?>

<section class="container custom-bg mt-4 mb-3 w-75" >
<div class="container  w-75 ">
<h2 class="mb-5 pt-5 text-center fw-bolder text-color_dark_cafe text-lg">Add Category</h2>

<form action="add.controllers.php" method="post">

<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label text-color_dark_cafe fw-bolder">Category</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" name="category">

  <div class="text-danger">
    <?php
      if(isset($errors['category']))
      {
          echo $errors['category'];
          
      }

      if(isset($errors['duplicate_category']))
      {
          echo $errors['duplicate_category'];
          
      }

    ?>
  </div>
</div>



<div class="mb-3 pt-3 pb-5 text-center">
    <input type="submit" value="Submit" name="add_category" class="btn btn-primary btn-lg">
    <input type="reset" value="Reset" class="btn btn-primary btn-lg">
</div>

</form>

</div>
</section>

<?php

(@include ("./layouts/footer.php")) or die(" file not exist");

?>