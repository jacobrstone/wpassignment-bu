<?php session_start(); ?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOTS | Delivery Order Tracking Service</title>
</head>
<body>
    <nav>
    <a href="home.php">Home</a>
    <?php
    if(isset($_SESSION["userid"])) 
    {
        echo "<a href='account.php'>My Account</a>"; 
        echo "<a href='includes/logout-inc.php'>Log Out</a>"; 
    }
    else 
    {
        echo "<a href='signup.php'>Sign Up</a>";
        echo "<a href='login.php'>Login</a>";
    }
    ?>
    <a href="AdminView.php">Admin</a>
    <a href="TrackerView.php">Track</a>   
    </nav>
    <hr>