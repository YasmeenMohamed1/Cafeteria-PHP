<?php
session_start();

$_SESSION['css_path']= "css/temp_styles.css";

(@include ("./layouts/header.php")) or die(" file not exist"); 

?>

<?php
require("DB_Connection.php");

$errorMsg = "";
$successMsg = "";

// if (isset($_GET['email'])) {
    $email = $_GET['email'];
    // if (empty($email)) {
    //     $errorMsg = "Error: Email not provided";
    // } else {
        $db = new db();
        $connection = $db->get_connection();

        $stmt = $connection->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(array(':email' => $email));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
          $errorMsg = "Email not found in the database";
         } else {
       
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
                    $newPassword = $_POST['new_password'];
                    $confirmPassword = $_POST['confirm_password'];

                    if (empty($newPassword) || empty($confirmPassword)) {
                        $errorMsg = "Please fill in all fields";
                    } elseif ($newPassword !== $confirmPassword) {
                        $errorMsg = "Password and confirm password do not match";
                    } else {
                        $stmt = $connection->prepare("UPDATE user SET password = :password WHERE email = :email");
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $stmt->execute(array(':password' => $hashedPassword, ':email' => $email));

                        $successMsg = "Password updated successfully";
                        ?>
                        <button class="btn btn-primary"> back to Login</button>
                        <?php
                    }
                }
            }
       }
// }
// } else {
//     $errorMsg = "Error: Email not provided";
// }
?>
<style>
    .card {
        margin-top: 135px;
        margin-bottom: 230px;
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
    .error-message {
        color: red;
        font-weight: bold;
        padding: 10px;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    .success-message {
        color: green;
        font-weight: bold;
        padding: 10px;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    legend,label{
    color: #2f170fe6;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <legend class="text-center mt-3">Forgot Password</legend>
                <?php if (!empty($errorMsg)): ?>
                    <div class="error-message"><?php echo $errorMsg; ?></div>
                <?php endif; ?>
                <?php if (!empty($successMsg)): ?>
                    <div class="success-message"><?php echo $successMsg; ?></div>
                <?php endif; ?>
                <?php if (empty($successMsg)): ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="new_password">New Password:</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php (@include ("./layouts/footer.php")) or die(" file not exist"); ?>
