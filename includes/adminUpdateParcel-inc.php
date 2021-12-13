<?php 

if (isset($_POST['updateParcel'])) // check the updateParcel button was clicked 
{
    // get data passed through the URL through POST method
    $parcelID = $_POST["parcel_id"];
    $trackingNumber = $_POST["tracking_number"];
    $orderDate = $_POST["order_date"];
    $parcelStatus = $_POST["parcel_status"];
    $streetAddress = $_POST["street_address"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $postcode = $_POST["postcode"]; 
    require_once 'dbhandler-inc.php';
    require_once 'all-functions-inc.php'; 
    // call updateParcel in all-functions-inc.php
    updateParcel($connection, $parcelID, $trackingNumber, $orderDate, $parcelStatus, $streetAddress, $city, $country, $postcode); 
}
else { // if the user gets to this file without pressing the button, send them to the login page
    header("location: ../login.php"); 
    exit();
}