<?php 
    require_once 'dbhandler-inc.php';
    require_once 'all-functions-inc.php'; 
    $trackingNumber = $_GET["tracking_number_input"]; // saving tracking number into a variable from the user's input

    $tracking = trackingExists($connection, $trackingNumber); 

    if($tracking === false)
    {
        header("location: ../index.php?error=noNumber"); 
        exit(); 
    }
    else 
    {
        header("location: ../index.php?tracking=$trackingNumber"); 
        exit();
    }

?>
