<?php 
if (isset($_POST['deleteParcel'])) 
{
    $trackingNumber = $_POST["tracking_number"];
    require_once 'dbhandler-inc.php';
    require_once 'all-functions-inc.php'; 

    deleteParcel($connection, $trackingNumber); 
}
else {
    header("location: ../login.php"); 
    exit();
}