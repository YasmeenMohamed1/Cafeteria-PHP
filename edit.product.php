<?php

require("DB_Connection.php");
$db=new db(); 
$result = $db->get_data("category");
$data = $result->fetchAll(PDO::FETCH_ASSOC);
$id=$_REQUEST['id'];
$result2 = $db->get_data("product","id=$id");
$product = $result2->fetch(PDO::FETCH_ASSOC);
var_dump($product);


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
<h2 class="mb-5 pt-5 text-center fw-bolder text-color_dark_cafe text-lg">Edit Product</h2>

<?php echo "<form action='update.product.php' method='post' enctype='multipart/form-data'>";?>

<div class="mb-3">
  <input type="text" name='id' hidden value= <?php echo "$id";?>></input>
  <label for="exampleFormControlInput1" class="form-label text-color_dark_cafe fw-bolder" >Product</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" name="product" disabled value="<?php echo $product["pro_name"]; ?>">

  <div class="text-danger">
    <?php
      if(isset($errors['product']))
      {
          echo $errors['product'];
          
      }

      if(isset($errors['duplicate_product']))
      {
          echo $errors['duplicate_product'];
          
      }

    ?>
  </div>
</div>

<div class="mb-3">
  <!-- <span class="input-group-text">$</span> -->
  <label for="quantity" class="form-label text-color_dark_cafe fw-bolder">Quantity  </label>
  <input type="number" class="form-control" aria-label="Quantity" id="quantity" name="quantity" min="0" value=<?php echo $product['quantity']?>>
  <div class="text-danger">
    <?php
      if(isset($errors['quantity']))
      {
          echo $errors['quantity'];
          
      }

    ?>
  </div>
 
</div>

<div class="mb-3">
  <!-- <span class="input-group-text">$</span> -->
  <label for="price" class="form-label text-color_dark_cafe fw-bolder">Price  </label>

  <div class="input-group">
  <input type="number" class="form-control" aria-label="Price" id="price" name="price" min="0" value=<?php echo $product['price']?>>
  <span class="input-group-text text-color_dark_cafe bg-primary">EGP</span>
</div>
  <div class="text-danger">
    <?php
      if(isset($errors['price']))
      {
          echo $errors['price'];
          
      }

    ?>
  </div>
</div>


<div class="mb-3">
 

  <label for="exampleFormControlSelect1" class=" form-label fw-bolder text-color_dark_cafe">Select Category</label>
       <div class="input-group">
        <?php
        ini_set("display_errors",1);
        ini_set("display_startup_errors",1);
        error_reporting(E_ALL);
        
                 $catid=$product['category_id'];
                 $cat=$db->get_data("category","id=$catid");
                 $catdata=$cat->fetch(PDO::FETCH_ASSOC);
                 $catName=$catdata['cat_name'];

         ?>
        <select class="form-control " id="exampleFormControlSelect1" name="category" value=<?php echo $catName ?>>
          
          
          <?php foreach ($data as $category): ?>

            <option><?php echo $category['cat_name']; ?></option>
         <?php endforeach; ?>

        </select>

        <span class="input-group-text bg-primary"><a href="add.category.php" class="text-color_dark_cafe ">Add Category</a></span>
        </div>
</div>



<div class="mb-3">

<label for="product_img" class="form-label fw-bolder text-color_dark_cafe">Product Image: </label>
<input type="file" name="product_img" id="product_img"  class="btn btn-primary" value=<?php echo $product['image'] ?>>
<!-- <label for="user_img" class="btn btn-primary">Choose File</label> -->
  
</div>

<div class="mb-3 pt-3 pb-5 text-center">
    <input type="submit" value="Submit" name="edit_product" class="btn btn-primary btn-lg">
    <input type="reset" value="Reset" class="btn btn-primary btn-lg">
</div>

</form>

</div>
</section>

<?php
(@include ("./layouts/footer.php")) or die(" file not exist");
?>