<?php require_once 'includes/dbhandler-inc.php'?>
<?php include_once "nav.php" ?>


<h3>Create parcel</h3>
    <form action="includes/adminCreateParcel-inc.php" method="POST">
        <input type="text" name="tracking_number" placeholder="AB012345678CD">
        <input type="date" name="order_date">
        <input type="text" name="parcel_status" placeholder="Status">
        <input type="text" name="street_address" placeholder="Street address">
        <input type="text" name="city" placeholder="City">
        <input type="text" name="country" placeholder="Country">
        <input type="text" name="postcode" placeholder="Postcode">
        <button type="submit" name="createParcel">Create Parcel</button>
    </form>
<h3>Delete parcel</h3>
    <form action="includes/adminDeleteParcel-inc.php" method="POST">
        <input type="text" name="tracking_number" placeholder="AB012345678CD">
        <button type="submit" name="deleteParcel">Delete Parcel</button>
    </form>
<h3>Admin View - Full Database Overview</h3>
    <?php 
    // Create a query that selects all fields in all tables in format <table.column>
    // Performs an INNER JOIN onto the parcel to link table, then onto the user table to the link table
    $get_parcel_data = "SELECT parcels.parcel_id, parcels.tracking_number, parcels.order_date, parcels.parcel_status, parcels.country, 
    parcels.city, parcels.street_address, parcels.postcode, Users.first_name, Users.last_name, Users.user_id, Users.email, Users.adminStatus
    FROM parcels 
    INNER JOIN user_parcel_link ON parcels.parcel_id = user_parcel_link.parcel_id
    INNER JOIN Users ON user_parcel_link.user_id = Users.user_id
    ORDER BY parcels.order_date DESC, parcels.tracking_number LIMIT 25";
    // stores the database connection data, from connectdb ($connection), and the query data $get_parcel_data into a $result variable
    $result = mysqli_query($connection, $get_parcel_data);
    mysqli_close($connection); // close the connection, as we have our data stored in result
    ?>
    <table id="adminTable" class="display"> <!-- HTML Table to format all the MySQL data -->
        <caption>Parcels</caption>
        <tr id="head">
            <th id="parcel_id">Parcel ID</th>
            <th id="tracking_number">Tracking Number</th>
            <th id="order_date">Order date</th>
            <th id="parcel_status">Status</th>
            <th id="delivery_address">Deliver to</th> 
            <th id="city">City</th>
            <th id="country">Country</th>
            <th id="postcode">Postcode</th>
            <th id="recipient">User</th>
            <th id="user_id">User ID</th>
            <th id="email">Email</th>
            <th id="email">Admin Status</th>
        </tr>
        <?php
        // fetch an associative array from the result variable, accessing each element by column name from the database
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
            { 
            echo "<tr>"; 
            echo "<td>" . $row["parcel_id"] . "</td>" .
            "<td>" . $row["tracking_number"] . "</td>" .
            "<td>" . $row["order_date"] . "</td>" . 
            "<td>" . $row["parcel_status"] . "</td>" . 
            "<td>" . $row["street_address"] . "</td>" . 
            "<td>" . $row["city"] . "</td>" .
            "<td>" . $row["country"] . "</td>" . 
            "<td>" . $row["postcode"] . "</td>" . 
            "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>" . 
            "<td>" . $row["user_id"] . "</td>" .
            "<td>" . $row["email"] . "</td>" . 
            "<td>" . $row["adminStatus"] . "</td>";
            echo "</tr>";
        }

        $errorMessage = $_GET["error"];
        switch($errorMessage)
        {
            case "stmtFailed": 
                echo "<p>Something went wrong"; 
                break;
            case "invalidTrackFormat"; 
                echo "<p>Please enter a tracking number with a valid format</p>";
                break;
        }

        ?>
    </table>

    <script>
        $(document).ready(function() {
            $('#adminTable').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "../server_side/scripts/server_processing.php"
    } );
} );
    </script>
<?php include_once "footer.php" ?>