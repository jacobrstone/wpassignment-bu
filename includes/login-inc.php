<?php 
if (isset($_POST['submit'])) 
{
    $email = $_POST["email"];
    $user_password = $_POST["password"]; 
    require_once 'dbhandler-inc.php';
    require_once 'register-login-functions-inc.php'; 

    if(emptyInputLogIn($email, $user_password) !== false) // if login fields are empty, send them back to signup page.
    { 
        header("location: ../login.php?error=emptyInput"); 
        exit();
    }

    loginUser($connection, $email, $user_password);
}
else {
    header("location: ../login.php"); 
    exit();
}