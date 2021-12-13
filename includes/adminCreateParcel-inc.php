<?php 
if (isset($_POST['createParcel'])) // check the create parcel button has been clicked 
{
    // get data passed through the URL through POST method
    $trackingNumber = $_POST["tracking_number"];
    $orderDate = $_POST["order_date"];
    $parcelStatus = $_POST["parcel_status"];
    $streetAddress = $_POST["street_address"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $postcode = $_POST["postcode"]; 
    // call dbhandler script and all-functions script 
    require_once 'dbhandler-inc.php';
    require_once 'all-functions-inc.php'; 
    // call create parcel function to create a new parcel
    createParcel($connection, $trackingNumber, $orderDate, $parcelStatus, $streetAddress, $city, $country, $postcode); 
}
else { // send user back to the login page if they do not access this file through the button
    header("location: ../login.php"); 
    exit();
}