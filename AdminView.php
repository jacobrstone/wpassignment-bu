<?php require_once 'includes/dbhandler-inc.php'?>
<?php include_once "nav.php" ?>
<div class="container-fluid">
    <h3>Create parcel</h3>
    <!-- Input form for creating a parcel, set placeholders for usability, maxlength for consistency and to not exceed the storage in the database -->
        <form action="includes/adminCreateParcel-inc.php" method="POST">
            <input type="text" name="tracking_number" placeholder="AB012345678CD" minlength="13" maxlength="50"> 
            <input type="date" name="order_date">
            <input type="text" name="parcel_status" placeholder="Status" maxlength="18">
            <input type="dropdown" name="street_address" placeholder="Street address" maxlength="50">
            <input type="text" name="city" placeholder="City" maxlength="50">
            <input type="text" name="country" placeholder="Country" maxlength="50">
            <input type="text" name="postcode" placeholder="Postcode" maxlength="50">
            <button class="btn btn-outline-primary btn-sm" type="submit" name="createParcel">Create Parcel</button>
        </form>
</div>
<div class="container-fluid">
    <hr>
    <h3>Delete parcel</h3>
    <form action="includes/adminDeleteParcel-inc.php" method="POST">
        <div class="input-group mb-3">
            <input class="form-control" type="text" name="tracking_number" placeholder="AB012345678CD">
            <div class="input-group-prepend">
                <button class="btn btn-outline-primary btn-sm" type="submit" name="deleteParcel">Delete Parcel</button>
            </div>
        </div>
    </form>
    <hr>
</div>
<div class="container-fluid">
    <h3>Admin View - Full Database Overview</h3>
        <!-- HTML Table to format all the MySQL data -->
        <table class="table-sm table-hover table-responsive">
            <caption>User tracked parcels</caption>
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
                //define total number of results you want per page  
                $results_per_page = 10;  
                // define the query to send to the database
                $query = "SELECT parcels.parcel_id, parcels.tracking_number, parcels.order_date, parcels.parcel_status, parcels.country, 
                parcels.city, parcels.street_address, parcels.postcode, Users.first_name, Users.last_name, Users.user_id, Users.email, Users.adminStatus
                FROM parcels
                INNER JOIN user_parcel_link ON parcels.parcel_id = user_parcel_link.parcel_id
                INNER JOIN Users ON user_parcel_link.user_id = Users.user_id
                ORDER BY parcels.order_date DESC, parcels.tracking_number;"; 
                $result_total = mysqli_query($connection, $query);  
                //find the total number of results stored in the database 
                $number_of_result = mysqli_num_rows($result_total);  
                //determine the total number of pages available  
                $number_of_page = ceil ($number_of_result / $results_per_page);  
                //determine which page number visitor is currently on  
                if (!isset ($_GET['page']) ) {  
                    $page = 1;  
                } else {  
                    $page = $_GET['page'];  
                } 

                //determine the sql LIMIT starting number for the results on the displaying page  
                $page_first_result = ($page - 1) * $results_per_page;  
                //retrieve the selected results from database   
                $get_parcel_data = "SELECT parcels.parcel_id, parcels.tracking_number, parcels.order_date, parcels.parcel_status, parcels.country, 
                parcels.city, parcels.street_address, parcels.postcode, Users.first_name, Users.last_name, Users.user_id, Users.email, Users.adminStatus
                FROM parcels
                INNER JOIN user_parcel_link ON parcels.parcel_id = user_parcel_link.parcel_id
                INNER JOIN Users ON user_parcel_link.user_id = Users.user_id
                ORDER BY parcels.order_date DESC, parcels.tracking_number LIMIT " . $page_first_result . ',' . $results_per_page;

                $result = mysqli_query($connection, $get_parcel_data);  
                
                //display the retrieved result on the webpage  
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
                echo "<nav>"; 
                echo "<ul class='pagination justify-content-center'>";
                //display the link of the pages in URL  
                for($page = 1; $page<= $number_of_page; $page++) {  
                    echo "<li class='page-item'><a class='page-link' href='AdminView.php?page=" . $page . "'>" . $page . "</a></li>";  
                } 
                echo "</ul>";
                echo "</nav>";
                // get error messages from URL, and use switch to display error messages
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
        <hr>
</div>

<?php include_once "footer.php" ?>