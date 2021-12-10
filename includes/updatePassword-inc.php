<?php 

if(isset($_POST['updatePassword'])) { // if page is accessed by submit button
    $old_password = $_POST['oldPassword'];
    $new_password = $_POST['newPassword'];
    // including our database handling script and credential verifying scripts
    require_once 'dbhandler-inc.php';
    require_once 'register-login-functions-inc.php';

    updatePassword($connection, $old_password, $new_password); // call the delete user function, to delete the user's account 
}
else { // if they somehow reach this page without using the approprite methods, kick them back to the index and exit the script 
    header("location: ../index.php"); 
    exit();
}