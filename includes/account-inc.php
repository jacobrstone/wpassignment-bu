<?php 

if(isset($_POST['confirmDelete'])) // check that the user has pressed the delete account button 
{
    require_once 'register-login-functions-inc.php'; // import our login functions script, which enables our input sanitisation checks 
    $email = $_POST['email'];
    $user_password = $_POST['password'];
    $passwordVerified = $_POST['verify-password'];
    
    if(emptyInputSignUp($firstName, $secondName, $email, $user_password, $passwordVerified) !== false) // if errors exist, send them back to signup page.
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