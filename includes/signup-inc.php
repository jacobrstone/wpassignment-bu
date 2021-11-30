<?php 

    if(isset($_POST['submit'])) { // if page is accessed by submit button
        
        $firstName = $_POST['first-name'];
        $secondName = $_POST['second-name'];
        $email = $_POST['email'];
        $user_password = $_POST['password'];
        $passwordVerified = $_POST['verify-password'];
        // including our database handling script and credential verifying scripts
        require_once 'dbhandler-inc.php';
        require_once 'signup-functions-inc.php'; 

        // check for any value that isn't false, since, we're looking for errors, if presence of error is anything but false, that's bad. 
        if(emptyInputSignUp($firstName, $secondName, $email, $user_password, $passwordVerified) !== false) // if errors exiset, send them back to signup page.
        { 
            header("location: ../signup.php?error=emptyInput"); 
            exit();
        }
        if(invalidFullname($firstName, $lastName) !== false) 
        {
            header("location: ../signup.php?error=invalidName"); 
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
        if(usernameExists($connection, $email) !== false) 
        {
            header("location: ../signup.php?error=usernameTaken"); 
            exit();
        }
        
        createUser($connection, $firstName, $secondName, $email, $user_password); 
    }
    else {
        header("location: ../signup.php"); 
        exit();
    }