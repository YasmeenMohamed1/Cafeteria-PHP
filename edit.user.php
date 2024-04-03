<?php

(@include ("./layouts/header.php")) or die(" file not exist");
(@include ("./layouts/user.nav.php")) or die(" file not exist");
?>

<?php

require("DB_Connection.php");
$db=new db(); 
$result = $db->get_data("room");
$data = $result->fetchAll(PDO::FETCH_ASSOC);
$id=$_REQUEST['id'];
$user = $db->get_data("user","id=$id");
$userdata = $user->fetch(PDO::FETCH_ASSOC);

// var_dump($userdata);

$errors = [];

if(isset($_GET['errors']))
{
    $errors=json_decode($_GET['errors'],true);

   

}

?>



<section class="container custom-bg mt-4 mb-3 w-75" >
<div class="container  w-75 ">
<h2 class="mb-5 pt-5 text-center fw-bolder text-color_dark_cafe text-lg">Edit User</h2>

<form action="update.user.php" method="post" enctype="multipart/form-data">

<div class="mb-3">
<input type="text" hidden  name="id" value=<?php echo "$id";?> >

  <label for="exampleFormControlInput1" class="form-label text-color_dark_cafe fw-bolder">Name</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" name="username" value=<?php echo $userdata['user_name'] ;?>>
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
  <input type="email" class="form-control" id="exampleFormControlInput2" name="email" disabled readonly value=<?php echo $userdata['email'] ;?> >
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

  <label for="exampleFormControlSelect2" class=" form-label fw-bolder text-color_dark_cafe">Role</label>
  <select class="form-control" id="exampleFormControlSelect2" name="role">
    <option <?php  ($userdata['role'] == 'user') ? 'selected' : ''; ?>>User</option>
    <option <?php  ($userdata['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
</select>
    
</div>

<div class="mb-3">
 
  <label for="exampleFormControlSelect1" class=" form-label fw-bolder text-color_dark_cafe">Select Room No.</label>
  <select class="form-control" id="exampleFormControlSelect1" name="room" onchange="updateExt(this)">
    <?php foreach ($data as $category): ?>
        <option <?php  ($userdata['room_id'] == $category['room_no']) ? 'selected' : ''; ?>><?php echo $category['room_no']; ?></option>
    <?php endforeach; ?>
</select>
    
</div>



<div class="mb-3">
  <label for="exampleFormControlInput3" class="form-label fw-bolder text-color_dark_cafe">Ext.</label>
  <input type="text" class="form-control" value="1" name="ext" id="exampleFormControlInput3" disabled readonly> 
</div>



<div class="mb-3 pt-3 pb-5 text-center">
    <input type="submit" value="update" name="update" class="btn btn-primary btn-lg">
    <input type="reset" value="Reset" class="btn btn-primary btn-lg">
</div>

</form>

</div>
</section>

<?php
(@include ("./layouts/footer.php")) or die(" file not exist");
?>