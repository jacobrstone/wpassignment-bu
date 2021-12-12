<?php 
if (isset($_POST['createParcel'])) 
{
    $trackingNumber = $_POST["tracking_number"];
    $orderDate = $_POST["order_date"];
    $parcelStatus = $_POST["parcel_status"];
    $streetAddress = $_POST["street_address"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $postcode = $_POST["postcode"]; 
    require_once 'dbhandler-inc.php';
    require_once 'all-functions-inc.php'; 

    createParcel($connection, $trackingNumber, $orderDate, $parcelStatus, $streetAddress, $city, $country, $postcode); 
}
else {
    header("location: ../login.php"); 
    exit();
}