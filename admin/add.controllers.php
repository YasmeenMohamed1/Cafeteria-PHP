<?php

require("DB_Connection.php");

$db=new db();

//$connection = $db->get_connection();


if(isset($_POST['register']))
{

    $username = validate($_POST['username']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $cpassword = validate($_POST['cpassword']);
    $role = validate($_POST['role']);
    $room = validate($_POST['room']);

    $errors = [];

    if(!preg_match("#[a-zA-Z0-9]{3,}#",$username))
    {
        $errors['username'] = "Username must be more than 3 charachters and contains of numbers and charachters";
    }
    else
    {
        unset($errors['username']);

    }

    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        $errors['email'] = "Invalid email address";
    }
    else
    {
        unset($errors['email']);
    }

    if(!preg_match("#[a-zA-Z0-9]{3,}#",$password))
    {
        $errors['password'] = "Your Password must be more than 3 charachters and can contain numbers or charachters";
    }
    else
    {
        unset($errors['password']);
    }

    if($password != $cpassword)
    {
        $errors['cpassword'] = "The confirmed password doesn't match the password";
    }
    else
    {
        unset($errors['cpassword']);
    }



    $query_user = $db->select_count("user", "user_name = '{$username}'");
    $result_user = $query_user->fetch(PDO::FETCH_ASSOC);
    $count_user = $result_user['count'];

    if($count_user > 0)
    {
        $errors['duplicate_username'] = "This Username is found in database please enter another username";

    }
    else
    {
        unset($errors['duplicate_username']);

    }

    $query_email = $db->select_count("user", "email = '{$email}'");
    $result_email = $query_email->fetch(PDO::FETCH_ASSOC);
    $count_email = $result_email['count'];

    if($count_email > 0)
    {
        $errors['duplicate_email'] = "This email is found in database please enter another email";

    }
    else
    {
        unset($errors['duplicate_email']);

    }
    

    if(count($errors) > 0)
    {
        header("Location:add.user.php?errors=".json_encode($errors));

    }
    else
    {
        // echo var_dump($_FILES['emp_img']);
        $from = $_FILES['user_img']['tmp_name'];
        $img = $_FILES['user_img']['name'];
        move_uploaded_file($from,"assets/img/users/".$img);
        

        try{
        
            $query= $db->select_column("id","room","room_no = '{$room}'");
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $roomID = $result['id'];
            // echo($roomID);

        $db->insert_data("user","user_name,email,password,image,role,room_id",
        "'$username','$email','$password','$img','$role','$roomID'");

        header("Location:AllUsers.php");
        
        }catch(PDOException $exc){
        
            echo $exc->getMessage();
        
        }

    }


}
else if(isset($_POST['add_product']))
{
    $product = validate($_POST['product']);
    $quantity = validate($_POST['quantity']);
    $price = validate($_POST['price']);
    $category = validate($_POST['category']);
    

    $errors = [];

    if(!preg_match("#[a-zA-Z0-9]{3,}#",$product))
    {
        $errors['product'] = "Product must be more than 3 charachters and contains of numbers and charachters";
    }
    else
    {
        unset($errors['product']);

    }

    if(!preg_match("#[0-9]#",$quantity))
    {
        $errors['quantity'] = "Quantity must be number";
    }
    else
    {
        unset($errors['quantity']);

    }

    if(!preg_match("#[0-9]#",$price))
    {
        $errors['price'] = "Price must be number";
    }
    else
    {
        unset($errors['price']);

    }

    // $db->select_count("product","pro_name = '{$product}'");
    $query = $db->select_count("product", "pro_name = '{$product}'");
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    if($count > 0)
    {
        $errors['duplicate_product'] = "This product is found in database please enter another product";

    }
    else
    {
        unset($errors['duplicate_product']);

    }

    
    if(count($errors) > 0)
    {
        header("Location:add.product.php?errors=".json_encode($errors));

    }
    else
    {
         //echo var_dump($_FILES['product_img']);
        $from = $_FILES['product_img']['tmp_name'];
        $img = $_FILES['product_img']['name'];
        move_uploaded_file($from,"assets/img/products/".$img);
        

        try{
        
            $query= $db->select_column("id","category","cat_name = '{$category}'");
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $catID = $result['id'];
            // echo($roomID);

        $db->insert_data("product","pro_name,quantity,price,image,category_id",
        "'$product','$quantity','$price','$img','$catID'");

        header("Location:AllProducts.php");
        
        }catch(PDOException $exc){
        
            echo $exc->getMessage();
        
        }

    }



}
else if(isset($_POST['add_category']))
{
    $category = validate($_POST['category']);
    

    $errors = [];

    if(!preg_match("#[a-zA-Z0-9]{3,}#",$category))
    {
        $errors['category'] = "Category must be more than 3 charachters and contains of numbers and charachters";
    }
    else
    {
        unset($errors['category']);

    }

    $query = $db->select_count("category", "cat_name = '{$category}'");
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    if($count > 0)
    {
        $errors['duplicate_category'] = "This category is found in database please enter another category";

    }
    else
    {
        unset($errors['duplicate_category']);

    }
    
    if(count($errors) > 0)
    {
        header("Location:add.category.php?errors=".json_encode($errors));

    }
    else
    {

        try{
    

        $db->insert_data("category","cat_name",
        "'$category'");

        header("Location:add.product.php");
        
        }catch(PDOException $exc){
        
            echo $exc->getMessage();
        
        }

    }

}

function validate($data)
{
    $data=trim($data);
    $data=addslashes($data);
    $data=htmlspecialchars($data);

    return $data;


}

?>