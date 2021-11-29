<?php
// Database login credentials
$username = "s5210168";
$password = "7FnKAEM9qK7Pe7jwVEWVCFxECd4hug9V";
$host = "db.bucomputing.uk";
$port = 6612; 
$database = $username;

$connection = mysqli_init(); // Initializes MySQLi and returns a resource for use with mysqli_real_connect()
    if (!$connection) 
    { // If initalising MySQLi failed (i.e. it didn't return true, hence the ! for checking not true)
        echo "<p>Initalising MySQLi failed</p>";
    } 
    else 
    {
        // Establish secure connection using SSL for use with MySQLi
        mysqli_ssl_set($connection, NULL, NULL, NULL, '/public_html/sys_tests', NULL);

        // Connect the MySQL connection
        mysqli_real_connect($connection, $host, $username, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);
        if (mysqli_connect_errno()) 
        { // If connection error
            // Display error message and stop the script. We can't do any database work as there is no connection to use
            echo "<p>Failed to connect to MySQL. " .
            "Error (" . mysqli_connect_errno() . "): " . mysqli_connect_error() . "</p>";
        } 
    }