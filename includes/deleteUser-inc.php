<?php 

    if(isset($_POST['confirmDelete'])) { // if page is accessed by submit button
        $email = $_POST['email'];
        $password = $_POST['password'];
        // including our database handling script and credential verifying scripts
        require_once 'dbhandler-inc.php';
        require_once 'register-login-functions-inc.php';

        deleteUser($connection, $email, $password);
    }
    else {
        header("location: ../index.php"); 
        exit();
    }