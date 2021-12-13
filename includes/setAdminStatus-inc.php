<?php 

if (isset($_POST['setAdmin'])) // check the setAdmin button is clicked 
{
    // get data passed through the URL through POST method
    $email = $_POST["email"];
    require_once 'dbhandler-inc.php'; // include database handling script
    require_once 'all-functions-inc.php'; // include main functions script 

    setAdmin($connection, $email); // call setAdmin function 
}
else {
    header("location: ../index.php"); // if the user somehow gets to this page without clicking the button, send them back to index 
    exit();
}