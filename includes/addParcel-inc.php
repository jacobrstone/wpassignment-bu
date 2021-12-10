<?php  

if (isset($_POST['submit'])) 
{
    $parcelID = $_POST["parcelid"];
    $userID = $_POST["userid"]; 
    require_once 'dbhandler-inc.php';
    require_once 'all-functions-inc.php'; 

    addParcel($connection, $parcelID, $userID); 
}
else {
    header("location: ../login.php"); 
    exit();
}