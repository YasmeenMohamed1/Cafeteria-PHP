<?php

(@include ("./layouts/header.php")) or die(" file not exist");
(@include ("./layouts/user.nav.php")) or die(" file not exist");
?>

<?php

require("DB_Connection.php");
$db=new db(); 
$result = $db->get_data("room");
$data = $result->fetchAll(PDO::FETCH_ASSOC);
// var_dump($data);

$errors = [];

if(isset($_GET['errors']))
{
    $errors=json_decode($_GET['errors'],true);

   

}

?>



<section class="container custom-bg mt-4 mb-3 w-75" >
<div class="container  w-75 ">
<h2 class="mb-5 pt-5 text-center fw-bolder text-color_dark_cafe text-lg">Add User</h2>

<form action="add.controllers.php" method="post" enctype="multipart/form-data">

<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label text-color_dark_cafe fw-bolder">Name</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" name="username" >
  <div class="text-danger">
    <?php
      if(isset($errors['username']))
      {
          echo $errors['username'];
          
      }

      if(isset($errors['duplicate_username']))
      {
          echo $errors['duplicate_username'];
          
      }

    ?>
  </div>
</div>

<div class="mb-3">
  <label for="exampleFormControlInput2" class="form-label fw-bolder text-color_dark_cafe">Email</label>
  <input type="email" class="form-control" id="exampleFormControlInput2" name="email" >
  <div class="text-danger">
  <?php
    if(isset($errors['email']))
    {
        echo $errors['email'];
    }

    if(isset($errors['duplicate_email']))
    {
        echo $errors['duplicate_email'];
        
    }

    ?>
  </div>
</div>

<div class="mb-3">
<label for="inputPassword5" class="form-label fw-bolder text-color_dark_cafe">Password</label>
<input type="password" id="inputPassword5" class="form-control" name="password">
<div class="text-danger">
  <?php
    if(isset($errors['password']))
    {
        echo $errors['password'];
    }

    ?>
  </div>
</div>

<div class="mb-3">
<label for="inputPassword6" class="form-label fw-bolder text-color_dark_cafe">Confirm Password</label>
<input type="password" id="inputPassword6" class="form-control" name="cpassword">

<div class="text-danger">
  <?php
    if(isset($errors['cpassword']))
    {
        echo $errors['cpassword'];
    }

    ?>
  </div>

</div>


<div class="mb-3">

  <label for="exampleFormControlSelect2" class=" form-label fw-bolder text-color_dark_cafe">Role</label>
    <select class="form-control" id="exampleFormControlSelect2" value="User" name="role" >
   
      <option>User</option>
      <option>Admin</option>
        
    </select>
    
</div>

<div class="mb-3">
  <!-- <label for="exampleFormControlInput2" class="form-label">Room No.</label>
  <input type="text" class="form-control" id="exampleFormControlInput2" > -->

  <label for="exampleFormControlSelect1" class=" form-label fw-bolder text-color_dark_cafe">Select Room No.</label>
    <select class="form-control" id="exampleFormControlSelect1" value=<?php echo $data[0]['room_no'] ?> name="room" onchange="updateExt(this)">
          
        <?php foreach ($data as $category): ?>
            <option><?php echo $category['room_no']; ?></option>
        <?php endforeach; ?>
          
          
    </select>
    
</div>



<div class="mb-3">
  <label for="exampleFormControlInput3" class="form-label fw-bolder text-color_dark_cafe">Ext.</label>
  <input type="text" class="form-control" value="1" name="ext" id="exampleFormControlInput3" disabled readonly> 
</div>

<div class="mb-3">
<!-- <label for="exampleFormControlInput4" class="form-label fw-bolder text-color_dark_cafe">User Image: </label>
<input type="file" name="user_img" > -->
<label for="user_img" class="form-label fw-bolder text-color_dark_cafe">User Image: </label>
<input type="file" name="user_img" id="user_img"  class="btn btn-primary">
<!-- <label for="user_img" class="btn btn-primary">Choose File</label> -->
  
</div>

<div class="mb-3 pt-3 pb-5 text-center">
    <input type="submit" value="Submit" name="register" class="btn btn-primary btn-lg">
    <input type="reset" value="Reset" class="btn btn-primary btn-lg">
</div>

</form>

</div>
</section>

<?php
(@include ("./layouts/footer.php")) or die(" file not exist");
?>