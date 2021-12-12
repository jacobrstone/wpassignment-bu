<?php 

if (isset($_POST['setAdmin'])) 
{
    $email = $_POST["email"];
    require_once 'dbhandler-inc.php';
    require_once 'all-functions-inc.php'; 

    setAdmin($connection, $email); 
}
else {
    header("location: ../AdminView.php"); 
    exit();
}