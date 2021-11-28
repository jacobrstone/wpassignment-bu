<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
            else 
            {
                echo "<p>Connected to server: " . mysqli_get_host_info($connection) . "</p>";
            }
        }
    
    $get_parcel_data = "SELECT parcels.tracking_number, parcels.order_date, parcels.parcel_status, parcels.country, parcels.city, parcels.street_address, parcels.postcode, Users.first_name, Users.last_name, Users.email 
    FROM parcels 
    INNER JOIN user_parcel_link ON parcels.parcel_id = user_parcel_link.parcel_id
    INNER JOIN Users ON user_parcel_link.user_id = Users.user_id
    ORDER BY parcels.order_date DESC, parcels.tracking_number LIMIT 25"; 

    $result = mysqli_query($connection, $get_parcel_data); 

    mysqli_close($connection);
    echo "<p>Disconnected from server: " . $host . "</p>"; 
    ?>

    <table>
        <caption>Parcels</caption>
        <tr id="head">
            <th id="tracking_number">Tracking Number</th>
            <th id="order_date">Order date</th>
            <th id="parcel_status">Status</th>
            <th id="delivery_address">Deliver to</th>
            <th id="city">City</th>
            <th id="country">Country</th>
            <th id="postcode">Postcode</th>
            <th id="recipient">User</th>
            <th id="email">Email</th>
        </tr>
        <?php
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<tr>"; 
            echo "<td>" . $row["tracking_number"] . "</td>"
            . "<td>" . $row["order_date"] . "</td>" 
            . "<td>" . $row["parcel_status"] . "</td>" 
            . "<td>" . $row["street_address"] . "</td>"
            . "<td>" . $row["city"] . "</td>"
            . "<td>" . $row["country"] . "</td>"
            . "<td>" . $row["postcode"] . "</td>"
            . "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>"
            . "<td>" . $row["email"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>