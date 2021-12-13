<?php  
// check the add parcel button has been clicked
if (isset($_POST['submit'])) 
{
    // get data passed through the URL through POST method
    $parcelID = $_POST["parcelid"];
    $userID = $_POST["userid"]; 
    require_once 'dbhandler-inc.php';
    require_once 'all-functions-inc.php'; 

    addParcel($connection, $parcelID, $userID); // call the add parcel function 
}
else { // if the user hasn't got to this file by pushing the add parcel button, send them away 
    header("location: ../login.php"); 
    exit();
}