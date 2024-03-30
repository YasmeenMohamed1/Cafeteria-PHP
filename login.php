<?php 
session_start();

(@include ("./layouts/header.php")) or die("Header file does not exist");
(@include ("./layouts/admin.nav.php")) or die("Admin navigation file does not exist");

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

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_image'] = $user['image'];

            if ($user['role'] == 'admin') {
                header("Location: adminHome.php");
                exit();
            } elseif ($user['role'] == 'user') {
                header("Location: user.index.php");
                exit();
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
<style>
    .card {
        margin-top: 95px;
        margin-bottom: 225px;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        background-color: #f1e7d8;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .btn-primary {
        width: 100%;
    }
    legend,label{
    color: #2f170fe6;
}
</style>

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

<?php (@include ("./layouts/footer.php")) or die("Footer file does not exist"); ?>
