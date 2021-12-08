<?php session_start(); ?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOTS | Delivery Order Tracking Service</title>
    <link rel="stylesheet" href="CSS/index.css"> 
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php
            if(isset($_SESSION["userid"])) // checking that the user is already logged in
            { // display these links instead, if they are logged in
                echo "<li><a href='account.php'>My Account</a></li>"; 
                echo "<li><a href='includes/logout-inc.php'>Log Out</a></li>"; 
                echo "<li><a href='myParcels.php'>My Parcels</a></li>";
                if($_SESSION["adminStatus"] === 1)
                {
                    echo "<li><a href='AdminView.php'>Admin</a></li>";
                }
            }
            else 
            { // if they aren't logged in, offer options to sign up or login 
                echo "<li><a href='signup.php'>Sign Up</a></li>";
                echo "<li><a href='login.php'>Login</a></li>";
            }
            ?>
        </ul>
    </nav>
    <hr>