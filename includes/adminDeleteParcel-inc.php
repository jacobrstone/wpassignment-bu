<?php 
if (isset($_POST['deleteParcel'])) // check the deleteParcel button has been clicked 
{
    // get data passed through the URL through POST method
    $trackingNumber = $_POST["tracking_number"];
    require_once 'dbhandler-inc.php';
    require_once 'all-functions-inc.php'; 

    deleteParcel($connection, $trackingNumber); // call delete parcel function
}
else { // send user back to login if they try to access this file without pushing the deleteParcel button
    header("location: ../login.php"); 
    exit();
}