<?php 
session_start();

$_SESSION['css_path']= "assets/css/temp_styles.css";

(@include ("layouts/header.php")) or die("Header file does not exist");

require("DB_Connection.php");

$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new db();
    $connection = $db->get_connection();
    
    $stmt = $connection->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(array(':email' => $email));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($user);

    if ($user) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['image'] = $user['image'];

        if (password_verify($password, $user['password'])) {

            if ($user['role'] == 'admin') {
                header("Location: ./admin/admin.index.php");
                exit();
            } elseif ($user['role'] == 'user') {
               
                header("Location: ./user/cart/user.index.php"); 
            }
        } else {
            $errorMsg = "<span style='color: red;'>email or password is wrong</span>";
        }
    } else {
        $errorMsg = "<span style='color: red;'>email or password is wrong</span>";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['forgetPassword'])) {
    $email = $_GET['email'];

    $db = new db();
    $connection = $db->get_connection();
    $stmt = $connection->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(array(':email' => $email));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        header("Location: forgetPassword.php?email=$email");
        exit();
    } else {
        $errorMsg = "<span style='color: red;'>Email not found in the database</span>";
    }
}
?>

<title>Login</title>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <legend class="text-center mt-3">Login</legend>
                <?php echo $errorMsg; ?>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary brown">Login</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="#" onclick="checkEmailExistence();" id="forgetPassword">Forget Password</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function checkEmailExistence() {
    var email = document.getElementById("email").value;
    if (email.trim() !== "") {
        window.location.href = "login.php?forgetPassword=true&email=" + email;
    } else {
        alert("Please enter your email before proceeding.");
    }
}
</script>


