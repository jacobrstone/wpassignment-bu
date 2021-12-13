<?php 
    require_once 'dbhandler-inc.php'; // including the database handling file 
    require_once 'all-functions-inc.php'; // including the main functions file 
    // get data passed through the URL through GET method
    $trackingNumber = $_GET["tracking_number_input"]; 
    $tracking = trackingExists($connection, $trackingNumber); // check the tracked parcel exists 
    if(mysqli_num_rows($tracking) === 0) // if num rows is 0, parcel does not exist 
    {
        header("location: ../index.php?error=noNumber"); 
        exit(); 
    }
    else 
    {
        header("location: ../index.php?tracking=$trackingNumber"); // if it does exist, display the number in the URL, so it can be grabbed by a GET method 
        exit(); 
    }