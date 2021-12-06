<?php 

if(isset($_POST['confirmDelete']))
{
    require_once 'register-login-functions-inc.php'; 
    $email = $_POST['email'];
    $user_password = $_POST['password'];
    $passwordVerified = $_POST['verify-password'];

    if(emptyInputSignUp($firstName, $secondName, $email, $user_password, $passwordVerified) !== false) // if errors exiset, send them back to signup page.
    { 
        header("location: ../account.php?error=emptyInput"); 
        exit();
    }
    if(invalidEmail($email) !== false) 
    {
        header("location: ../signup.php?error=invalidEmail"); 
        exit();
    }
    if(matchPassword($user_password, $passwordVerified) !== false)
    {   
        header("location: ../signup.php?error=passwordMismatch"); 
        exit();
    }
}