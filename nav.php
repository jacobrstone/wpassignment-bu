<?php session_start();
    ob_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DOTS | Delivery Order Tracking Service</title>
    <link rel="stylesheet" href="CSS/style.css">  
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"> 
    <!-- jQuery and Bootstrap bundle -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="favicon/favicon.svg">
    <link rel="icon" type="image/png" href="favicon/favicon.png">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">D•O•T•S</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <?php
                if(isset($_SESSION["userid"])) // checking that the user is already logged in
                { // display these links instead, if they are logged in
                    echo "<li class='nav-item'><a class='nav-link' href='account.php'>My Account</a></li>"; 
                    echo "<li class='nav-item'><a class='nav-link' href='myParcels.php'>My Parcels</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='includes/logout-inc.php'>Log Out</a></li>"; 
                    if($_SESSION["adminStatus"] === 1) // if the user logged in is also an admin (authenticated) then display these nav links 
                    {
                        echo "<li class='nav-item'><a class='nav-link' href='AdminView_users.php'>Users</a></li>";
                        echo "<li class='nav-item'><a class='nav-link' href='AdminView_parcels.php'>Parcels</a></li>";
                        echo "<li class='nav-item'><a class='nav-link' href='AdminView.php'>Admin</a></li>";
                    }
                }
                else 
                { // if they aren't logged in, offer options to sign up or login 
                    echo "<li class='nav-item'><a class='nav-link' href='signup.php'>Sign Up</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='login.php'>Login</a></li>";
                }
                ?>
            </ul>
        </div> 
    </nav>