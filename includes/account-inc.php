<?php 

if(isset($_POST['confirmDelete'])) // check that the user has pressed the delete account button 
{
    require_once 'all-functions-inc.php'; // import our login functions script, which enables our input sanitisation checks 
    // get data passed through the URL through POST method
    $email = $_POST['email']; 
    $user_password = $_POST['password'];
    $passwordVerified = $_POST['verify-password'];

    // check if the user has tried to sign up with empty fields
    if(emptyInputSignUp($firstName, $secondName, $email, $user_password, $passwordVerified) !== false) // if errors exist, send them back to signup page.
    { 
        header("location: ../account.php?error=emptyInput"); 
        exit();
    }
    // check for a valid email 
    if(invalidEmail($email) !== false) 
    {
        header("location: ../signup.php?error=invalidEmail"); 
        exit();
    }
    // check the user has input their password correctly both times
    if(matchPassword($user_password, $passwordVerified) !== false)
    {   
        header("location: ../signup.php?error=passwordMismatch"); 
        exit();
    }
}

if(isset($_POST['updatePassword'])) // check that the user has pressed the update password button 
{
    require_once 'register-login-functions-inc.php'; // import login functions script, which enables input sanitisation checks 
    // get variables from POST method 
    $old_password = $_POST['oldPassword'];
    $new_password = $_POST['newPassword'];
    // check the user isn't trying to update their old password to the same password
    if(matchPassword($old_password, $new_password) === false)
    {   
        header("location: ../signup.php?error=passwordSame"); 
        exit();
    }
}