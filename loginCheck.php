<?php
session_start();

include 'DB_Connection.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, name, image, password FROM user WHERE email = :email";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && $user['password'] == $password) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['image'] = $user['image'];

        header("Location: user.index.php"); //go to user page 
        exit();
    } else {
        echo "invalid email or password";
    }
} else {
    echo "email or password is not provide";
}