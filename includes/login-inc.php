<?php 
if (isset($_POST['submit'])) 
{
    $email = $_POST["email"];
    $user_password = $_POST["password"]; 
    require_once 'dbhandler-inc.php';
    require_once 'register-login-functions-inc.php'; 

    if(emptyInputLogIn($email, $user_password) !== false) // if login fields are empty, send them back to signup page
    { 
        header("location: ../login.php?error=emptyInput"); 
        exit();
    }
    if(invalidEmail($email)!== false) // check the email a user is logging in with is in the valid format 
    {
        header("location: ../signup.php?error=invalidEmail"); 
        exit();
    }

    loginUser($connection, $email, $user_password); // checks for incorrect password are already built into the loginUser function
}
else {
    header("location: ../login.php"); 
    exit();
}