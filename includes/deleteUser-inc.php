<?php 

    if(isset($_POST['confirmDelete'])) { // if page is accessed by submit button
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordVerified = $_POST['verify-password'];
        // including our database handling script and credential verifying scripts
        require_once 'dbhandler-inc.php';
        require_once 'all-functions-inc.php';

        deleteUser($connection, $email, $password, $passwordVerified); // call the delete user function, to delete the user's account 
    }
    else { // if they somehow reach this page without using the approprite methods, kick them back to the index and exit the script 
        header("location: ../index.php"); 
        exit();
    }